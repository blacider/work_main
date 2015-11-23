<?php

class Report_Model extends Reim_Model {

    public function confirm_success($rid)
    {
    	$jwt = $this->session->userdata('jwt');
	    if(!$jwt) return false;
        $url = $this->get_url('success');
        $data = array(
            'act' => 'confirm',
            'status' => 2,
            'rids' => $rid
        );
	    $buf = $this->do_Put($url,$data,$jwt);
	    log_message('debug','confirm_success_url:'.$url);
	    log_message('debug','confirm_success_data:'.json_encode($data));
	    log_message('debug','confirm_success_back:'.$buf);

	    return json_decode($buf,True);
    }

    public function update_report_template($id,$name,$config,$type)
    {
    	$jwt = $this->session->userdata('jwt');
	    if(!$jwt) return false;
        $url = $this->get_url('report_template/' . $id);
        $data = array(
            'id' => $id,
            'type' => $type,
            'name' => $name,
            'config' => json_encode($config)
        );
	    $buf = $this->do_Put($url,$data,$jwt);
	    log_message('debug','report_template_url:'.$url);
	    log_message('debug','report_template_data:'.json_encode($data));
	    log_message('debug','report_template_back:'.$buf);

	    return json_decode($buf,True);
    }

    public function create_report_template($name,$config)
    {
    	$jwt = $this->session->userdata('jwt');
	    if(!$jwt) return false;
        $url = $this->get_url('report_template');
        $data = array(
            'name' => $name,
            'config' => $config
        );
	    $buf = $this->do_Post($url,$data,$jwt);
	    log_message('debug','report_template_url:'.$url);
	    log_message('debug','report_template_data:'.json_encode($data));
	    log_message('debug','report_template_back:'.$buf);

	    return json_decode($buf,True);
    }

    public function get_report_template($id = 0)
    {
    	$jwt = $this->session->userdata('jwt');
	    if(!$jwt) return false;
        if(0 == $id)
        	$url = $this->get_url('report_template');
        else
            $url = $this->get_url('report_template/' . $id);
	    $buf = $this->do_Get($url,$jwt);
	    log_message('debug','report_template_url:'.json_encode($url));
	    log_message('debug','report_template_back:'.$buf);

	    return json_decode($buf,True);
    }

    public function delete_report_template($id)
    {
    	$jwt = $this->session->userdata('jwt');
	    if(!$jwt) return false;
        $url = $this->get_url('report_template/' . $id);
	    $buf = $this->do_Delete($url,array(),$jwt);
	    log_message('debug','delete_report_template_url:'.json_encode($url));
	    log_message('debug','delete_report_template_back:'.$buf);

	    return json_decode($buf,True);
    }

    public function add_comment($rid,$comment)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('report/'.$rid);
        $data=array(
            'comment'=>$comment
        );
        $buf = $this->do_Put($url,$data,$jwt);
        log_message("debug","add_comment:".json_encode($buf));
        return $buf;
    }

    public function revoke($rid)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('revoke/'.$rid);
        $buf = $this->do_Get($url,$jwt);
        log_message('debug','######'.json_encode($buf));

        return $buf;
    }
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
        log_message("debug", "DETELE )))))))) :" . json_encode($jwt));
        log_message("debug", "From Server [ $url ]:" . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_bills($status = -2){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
        $url = $this->get_url("bills/" . $status);
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_finance($status = 1){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        //log_message("debug", "JWT:" . json_encode($jwt));
        $url = $this->get_url("report_finance_flow/list/" . $status);
        $buf = $this->do_Get($url, $jwt);
        //log_message("debug", "report_finance_flow:" . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function get_all_bills(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        log_message("debug", "JWT:" . json_encode($jwt));
        $url = $this->get_url("bills/2");
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", "From Server [ $url ]:" . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function create($title, $receiver, $cc, $iids, $type = 0, $status = 1, $force = 0, $extra = array(),$template_id){
        $data = array(
            'manager_id' => $receiver
            ,'cc' => $cc
            ,'type' => $type
            ,'status' => $status
            ,'title' => $title
            ,'iids' => $iids
            ,'createdt' => time()
            ,'force_submit' => $force
            ,'extras' => json_encode($extra)
            ,'template_id' => $template_id
        );
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url("report");
        $buf = $this->do_Post($url, $data, $jwt);
        log_message('debug','create_report_data:' . json_encode($data));
        log_message('debug','create_report_url:' . $url);
        log_message('debug','create_report_back:' . $buf);
        return $buf;

    }

    public function update($id, $title, $receiver, $cc, $iids, $type = 0, $status = 1, $force = 0, $extra = array(),$template_id){
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
            ,'force_submit' => $force
            ,'extras' => json_encode($extra)
            ,'template_id' => $template_id
        );
        log_message("debug", "Update:" . json_encode($data));
		$url = $this->get_url("report/$id");
        $buf = $this->do_Put($url, $data, $jwt);
		$obj = json_decode($buf, true);
        log_message("debug", "URL:" . $url);
        log_message("debug", "update_report_data:" . json_encode($data));
        log_message("debug", "update_report_back:" . $buf);
        return $buf;

    }

    public function get_report_by_id($id) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        //log_message("debug", "Update:" . json_encode($data));
        $url = $this->get_url("report/$id");
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
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
        $url = $this->get_url("report_flow/$rid/1");
        $buf = $this->do_Get($url, $jwt);
        log_message("debug","report_flow:" . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function submit_check($manager_ids, $iids){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url("check_submit_flow");
        $data = array('iids' => $iids, 'manager_ids' => $manager_ids);
        $buf = $this->do_Post($url, $data, $jwt);
        return $buf;
    }
}
