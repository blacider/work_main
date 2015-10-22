<?php

class Items_Model extends Reim_Model {

    public function get_currency()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('currency');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function update_item($id, $amount, $category, $tags, $dt, $merchant, $type, $note, $images,$extra, $uids = ''){
        $items = array();
        $s = array(
	    array('type' => 1,'val' => $category)
	    ,array('type' => 2,'val' => $note)
	    ,array('type' => 3,'val' => $tags)
	    ,array('type' => 4,'val' => $merchant)
	    ,array('type' => 6,'val' => $amount)
	    ,array('type' => 8,'val' => $dt)
	    ,array('type' => 9,'val' => $extra)
	    );
        $data = array(
		      "iid" => $id
		      ,"opts" => json_encode($s)
		     );
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('update_item');
        $buf = $this->do_Post($url, $data, $jwt);
        $obj = json_decode($buf, true);
        log_message('debug','update_item_back:'.$buf);
        return $obj;
    }
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

    public function upload_image($image_path, $type){
        $jwt = $this->session->userdata('jwt');
        $file = realpath($image_path);
        //array_push($jwt, 'Content-Type: '. $type);
        log_message("debug", $file);
        if(!$jwt) return false;
        $data = array();
        $fileSize = filesize($image_path);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $finfo = finfo_file($finfo, $image_path);
        log_message("debug", "xiamian shi finfo");
        log_message("debug", $fileSize);
        log_message("debug", $image_path);
        log_message("debug", basename($image_path));
        $cFile = new CURLFile($image_path, $finfo, basename($image_path));
        //$cFile = new CURLFile($image_path, $finfo, 'testpic');
        //$cFile = new CURLFile($image_path);
        $data = array('file' => $cFile, 'type' => $type);
        $url = $this->get_url('images');
        $buf = $this->do_Post($url, $data, $jwt, 1);
        $obj = json_decode($buf, true);
        return $obj;
    }


    public function create($amount, $category, $tags, $dt, $merchant, $type, $note, $images,$extra, $uids = '', $afford_ids = -1 , $currency){
        $items = array();
        $s = array(
            'local_id' => 1,
            'category' => $category,
            'amount' => $amount,
            'category' => $category,
            'uids' => $uids,
            'prove_ahead' => $type,
            'afford_ids' => $afford_ids,
            'image_id' => $images,
            'dt' => $dt, 
            'note' => $note,
            'reimbursed' => 1,
            'tags' => $tags, 
            'location' => '',
            'latitude' => 0,
            'longitude' => 0,
            'merchants' => $merchant,
            'type' => 1,
            'currency' => $currency,
	    'extra' => $extra);
        array_push($items, $s);
        $data = array('items' => json_encode($items));
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item');
        $buf = $this->do_Post($url, $data, $jwt, 1);
        log_message('debug','item_create_data:' . json_encode($data));
        log_message('debug','item_create_url:' . json_encode($url));
        log_message('debug','item_create_back:' . json_encode($buf));
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($id = 0){
        if($id == 0) return false;
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item/'. $id);
        $data = array();
        $buf = $this->do_Delete($url, $data, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_by_id($id = 0){
        if(0 === $id) return array();
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item/'. $id);
        $data = array();
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;

    }

    public function update($id, $amount, $category, $tags, $dt, $merchant, $type, $note, $images,$extra, $uids = '',$fee_afford_ids=-1, $currency){
        $items = array();
        $s = array(
            'local_id' => 1,
            'id' => $id,
            'category' => $category,
            'amount' => $amount,
            'category' => $category,
            'uids' => $uids,
            'prove_ahead' => $type,
            'image_id' => $images,
            'dt' => $dt, 
            'note' => $note,
            'reimbursed' => 1,
            'tags' => $tags, 
            'location' => '',
            'latitude' => 0,
            'longitude' => 0,
            'merchants' => $merchant,
            'type' => 1,
            'afford_ids' => $fee_afford_ids,
            'currency' => $currency,
	    'extra' => $extra);
        array_push($items, $s);
        $data = array('items' => json_encode($items));
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item');
        $buf = $this->do_Put($url, $data, $jwt, 1);
        log_message('debug','update_item_data:' . json_encode($data));
        log_message('debug','update_item_url:' . json_encode($url));
        log_message('debug','update_item_back:' . json_encode($buf));
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function item_flow($iid){
        if(0 === $iid) return array();
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url("item_flow/". $iid);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

}
