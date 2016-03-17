<?php

class Items_Model extends Reim_Model {

    public function get_item_type_name()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('item_type_name');
        $buf = $this->do_Get($url, $jwt);
        log_message('debug','item_type_name_url:' . $url);
        log_message('debug','item_type_name_back:' . $buf);
        $obj = json_decode($buf, True);
        return $obj;
    }

    public function update_item_type_name($type,$name,$description)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('item_type_name/' . $type);
        $data = array(
            'type' => $type,
            'name' => $name,
            'description' => $description
        );
        $buf = $this->do_Put($url,$data,$jwt);
        log_message('debug','update_item_type_name_url:' . $url);
        log_message('debug','update_item_type_name_data:' . json_encode($data));
        log_message('debug','update_item_type_name_back:' . $buf);
        $obj = json_decode($buf, True);
        return $obj;
    }

    public function get_typed_currency()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('typed_currency');
        $buf = $this->do_Get($url, $jwt);
        log_message('debug','typed_currency_url:' . $url);
        log_message('debug','typed_currency_back:' . $buf);
        $obj = json_decode($buf, True);
        return $obj;
    }

    public function get_currency()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('currency');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, True);
        return $obj;
    }

    public function attachment($content,$filename,$mime)
    {
        log_message('debug','qqy content: ' . $content);
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('attachment');
        $data = array(
            "content" => $this->get_curl_upload_field($content),
            "filename" => $filename,
            "mime" => $mime,
        );
        // 自定义超时时间20分钟
        $this->set_curl_timeout(1200);
        $buf = $this->do_Post($url, $data, $jwt);
        log_message('debug','attachment_data:' . json_encode($data));
        log_message('debug','attachment_url:' . json_encode($url));
        log_message('debug','attachment_back:' . $buf);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function update_item($id,$opts){
        $items = array();
        $data = array(
              "iid" => $id
              ,"opts" => json_encode($opts)
             );
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('update_item');
        $buf = $this->do_Post($url, $data, $jwt);
        $obj = json_decode($buf, true);
        log_message('debug','update_item_data:'. json_encode($data));
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


    public function get_suborinate($me = 0, $filter='all'){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('subordinate_reports/'. $me . "/0/9999999");
        $url = $url . '?' . http_build_query(['filter' => $filter]);
        $buf = $this->do_Get($url, $jwt);
        //log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function upload_image($image_path, $type){
        $jwt = $this->session->userdata('jwt');
        $file = realpath($image_path);
        if(!$jwt) return false;
        $data = array();
        $file = $this->get_curl_upload_field($image_path);
        $data = array('file' => $file, 'type' => $type);
        $url = $this->get_url('images');
        $buf = $this->do_Post($url, $data, $jwt, 1);
        $obj = json_decode($buf, true);
        return $obj;
    }


    public function create($data)
    {
        $items = array();
        $s = array(
            'local_id' => 1,
            'category' => $data['category'],
            'amount' => $data['amount'],
            'uids' => $data['uids'],
            'prove_ahead' => $data['type'],
            'afford_ids' => $data['afford_ids'],
            'image_id' => $data['images'],
            'dt' => $data['dt'], 
            'end_dt' => $data['end_dt'], 
            'note' => $data['note'],
            'reimbursed' => 1,
            'tags' => $data['tags'], 
            'location' => '',
            'latitude' => 0,
            'longitude' => 0,
            'merchants' => $data['merchant'],
            'attachment_ids' => $data['attachments'],
            'type' => 1,
            'currency' => $data['currency'],
            'customization' => $data['customization']
        );
        array_push($items, $s);
        if(array_key_exists('rid',$data)){
            $_data['rid'] = $data['rid'];
        }
        $_data['items'] = json_encode($items);
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item');
        $buf = $this->do_Post($url, $_data, $jwt, 1);
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
        log_message('debug', 'get_item_url:' . $url);
        log_message('debug', 'get_item_back:' . $buf);
        $obj = json_decode($buf, true);
        return $obj;

    }

    public function update($data){
        $items = array();
        $s = array(
            'id' => $data['id'],
            'local_id' => 1,
//<<<<<<< HEAD
            'category' => $data['category'],
            'amount' => $data['amount'],
            'uids' => $data['uids'],
            'prove_ahead' => $data['type'],
            'afford_ids' => $data['afford_ids'],
            'image_id' => $data['images'],
            'dt' => $data['dt'], 
            'end_dt' => $data['end_dt'], 
            'note' => $data['note'],
            'reimbursed' => 1,
            'tags' => $data['tags'], 
            'location' => '',
            'latitude' => 0,
            'longitude' => 0,
            'merchants' => $data['merchant'],
            'attachment_ids' => $data['attachments'],
            'type' => 1,
            'currency' => $data['currency'],
            'customization' => $data['customization']
        );
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
