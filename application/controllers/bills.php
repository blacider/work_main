<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bills extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('report_model', 'reports');
        $this->load->model('usergroup_model','ug');
        $this->load->model('user_model','user');
        $this->load->library('reim_cipher');
    }

    public function download_report()
    {
        $this->need_group_casher();
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        // 重新获取
        $profile = $this->user->reim_get_user();
        log_message('debug','#####'.json_encode($profile));
        $group = $profile['data']['profile']['group'];
        if($profile){
            $config = $profile['data']['profile'];
            if(array_key_exists('group',$config))
            {
                if(array_key_exists('config',$profile['data']['profile']['group']))
                {
                    $config = $profile['data']['profile']['group']['config'];
                }
            }
            else
            {
                $config ='';
            }
        }
        $with_note = 1;
        $template = 'a4.yaml';
        if($config) {
            $config = json_decode($config,True);
            $company = urlencode($group['group_name']);

            if(($config) && (array_key_exists('export_no_company', $config)) && ($config['export_no_company'] == '0'))
                if($config && array_key_exists('export_no_company', $config) && $config['export_no_company'] == '0')
                {
                    $company = '';
                }
            $_rid = $this->input->post('chosenids');
            $rid = array();
            foreach($_rid as $r)
            {
                array_push($rid,$this->reim_cipher->encode($r));
            }

            $with_no_note = 0;
            if(($config) && (array_key_exists('export_no_note', $config)) && ($config['export_no_note']))
            {
                $with_no_note = $config['export_no_note'];
            }
            log_message('debug','note:'.$with_no_note);
            if($with_no_note == '1')
            {
                $with_note = 0;
            }
            else
            {
                $with_note = 1;
            }
            if(($config) && (array_key_exists('template', $config)) && ($config['template']))
            {
                $template = $config['template'];
            }
        }

        $archive = 1;

        log_message('debug','profile'.json_encode($profile['data']['profile']['group']));
        $url = "http://report.yunbaoxiao.com/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1";
        log_message('debug','hhh'. $url);
        die(json_encode(array('url' => $url)));
    }

    public function _logic($status = 2){
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $reports = $this->reports->get_bills();
        $_tags = $this->tags->get_list();
        $usergroups = $this->ug->get_my_list();
        if($usergroups['status']>0)
        {
            $_usergroups=$usergroups['data']['group'];
        }
        else
        {
            $_usergroups = array();
        }
        log_message('debug','usergroup:'.json_encode($usergroups));
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
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '待结算','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
                )
            );
        }
        else
        {
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '已结束'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '已结束','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
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
        $this->need_group_casher();
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_bills();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $ugs = $bills['data']['ugs'];
        $_data = array();
        foreach($data as $d){
            log_message("debug", "Bill: [ $type] $type: " . json_encode($d));
            //$_rate = 1.0;
            //if($d['currency'] && strtolower($d['currency']) != 'cny') {
            //    $_rate = $d['rate'] / 100;
            //}
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
            log_message("debug", "ugs:".json_encode($bills['data']['ugs']));

            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d['ugs'] = array();
            if($ugs)
            {
                if(array_key_exists($d['uid'],$ugs))
                {
                    $d['ugs'] = $ugs[$d['uid']];		
                }

            }
            array_push($d['ugs'],'0');
            $d['ugs'] = implode(',',$d['ugs']);
            $d['amount'] = '￥' . ($d['amount'] );
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
        $this->need_group_casher();
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
        $this->need_group_casher();
        $status = $this->input->post('status_str');
        $id = $this->input->post('id');
        $oper = $this->input->post('oper');

        if($oper == "edit"){
            die($this->reports->mark_success(implode(",", array($id))));
        }

    }


    public function marksuccess($ids = '0', $type = -1){
        $this->need_group_casher();
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
