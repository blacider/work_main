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
        $data = array(
            $addr => $user_addr
        );
        return $this->api_post('vcode/' . $scene);
    }

    public function register($data = array()) 
    {
        return $this->api_post('register/company', $data); 
    }
}
