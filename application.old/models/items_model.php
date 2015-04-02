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
}
