<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bills extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('report_model', 'reports');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $reports = $this->reports->get_bills();
        $_tags = $this->tags->get_list();
        if($_tags && array_key_exists('tags', $_tags['data'])){
            $_tags = $_tags['data']['tags'];
        }
        log_message("debug", json_encode($reports));
        $data = array();
        if($reports['status'])
            $data = $reports['data']['data'];
        $this->eload('bills/index',
            array(
                'title' => '财务核算'
                ,'reports' => $data
                ,'category' => $_tags
                ,'error' => $error
            )
        );
    }


    public function marksuccess(){
        $data = $this->input->post('data');
        die($this->reports->mark_success(implode(",", $data)));
    }

}
