<?php

class User_Model extends Reim_Model {

    public function get_user($username, $password){
        $jwt = $this->get_jwt($username, $password);
        $this->session->set_userdata('jwt', $jwt);
		$url = $this->get_url('common/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function register($email = '', $password = '', $phone = '', $code = ''){
        $data  = array('email' => $email, 'password' => $password, 'phone' => $phone, 'code' => $code);
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

}

