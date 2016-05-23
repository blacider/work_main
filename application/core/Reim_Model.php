<?php

define("PUBKEY", "1NDgzZGY1OWViOWRmNjI5ZT");

define ('USER_AUTH_ERROR', -14);

class Reim_Model extends CI_Model {

    const APP_TABLE = "tbl_apps";

    private $curl_hanlder = null;
    private $curl_timeout = 30;
    private $api_url_base = null;

    public function __construct(){
        parent::__construct();
        $this->config->load('api');
        $this->api_url_base = $this->config->item('api_url_base');
    }

    public function get_url($part, $data = array()){
        if(!empty($data)){
            $part = $part . '?' ;
            foreach($data as $k => $v){
                $part = $part . $k . '=' . $v . '&';
            }
        }
        return $this->api_url_base . $part;
    }

    private function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub = '';

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                 ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
            array();
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    private function get_user_agent() {
        $browser = $this->getBrowser();

        $uid = $this->session->userdata("uid");
        if (!$uid) {
            $uid = "none";
        }

        $name = $browser["name"];
        $version = $browser["version"];

        $result = "Admin,PC,1.0," . $uid . "," . $name . "," . $version . ",Ethernet";
        log_message("debug", $result);

        return $result;
    }

    private function get_curl_handler() {
        if ($this->curl_hanlder === null) {
            $this->curl_hanlder = curl_init();
        }
        return $this->curl_hanlder;
    }

    protected function set_curl_timeout($timeout) {
        assert(is_int($timeout));
        $this->curl_timeout = $timeout;
    }

    private function fire_api_call($method, $url, $fields, $extraheader = array()) {
        $method = strtoupper($method);
        $ch = $this->get_curl_handler();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        if (!empty($fields)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        } elseif (in_array($method, [ 'POST', 'PATCH', 'PUT', 'DELETE' ])) {
            $extraheader[] = 'Content-Length: 0';
        }
        $extraheader[] = 'X-Client-IP: ' . $this->input->ip_address();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        if (!empty($err)) {
            log_message('error', "api call err: $err");
        }
        return $result;
    }

    public function do_Post($url, $fields, $extraheader = array(), $force_bin = 0){
        return $this->api_call('POST', $url, $fields, null, $extraheader, false);
    }

    public function do_Get($url, $extraheader=array()) {
        return $this->api_call('GET', $url, null, null, $extraheader, false);
    }

    public function do_Put($url, $fields, $extraheader = array()){
        return $this->api_call('PUT', $url, $fields, null, $extraheader, false);
    }

    public function do_Delete($url, $fields, $extraheader = array()){
        return $this->api_call('DELETE', $url, $fields, null, $extraheader, false);
    }

    public function get_curl_upload_field($file_path  = '') {
        if('' == $file_path) return '';
        if (class_exists('CURLFile')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $finfo = finfo_file($finfo, $file_path);
            $cFile = new CURLFile($file_path, $finfo, basename($file_path));
            return $cFile;
        } else {
            return '@' . realpath($file_path);
        }
        return '';
    }

    private function api_call($method, $url, $data=null, $params=null, $headers=[], $decode_json=true) {
        if (!empty($params)) {
            if (false === strpos($url, '?')) {
                $url = $url . '?';
            }
            $url = $url . http_build_query($params);
        }
        if (0 !== strpos($url, 'http')) {
            $url = $this->api_url_base . $url;
        }
        $access_token = $this->session->userdata('oauth2_ak');
        if (!empty($access_token)) {
            $auth_header = "Authorization: Bearer $access_token";
            $headers[] = $auth_header;
        }
        $headers[] = 'X-ADMIN-API: 1';
        $ret = $this->fire_api_call($method, $url, $data, $headers);
        $json_ret = json_decode($ret, true);
        if (is_array($json_ret) and
            array_key_exists('code', $json_ret) and
            $json_ret['code'] == USER_AUTH_ERROR
        ) {
            log_message('error', "api auth error while: $method $url");
            $this->session->sess_destroy();
            throw new RequireLoginError();
        }
        if ($decode_json) {
            return $json_ret;
        }
        return $ret;
    }

    public function __call($name, $args) {
        $magic_api_methods = ['api_get', 'api_post', 'api_put', 'api_delete'];
        if (!in_array($name, $magic_api_methods)) {
            throw new Exception("called unknown method: $name");
        }
        $http_method = strtoupper(explode('_', $name)[1]);
        array_unshift($args, $http_method);
        return call_user_func_array([$this, 'api_call'], $args);
    }

}


class BaseException extends Exception {}

class RequireLoginError extends BaseException {}

