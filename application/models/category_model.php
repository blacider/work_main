<?php
class Category_Model extends Reim_Model {

    public function get_afford_project()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('fee_afford_project/0');
        $buf = $this->do_Get($url,$jwt);
        log_message('debug','afford_list:' . $buf);
        return json_decode($buf,True);
    }
    
    public function del_fee_afford_project($id)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('fee_afford_project/' . $id);
        $buf = $this->do_Delete($url,array(),$jwt);
        log_message('debug','afford_delete_url:' . $url);
        log_message('debug','afford_delete:' . $buf);
        return json_decode($buf,True);
    }

    public function expense_create($name)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('fee_afford_project');
        $data = array('name' => $name);
        $buf = $this->do_Post($url,$data,$jwt);
        log_message('debug','expense_create:' . $buf);
        log_message('debug','expense_create_data:' . $name);
        return json_decode($buf,True);
    }

    public function get_custom_item()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('custom_item');
        $buf = $this->do_Get($url,$jwt);
        log_message('debug','custom_item_back:' . $buf);
        return json_decode($buf,True);
    }


    public function get_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('common/0');
		$buf = $this->do_Get($url, $jwt);
        //log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
    
    public function create_update($cid = 0,$pid,$sob_id, $name, $avatar,$code,$force_attach,$note, $max_limit = 0 , $extra_type)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
		'name' => $name
		,'pid' => $pid
		,'sob_id' => $sob_id
		,'avatar' => $avatar
		,'sob_code' => $code
		,'force_attachement' => $force_attach
		,'note' => $note
        ,'limit' => $max_limit
        ,'extra_type' => $extra_type
	);

	if(0 == $cid)
	{
		$url = $this->get_url('category');
		$buf = $this->do_Post($url,$data,$jwt);
		log_message('debug','create_category:' . $buf);
	}
	else
	{
		$url = $this->get_url('category/' . $cid);
		$buf = $this->do_Put($url,$data,$jwt);
		log_message('debug','update_category:' . $buf);
	}
		log_message('debug','update_category_data:' . json_encode($data));
	
	return json_decode($buf,True);

    }
    	
    public function create($name, $pid, $sob_id, $prove_ahead = 0, $maxlimit = 0, $note = "", $sob_code = 0 , $avatar = 0, $force_attach = 0 , $extra_type=0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'sob_id' => $sob_id
            ,'note' => $note
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
            ,'sob_code' => $sob_code
            ,'avatar' => $avatar
            ,'force_attachement' => $force_attach
            ,'extra_type' => $extra_type
        );
		$url = $this->get_url('category');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
    public function update($cid, $name, $pid, $sob_id, $prove_ahead = 0, $maxlimit = 0, $note = "", $sob_code = 0 , $avatar = 0,$force_attach , $extra_type) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'sob_id' => $sob_id
            ,'sob_code' => $sob_code
            ,'note' => $note
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
	    ,'avatar' => $avatar
            ,'force_attachement' => $force_attach
            ,'extra_type' => $extra_type
        );
		$url = $this->get_url('category/' . $cid);
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($cid){
        $jwt = $this->session->userdata('jwt');
        //log_message("debug", "JWT: " $jwt);
        if(!$jwt) return false;
		$url = $this->get_url('category/' . $cid);
		$buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
