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
        $tags = $this->tags->get_list();
        if($tags){
            $tags = $tags['data']['tags'];
        }
        log_message("debug", json_encode($reports));
        $data = array();
        if($reports['status'])
            $data = $reports['data']['data'];
        $this->bsload('bills/index',
            array(
                'title' => '财务核算'
                ,'reports' => $data
                ,'category' => $tags
                ,'error' => $error
            )
        );
    }


    public function listdata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_bills();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        foreach($data as &$d){
            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d['status_str'] = $d['status'] == 2 ? '<font color="red">待付款</font>' : '<font color="grey">已完成</font>';
            $edit = $d['status'] != 2 ? 'gray' : 'green';
            $extra = $d['status'] == 2 ? '<span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>' : '';

            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . $extra
                . '</div>';
        }
        die(json_encode($data));
    }

    public function save(){
        $status = $this->input->post('status_str');
        $id = $this->input->post('id');
        $oper = $this->input->post('oper');

        if($oper == "edit"){
            die($this->reports->mark_success(implode(",", array($id))));
        }

    }


    public function marksuccess($id = 0, $type = 0){
        if(0 === $id){
            $type = $this->input->post('type');
            $data = $this->input->post('data');
            $id = implode(",", $data);
            $status = 3;
            if(0 === $type) {
                $status = 4;
            }
            die($this->reports->mark_success($id, $status));
        } else {
            $status = 3;
            if(0 === intval($type)) {
                $status = 4;
            }
            $this->reports->mark_success($id, $status);
            redirect(base_url('bills'));
        }
    }

}
