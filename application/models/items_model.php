<?php

class Items_Model extends Reim_Model {

    public function get_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('sync/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function get_exports($id, $mail){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'rid' => $id
            ,'email' => $mail
        );
		$url = $this->get_url('exports/' . $id);
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function admin_list($email = ''){
        if($email == "") return array();
        $jwt = $this->get_admin_jwt();
        if(!$jwt) return false;
		$url = $this->get_url('admin/invoice');
        $buf = $this->do_Post($url, array('name' => $email), $jwt);
        log_message("debug", $buf);
        return $buf;
		//$obj = json_decode($buf, true);
        //return $obj;
    }

    public function admin_detail($id = 0){
        if($id == 0) return array();
        $jwt = $this->get_admin_jwt();
        if(!$jwt) return false;
		$url = $this->get_url('admin/invoice/' . $id);
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        return $buf;
    }


    public function get_suborinate($me = 0){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('subordinate_reports/'. $me . "/0/9999999");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
