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

}

