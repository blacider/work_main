<?php

class Report_Model extends Reim_Model {

    public function get_detail($rid){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
		$url = $this->get_url("report/$rid");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function delete_report($rid){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
		$url = $this->get_url("report/$rid");
		$buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function get_bills(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
		$url = $this->get_url("bills/2");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function mark_success($data){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
		$url = $this->get_url("success");
        $buf = $this->do_Post($url, array('rids' => $data), $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
		//$obj = json_decode($buf, true);
        return $buf;
    }


}
