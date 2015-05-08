<?php

class UserGroup_Model extends Reim_Model {
    public function get_my_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('user_group/list');
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function update_data($uids, $name){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'uids' => $uids
        );
        log_message("debug", json_encode($data));
		$url = $this->get_url('user_group');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
