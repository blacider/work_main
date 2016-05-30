<?php
class Tags_Model extends Reim_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function get_list(){
        return $this->user_model->get_common();
    }

    public function create($name) {
        $data = array(
            'name' => $name
        );
        return $this->api_post('tags', $data);
    }

    public function update($cid, $name) {
        $data = array(
            'name' => $name
        );
        return $this->api_put('tags/' . $cid, $data);
    }

    public function remove($cid){
        return $this->api_delete('tags/' . $cid);
    }

}
