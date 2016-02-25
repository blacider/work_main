<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Register_Model extends Reim_Model {

    public function vcode_verify($addr = 'email', $user_addr = '', $vcode = ''){
        $_url = 'vcode/verify?';
        $url = $this->get_url('vcode/verify');
        $data = array(
            $addr => $user_addr,
            'vcode' => $vcode
        ); 
        foreach($data as $k => $v)
        {
            $_url = $_url . $k . "=" . $v . "&"; 
        }

        log_message("debug","data:" . json_encode($data));
        $url = $this->get_url($_url);
        $buf = $this->do_Get($url,'');
        log_message("debug","vcode_verify_back:" . $buf);

        return json_decode($buf,true);
    }

    public function getvcode($addr = 'email',$user_addr = '')    
    {
        $url = $this->get_url('vcode/register');
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
        return json_decode($data,true);
    }
}
