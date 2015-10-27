<?php

class Custom_Item_Model extends Reim_Model{
    public function __construct() {
        parent::__construct();
    }


    public function drop_custom_item($id) {
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item/' . $id);
        log_message("debug", "Drop Custom Item:" . $url);
        $buf = $this->do_Delete($url, array(), $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function create_custom_item($name, $type, $category = -1) {
        $data = array (
            'name' => $name
            ,'type' => $type
            ,'printable' => 0
            ,'options' => ''
            ,'force' => 0
            ,'category' => $category
        );
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item');
        $buf = $this->do_Post($url, $data, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }


    public function list_all() {
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item');
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function set_active($id, $active = 0) {
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item');
        $buf = $this->do_Put($url, array('id' => $id, 'active' => $active), $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function update_item($id, $name, $type, $category = -1) {
        $data = array (
            'name' => $name
            ,'id' => $id
            ,'type' => $type
            ,'printable' => 0
            ,'options' => ''
            ,'force' => 0
            ,'category' => $category
        );
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item');
        $buf = $this->do_Put($url, $data, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_by_id($id = 0){
        if(0 == $id) return array();
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('custom_item/' . $id);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

}



