<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bills extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('report_model', 'reports');
    }

    public function _logic($status = 2){
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
        $_data = array();
        if($reports['status']) {
            $data = $reports['data']['data'];

            foreach($data as $item) {
                if($item['status'] == $status){
                    array_push($_data, $item);
                }
            }
        }
        $this->bsload('bills/index',
            array(
                'title' => '账单管理'
                , 'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '账单管理', 'class' => '')
                )
                ,'reports' => $data
                ,'status' => $status
                ,'category' => $_tags
                ,'error' => $error
            )
        );
    }

    public function index(){
        return $this->_logic(2);
    }

    public function exports(){
        return $this->_logic(4);
    }

    public function listcompletedata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_bills();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        foreach($data as &$d){
            log_message("debug", "Bill:" . json_encode($d));
            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d['amount'] = '￥' . $d['amount'];
            $d['status_str'] = $d['status'] == 2 ? '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>' : '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            $edit = $d['status'] != 2 ? 'gray' : 'green';
            $extra = $d['status'] == 2 ? '<span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>' : '';

            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . $extra
                . '</div>';
        }
        die(json_encode($data));
    }
    public function listdata($type = 2){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_bills();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $_data = array();
        foreach($data as $d){
            log_message("debug", "Bill: $type: " . json_encode($d));
            if($d['status'] != $type) continue;
            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d['amount'] = '￥' . $d['amount'];
            $d['status_str'] = $d['status'] == 2 ? '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>' : '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            $edit = $d['status'] != 2 ? 'gray' : 'green';
            $extra = $d['status'] == 2 ? '<span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>' : '';

            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . $extra
                . '</div>';
            array_push($_data, $d);
        }
        die(json_encode($_data));
    }

    public function save(){
        $status = $this->input->post('status_str');
        $id = $this->input->post('id');
        $oper = $this->input->post('oper');

        if($oper == "edit"){
            die($this->reports->mark_success(implode(",", array($id))));
        }

    }


    public function marksuccess($id = 0, $type = -1){
        if(0 === $id){
            $type = $this->input->post('type');
            $data = $this->input->post('data');
            $id = implode(",", $data);
            $status = 2;
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
