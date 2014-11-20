<?php

define("API_SERVER", "http://stage.rushucloud.com/stage/");
define("PUBKEY", "1NDgzZGY1OWViOWRmNjI5ZT");

class Reim_Model extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->library('JWT', 'jwt');
    }


    public function get_url($part){
        return API_SERVER . $part;
    }

	public function get_jwt($username, $password, $server_token = ''){
        if(!$server_token) $server_token = $this->session->userdata('server_token');
		$users  = array(
			'email' => $username
			,'password' => $password
			,'device_type' => 'admin'
			,'device_token' => ''
            ,'server_token' => $server_token
		);
		return $this->get_header($users);
	}


	private function get_header($config){
		return array('X-REIM-JWT: ' . JWT::encode($config, PUBKEY), 'X-ADMIN-API: 1');
	}
    
    public function do_Post($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url) ;
        curl_setopt($ch, CURLOPT_POST, count($fields)) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        if($extraheader) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        }
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        log_message("debug", "Start Request");
        $result  = ob_get_contents() ;
        log_message("debug", "Get Success");
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Get($url, $extraheader = array()){

        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        log_message("debug", "Start Request");
        $output = curl_exec($ch) ;
        log_message("debug", "Get Success");
        curl_close($ch);
        return $output;
    }

    public function do_Put($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch , CURLOPT_POST, count ( $fields )) ;
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Delete($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        //curl_setopt($ch , CURLOPT_POST, count ($fields)) ;
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }
}

