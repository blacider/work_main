<?php

class Items_Model extends Reim_Model {

    public function get_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('sync/0');
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
