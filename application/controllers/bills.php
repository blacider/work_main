<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bills extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('report_model', 'reports');
        $this->load->model('usergroup_model','ug');
        $this->load->model('user_model','user');
        $this->load->model('company_model','company');
        $this->load->library('reim_cipher');
    }

    public function report_finance_deny()
    {

           $rid = $this->input->post('rid');
           $comment = $this->input->post('content');
           $buf = $this->company->deny_report_finance($rid,$comment);

            log_message('debug','comment:' . $comment);
           if($buf['status'] > 0)
           {
                $this->session->set_userdata('last_error','已拒绝');
           }
           else
           {
                $this->session->set_userdata('last_error','拒绝失败');
           }

           return redirect('bills/finance_flow');
    }
    public function report_finance_end()
    {
           $rid = $this->input->post('rid');  

           $buf = $this->company->pass_report_finance($rid);

           if($buf['status'] > 0)
           {
                $this->session->set_userdata('last_error','已通过');
           }
           else
           {
                $this->session->set_userdata('last_error','已通过');
           }

           return redirect('bills/finance_flow');
    }

    public function report_finance_multiEnd($ids = 0)
    {
        $ids = explode('%23', $ids);
        foreach ($ids as $rid) {
            $buf = $this->company->pass_report_finance($rid);

            if($buf['status'] > 0)
            {
                $this->session->set_userdata('last_error','已通过');
            }
            else
            {
                $this->session->set_userdata('last_error','已通过');
            }

        }

        return redirect('bills/finance_flow');
    }
    public function report_finance_permission($rid)
    {
        $buf = $this->company->get_report_finance_permission($rid);
        $data = array();
        if($buf['status'] > 0)
        {
           $data = $buf['status']; 
        }
        log_message('debug','permission:' . json_encode($buf));
        die(json_encode($buf));
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
        $_rid = $this->input->post('chosenids');
        $_rid = $this->input->post('chosenids');
        $rid = array();
        foreach($_rid as $r)
        {
            array_push($rid,$this->reim_cipher->encode($r));
        }
        $company = urlencode($group['group_name']);
        if($config) {
            $config = json_decode($config,True);

            if(($config) && (array_key_exists('export_no_company', $config)) && ($config['export_no_company'] == '0'))
                if($config && array_key_exists('export_no_company', $config) && $config['export_no_company'] == '0')
                {
                    $company = '';
                }

            $with_no_note = 0;
            if(($config) && (array_key_exists('export_no_note', $config)) && ($config['export_no_note']))
            {
                $with_no_note = $config['export_no_note'];
            }
            log_message('debug','note:'.$with_no_note);
            if(intval($with_no_note) == 1)
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
        //$url = "https://report.yunbaoxiao.com/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1";
        $url = "https://www.yunbaoxiao.com/report/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1";
        //$url = "http://admin.cloudbaoxiao.com:7780/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1";
        log_message('debug','hhh'. $url);
        die(json_encode(array('url' => $url)));
    }

    public function _logic($status = 2, $search = ''){
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $reports = $this->reports->get_bills($status);
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
        log_message("debug", 'reports:' . json_encode($reports));
        $data = array();
        $_data = array();
        if($reports['status']) {
            $data = $reports['data']['data'];

            foreach($data as $item) {
                if($item['status'] == 1){
                    array_push($_data, $item);
                } 
                if($item['status'] == 2){
                    array_push($_data, $item);
                } 
                if($status == 4) {
                    if(in_array($item['status'], array(4, 7, 8)))
                        array_push($_data, $item);
                }
                if($status == 1)
                {
                    array_push($_data,$item);
                }
            }
        }
        if($status == 2){
            $this->session->set_userdata("report_list_url", "bills/index");
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
                    ,'search' => urldecode($search)
                )
            );
        }
        else if($status == 4)
        {
            $this->session->set_userdata("report_list_url", "bills/exports");
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '已完成'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '已完成','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                )
            );
        }
        else if($status == 0)
        {
            $this->session->set_userdata("report_list_url", "bills/all_reports");
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '全部报告'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '全部报告','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                )
            );
        }
        else if($status == 1)
        {
            $this->session->set_userdata("report_list_url", "bills/in_progress");
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '全部报告'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '审核中','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                )
            );
        }
    }

    public function in_progress(){
        return $this->_logic(1);
    }

    public function index($search=''){
        return $this->_logic(2,$search);
    }

    public function exports($search=''){
        return $this->_logic(4,$search);
    }
    public function all_reports($search = '')

    {
        return $this->_logic(0,$search);
    }
    public function finance_flow($search = '')
    {

        $status = 1;
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $reports = $this->reports->get_finance();
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
        log_message("debug", 'reports:' . json_encode($reports));
        $data = array();
        $_data = array();
        if($reports['status']) {
            $data = $reports['data']['data'];

            foreach($data as $item) {
                log_message("debug", "alvayang:" . json_encode($item));
                    array_push($_data, $item);
                    /*
                if($item['status'] == 2){
                    array_push($_data, $item);
                } 
                if($status == 4) {
                    if(in_array($item['status'], array(4, 7, 8)))
                        array_push($_data, $item);
                }
                if($status == 1)
                {
                    array_push($_data,$item);
                }
                     */
            }
        }

        $_group = $this->groups->get_my_list();

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->session->set_userdata("report_list_url", "bills/fincance_flow");
            $this->bsload('bills/finance_flow',
                array(
                    'title' => '待审批'
                    ,'error' => $error
                    ,'members' => $gmember
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '待审批','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => 1/*$status*/
                    ,'category' => $_tags
                    ,'search' => urldecode($search)
                    ,'error' => $error
                    ,'usergroups' => $_usergroups
                )
            );
    }

    public function finance_done($search = '') {
$status = 2; 
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $reports = $this->reports->get_finance($status);
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
        log_message("debug", 'reports:' . json_encode($reports));
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
                if($status == 1)
                {
                    array_push($_data,$item);
                }
            }
        }

        $_group = $this->groups->get_my_list();

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->session->set_userdata("report_list_url", "bills/fincance_done");
            $this->bsload('bills/finance_flow',
                array(
                    'title' => '待审批'
                    ,'error' => $error
                    ,'members' => $gmember
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '已审批','class' => '')
                    )
                    ,'reports' => $data
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'search' => urldecode($search)
                    ,'usergroups' => $_usergroups
                )
            );
    }
    public function listfinance($type=2)
    {
        $this->need_group_casher();
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $bills = $this->reports->get_finance($type);
        log_message('debug','alvayang finance_reports: ' . json_encode($bills));
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
       // $ugs = $bills['data']['ugs'];
        $ugs = array();
        $_data = array();
        foreach($data as $d){
            log_message("debug", "alvayang Bill: [ $type] $type: " . json_encode($d));
            log_message("debug", "xBill: $type: " . json_encode($d));
            log_message("debug", "nICe");

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
            $d['amount'] =  sprintf("%.2f",$d['amount'] );
            $d['status_str'] = '';
            $edit = '';
            $extra = '';
            if($d['finance_status'] == 2) {
                $edit = 'gray';
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
$extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>';
            }
            if($d['finance_status'] == 1) {
                $edit = 'green';
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span><span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>';
            }


            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . ''. $extra
                . '</div>';
            array_push($_data, $d);
        }
        log_message('debug','alvayang _data:' . json_encode($_data));
        die(json_encode($_data));
    }

    public function listdata($type = 2){
        $this->need_group_casher();
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $_status = -2;
        if($type == 1) {
            $_status = -3;
        }
        $bills = $this->reports->get_bills($_status);
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $ugs = $bills['data']['ugs'];
        $_data = array();
        foreach($data as $d){
            log_message("debug", "Bill: [ $type] $type: " . json_encode($d));
            if($type !=  1) {
                if($type == 4 ) {
                    if(!in_array(intval($d['status']), array(4, 7, 8))) {
                        continue;
                    } else {
                        $d['status'] = 4;
                    }
                } else if($type != 0) {
                    if($d['status'] < 1) continue;
                    log_message("debug", "xContinue...");
                    if($d['status'] != $type) continue;
                }
            }else {
                    if($d['status'] < 1) continue;
                    if($d['status'] == 3) continue;
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
            $d['amount'] =  sprintf("%.2f",$d['amount'] );
            $d['status_str'] = '';
            $edit = '';
            $extra = '';
            if($d['status'] == 2) {
                $edit = 'green';
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>';
                //$extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span><span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>';
            }
            if($d['status'] == 4 || $d['status'] == 7 || $d['status'] == 8) {
                $edit = 'gray';
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>' ;
            }
            if($d['status'] == 1) {
                $edit = 'blue';
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
                $extra = '' ;
            }


            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . ''. $extra
                . '</div>';
            array_push($_data, $d);
        }
        log_message('debug','_data:' . json_encode($_data));
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
                //    $d['amount'] = '￥' . $d['amount'];
                $d['amount'] =  sprintf("%.2f",$d['amount'] );
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
