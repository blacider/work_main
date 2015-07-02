<?php

//define("API_SERVER", "http://api.rushucloud.com/stage/");
//define("API_SERVER", "https://api.cloudbaoxiao.com/online/");
define("API_SERVER", "https://api.cloudbaoxiao.com/online/");
define("PUBKEY", "1NDgzZGY1OWViOWRmNjI5ZT");

class Reim_Model extends CI_Model {

    const USER_TABLE = "tbl_user";
    const APP_TABLE = "tbl_apps";

    public function __construct(){
        parent::__construct();
        $this->load->library('JWT', 'jwt');
    }



    public function get_url($part){
        return API_SERVER . $part;
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
    
    public function do_Post($url, $fields, $extraheader = array(), $force_bin = 0){
        log_message("debug", json_encode($fields));
        $ch  = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url) ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_POST, count($fields)) ;
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //if($force_bin == 1){
        //curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        //}
        if($extraheader) {
            log_message("debug", json_encode($extraheader));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        }
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        log_message("debug", "Start Request");
        $result  = ob_get_contents() ;
        log_message("debug", "Get Success" . $result);
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Get($url, $extraheader = array()){

        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        log_message("debug", "Start Request");
        $output = curl_exec($ch) ;
        log_message("debug", "Get Success:" . $output);
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
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

