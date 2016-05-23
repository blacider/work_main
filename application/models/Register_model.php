<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Register_Model extends Reim_Model {

    public function vcode_verify($addr = 'email', $user_addr = '', $vcode = ''){
        $parms = array(
            $addr => $user_addr,
            'vcode' => $vcode
        ); 
        return $this->api_get('vcode/verify', null, $parms);
    }

    public function getvcode($addr = 'email',$user_addr = '',$scene = 'register')    
    {
        $url = $this->get_url('vcode/' . $scene);
        $data = array(
            $addr => $user_addr
        ) ;

        $buf = $this->do_Post($url,$data,'');
        log_message("debug","getvcode_back:" . $buf);
        return json_decode($buf,true);
    }

    public function register($data = array()) 
    {
        $url = $this->get_url('register/company'); 
        $buf = $this->do_Post($url,$data,'');
        log_message("debug","register_back:" . $buf);
        return json_decode($buf,true);
    }
}
