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
                if($item['status'] == 2){
                    array_push($_data, $item);
                } 
                if($status == 4) {
                    if(in_array($item['status'], array(4, 7, 8)))
                        array_push($_data, $item);
                }
            }
        }
	if($status == 2){
	$this->session->set_userdata('item_update_in','2');
        $this->bsload('bills/index',
            array(
                'title' => '待结算'
                , 'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
		    ,array('url' => '','name' => '待结算','class' => '')
                )
                ,'reports' => $data
                ,'status' => $status
                ,'category' => $_tags
                ,'error' => $error
            )
        );
	}
	else
	{
	$this->session->set_userdata('item_update_in','3');
	$this->bsload('bills/index',
            array(
                'title' => '已结束'
                , 'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
		    ,array('url' => '','name' => '已结束','class' => '')
                )
                ,'reports' => $data
                ,'status' => $status
                ,'category' => $_tags
                ,'error' => $error
            )
	);
	}
    }

    public function index(){
        return $this->_logic(2);
    }

    public function exports(){
        return $this->_logic(4);
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
            log_message("debug", "Bill: [ $type] $type: " . json_encode($d['status']));
            if($type == 4 ) {
                if(!in_array(intval($d['status']), array(4, 7, 8))) {
                    log_message("debug", "Continue...");
                    continue;
                }
            } else {
                log_message("debug", "xContinue...");
                if($d['status'] != $type) continue;
            }
            log_message("debug", "xBill: $type: " . json_encode($d));
            log_message("debug", "nICe");

            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d['amount'] = '￥' . $d['amount'];
            $d['status_str'] = $d['status'] == 2 ? '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>' : '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            $edit = $d['status'] != 2 ? 'gray' : 'green';
            $extra = $d['status'] == 2 ? '<span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>' : '';

            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>'. $extra
                . '</div>';
            array_push($_data, $d);
        }
        die(json_encode($_data));
    }

        public function listdata_new($type = 2){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_bills();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $_data = array();
        $chosenids = $_SERVER["REQUEST_URI"];
        $chosenids = explode('/', $chosenids);
        $chosenids = array_splice($chosenids, 4);
        $chosenids[count($chosenids)-1] = explode('?', $chosenids[count($chosenids)-1])[0];
        foreach($data as $d){
            if (in_array($d['id'], $chosenids)) {
                log_message("debug", "Bill: $type: " . json_encode($d));
                if($d['status'] != $type) continue;
                $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
                $d['amount'] = '￥' . $d['amount'];
                $d['status_str'] = $d['status'] == 2 ? '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>' : '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
                $edit = $d['status'] != 2 ? 'gray' : 'green';
                $extra = $d['status'] = '';

                $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . $extra
                    . '</div>';
                array_push($_data, $d);
            }
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


    public function marksuccess($ids = '0', $type = -1){
        $ids = explode('%23', $ids);
        foreach ($ids as $id ) {
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
            }
        }
        redirect(base_url('bills'));
    }

}
