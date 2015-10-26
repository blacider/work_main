<?php

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
    
    public function do_Post($url, $fields, $extraheader = array(), $force_bin = 0){
        $ch  = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url) ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_POST, count($fields)) ;
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        if($extraheader) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        }
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Get($url, $extraheader = array()){
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_VERBOSE, false) ;
        $output = curl_exec($ch) ;
        curl_close($ch);
        return $output;
    }

    public function do_Put($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        curl_setopt($ch , CURLOPT_POST, count ( $fields )) ;
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_VERBOSE, true) ;
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
        curl_setopt($ch, CURLOPT_USERAGENT, $this->get_user_agent());
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ;
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
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

