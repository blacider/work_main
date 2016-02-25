<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Register_Model extends Reim_Model {

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
