<?php

class Report_Model extends Reim_Model {

    public function sendout($rid,$email)
    {
    	$jwt = $this->session->userdata('jwt');
	if(!$jwt) return false;
	$url = $this->get_url('exports');
	$data = array(
		'rid' => $rid
		,'email' => $email
	);
	$buf = $this->do_Post($url,$data,$jwt);
	log_message("debug","send_report".json_encode($buf));
	return $buf;
    }
    public function get_permission($rid) {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", $rid);
        $url = $this->get_url("check_approval_permission/$rid");
        $buf = $this->do_Get($url,$jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
        //$obj = json_decode($buf, true);
        return $buf;
    }
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


    public function mark_success($data, $status = 4){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
		$url = $this->get_url("success");
        $buf = $this->do_Put($url, array('rids' => $data, 'status' => $status), $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
		//$obj = json_decode($buf, true);
        return $buf;
    }

    public function create($title, $receiver, $cc, $iids, $type = 0, $status = 1){
        $data = array(
            'manager_id' => $receiver
            ,'cc' => $cc
            ,'type' => $type
            ,'status' => $status
            ,'title' => $title
            ,'iids' => $iids
            ,'createdt' => time()
        );
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url("report");
        $buf = $this->do_Post($url, $data, $jwt);
		$obj = json_decode($buf, true);
        return $buf;

    }

    public function update($id, $title, $receiver, $cc, $iids, $type = 0, $status = 1){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'manager_id' => $receiver
            ,'cc' => $cc
            ,'type' => $type
            ,'status' => $status
            ,'title' => $title
            ,'iids' => $iids
            ,'createdt' => time()
        );
        log_message("debug", "Update:" . json_encode($data));
		$url = $this->get_url("report/$id");
        log_message("debug", "URL:" . $url);
        $buf = $this->do_Put($url, $data, $jwt);
		$obj = json_decode($buf, true);
        return $buf;

    }


    public function get_reports_by_ids($ids) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'ids' => $ids
        );
        log_message("debug", "Update:" . json_encode($data));
		$url = $this->get_url("reports");
        $buf = $this->do_Post($url, $data, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function audit_report($rid, $status, $receivers, $content = '') {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'status' => $status
            ,'manager_id' => $receivers
            ,'comment' => $content
        );
        log_message("debug", "Update:" . json_encode($data));
		$url = $this->get_url("report/$rid");
        $buf = $this->do_Put($url, $data, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function report_flow($rid){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url("report_flow/$rid");
        $buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
