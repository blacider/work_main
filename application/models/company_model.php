<?php

class Company_Model extends Reim_Model {
   // const MIN_UID = 100000;
    public function __construct(){
        parent::__construct();
    }

        public function get(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('company_admin');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function profile($same_category, $prove_ahead = 0, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'same_category' => $same_category
	    ,
        );
        $url = $this->get_url('company_admin');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function update($cid, $name, $pid, $prove_ahead = 0, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
        );
        $url = $this->get_url('category/' . $cid);
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($cid){
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . $jwt);
        if(!$jwt) return false;
        $url = $this->get_url('category/' . $cid);
        $buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

}
