<?php

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

    private function get_user_agent() {
        $this->load->library('user_agent');
        $ua_str = $this->agent->agent_string();
        $uid = $this->session->userdata("uid");
        if (!$uid) {
            $uid = "none";
        }
        return "Admin,PC,1.0,$uid,$ua_str";
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

    private function fire_api_call($method, $url, $fields, $headers=array()) {
        $method = strtoupper($method);
        $ch = $this->get_curl_handler();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $headers[] = 'X-Client-IP: ' . $this->input->ip_address();
        $current_url = current_url();
        if ($current_url) {
            $headers[] = 'Referer: ' . current_url();
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        $ret = curl_exec($ch);
        $err = curl_error($ch);
        if (!empty($err)) {
            log_message('error', "api call err: $err");
        }
        return $ret;
    }

    public function get_curl_upload_field($file_path) {
        if (!class_exists('CURLFile')) {
            return '@' . realpath($file_path);
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $finfo = finfo_file($finfo, $file_path);
        $cFile = new CURLFile($file_path, $finfo, basename($file_path));
        return $cFile;
    }

    private function api_call($method, $url, $data=null, $params=null, $headers=[], $decode_json=true) {
        $url = $this->api_url_base . build_url($url, $params);
        $access_token = $this->session->userdata('oauth2_ak');
        if (!empty($access_token)) {
            $headers[] = "Authorization: Bearer $access_token";
        }
        $headers[] = 'X-ADMIN-API: 1';
        $ret = $this->fire_api_call($method, $url, $data, $headers);
        //log_message('debug', "api ret: $method $url --> $ret");
        $json_ret = json_decode($ret, true);
        if ($json_ret === null) {
            log_message('error', "api return decode error: $ret");
        }
        if (is_array($json_ret) and
            intval(array_get($json_ret, 'status', 0)) <= 0 and
            intval(array_get($json_ret, 'code', 0)) === USER_AUTH_ERROR
        ) {
            log_message('info', "api auth error while: $method $url, $ret");
            $this->session->sess_destroy();
            throw new RequireLoginError();
        }
        if (!$decode_json) {
            return $ret;
        }
        return $json_ret;
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

