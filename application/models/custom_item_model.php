<?php

class Custom_Item_Model extends Reim_Model{
    public function __construct() {
        parent::__construct();
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


}



