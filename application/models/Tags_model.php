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
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
        );
		$url = $this->get_url('tags');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
    public function update($cid, $name) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
        );
		$url = $this->get_url('tags/' . $cid);
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($cid){
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . $jwt);
        if(!$jwt) return false;
		$url = $this->get_url('tags/' . $cid);
		$buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

}
