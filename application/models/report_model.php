<?php

class Report_Model extends Reim_Model {
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

}
