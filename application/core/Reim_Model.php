<?php

define("PUBKEY", "1NDgzZGY1OWViOWRmNjI5ZT");

class Reim_Model extends CI_Model {

    const USER_TABLE = "tbl_user";
    const APP_TABLE = "tbl_apps";

    private $curl_hanlder = null;
    private $curl_timeout = 30;
    private $api_url_base = null;

    public function __construct(){
        parent::__construct();
        $this->load->library('JWT', 'jwt');
        $this->config->load('api');
        $this->api_url_base = $this->config->item('api_url_base');
    }

    public function get_url($part){
        return $this->api_url_base . $part;
    }

    public function get_jwt($username, $password, $server_token = '',$device_type = 'admin'){
        if(!$username){
            $username = $this->session->userdata('email');
            $password = $this->session->userdata('password');
        } else {
            $this->session->set_userdata('email', $username);
            $this->session->set_userdata('password', $password);
        }
        if("" === $server_token){
            $server_token = $this->session->userdata('server_token');
        }
        $users  = array(
            'email' => $username
            ,'password' => $password
            ,'device_type' => $device_type
            ,'device_token' => ''
            ,'server_token' => $server_token
        );
        log_message("debug", "Header:" . json_encode($users));
        return $this->get_header($users, $device_type != "admin");
    }

    public function get_admin_jwt(){
        $config = array(
            'device_type' => 'invoice'
        );
        return array('X-REIM-JWT: ' . JWT::encode($config, PUBKEY), 'X-ADMINUI-API: 1');
    }

    private function get_header($config, $without_admin = 0){
        if($without_admin) {
            return array('X-REIM-JWT: ' . JWT::encode($config, PUBKEY));
        } else {
            return array('X-REIM-JWT: ' . JWT::encode($config, PUBKEY), 'X-ADMIN-API: 1');
        }
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

        $mail = $this->session->userdata("email");
        if (!$mail)
            $mail = "none";

        $name = $browser["name"];
        $version = $browser["version"];

        $result = "Admin,PC,1.0," . $mail . "," . $name . "," . $version . ",Ethernet";
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
        # TODO support query
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
        }
        if (!empty($extraheader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        }
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
        return $this->fire_api_call('POST', $url, $fields, $extraheader);
    }

    public function do_Get($url, $extraheader=array()) {
        return $this->fire_api_call('GET', $url, [], $extraheader);
    }

    public function do_Put($url, $fields, $extraheader = array()){
        return $this->fire_api_call('PUT', $url, $fields, $extraheader);
    }

    public function do_Delete($url, $fields, $extraheader = array()){
        return $this->fire_api_call('DELETE', $url, $fields, $extraheader);
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

}

