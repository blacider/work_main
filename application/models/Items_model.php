<?php

class Items_Model extends Reim_Model {

    public function get_item_type_name()
    {
        return $this->api_get('item_type_name');
    }

    public function update_item_type_name($type,$name,$description)
    {
        $data = array(
            'type' => $type,
            'name' => $name,
            'description' => $description
        );
        return $this->api_put('item_type_name/' . $type, $data);
    }

    public function get_typed_currency()
    {
        return $this->api_get('typed_currency');
    }

    public function get_currency()
    {
        return $this->api_get('currency');
    }

    public function attachment($content,$filename,$mime)
    {
        $this->set_curl_timeout(1200);
        $data = array(
            "content" => $this->get_curl_upload_field($content),
            "filename" => $filename,
            "mime" => $mime,
        );
        return $this->api_post('attachment', $data);
    }

    public function update_item($id,$opts){
        $data = array(
            "iid" => $id,
            "opts" => json_encode($opts)
        );
        return $this->api_post('update_item', $data);
    }

    public function get_list(){
        return $this->api_get('sync/0');
    }

    public function get_exports($id, $mail){
        $data = array(
            'rid' => $id,
            'email' => $mail
        );
        return $this->api_post('exports/' . $id, $data);
    }

    public function get_suborinate($me = 0, $filter='all'){
        $query = ['filter' => $filter];
        return $this->api_get('subordinate_reports/'. $me . "/0/9999999", null, $query);
    }

    public function upload_image($image_path, $type){
        $file = $this->get_curl_upload_field($image_path);
        $data = array('file' => $file, 'type' => $type);
        return $this->api_post('images', $data);
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
        if(array_key_exists('rid', $data)){
            $_data['rid'] = $data['rid'];
        }
        $_data['items'] = json_encode($items);
        return $this->api_post('item', $_data);
    }

    public function remove($id = 0){
        if($id == 0) return false;
        return $this->api_delete('item/'. $id);
    }

    public function get_by_id($id = 0){
        if(0 === $id) return array();
        return $this->api_get('item/'. $id);
    }

    public function update($data){
        $items = array();
        $s = array(
            'id' => $data['id'],
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
        $data = array('items' => json_encode($items));
        //log_message('debug','update_item_data:' . json_encode($data));
        $obj = $this->api_put('item', $data);
        //log_message('debug','update_item_back:' . json_encode($obj));
        return $obj;
    }

    public function item_flow($iid){
        if(0 === $iid) return array();
        return $this->api_get("item_flow/". $iid);
    }

}
