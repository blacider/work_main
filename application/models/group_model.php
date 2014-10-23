<?php

class Group_Model extends Reim_Model {
    public function get_my_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('groups/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    // type : -0 邮箱 1 手机
    public function set_invite($username = '', $type = 0){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $username, 'type' => $type);
		$url = $this->get_url('invite');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function change_group_name($name){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $name);
		$url = $this->get_url('groups');
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		//$obj = json_decode($buf, true);
        return $buf;
    }

    public function setadmin($uid){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('admin' => 'update', 'uid' => $uid);
		$url = $this->get_url('users');
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }

    public function create_group($name){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $name);
		$url = $this->get_url('groups');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }
}

