<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model', 'category');
        $this->load->model('items_model', 'items');
    }

    public function index(){
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        $url = 'invoice/index';
        if(!($profile || $uid)){
        } else {
            $url = 'invoice/search';
            $this->aeload($url, array(
                'title' => '搜索用户'
            ));
        }
    }

    public function search(){
        $uid = $this->session->userdata('uid');
        if(!$uid) return redirec(base_url('invoice'));
        $email = $this->input->post('name');
        // 查找这个人所有的report
        die($this->items->admin_list($email));
    }


    public function detail($id = 0){
        if($id == 0) return redirec(base_url('invoice'));
        $uid = $this->session->userdata('uid');
        if(!$uid) return redirec(base_url('invoice'));
        $data = $this->items->admin_detail($id);
    }
}
