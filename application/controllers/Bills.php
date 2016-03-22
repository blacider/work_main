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
        $this->load->model('reim_show_model','reim_show');
        $this->load->library('reim_cipher');
        $this->load->helper('report_view_utils');
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

           if ($buf['status'] > 0) {
                $this->session->set_userdata('last_error','已通过');
           } else {
                $this->session->set_userdata('last_error',$buf['data']['msg']);
           }

           return redirect('bills/finance_flow');
    }

    public function report_finance_multiEnd($ids = 0)
    {
        $ids = explode('%23', $ids);
        foreach ($ids as $rid) {
            $buf = $this->company->pass_report_finance($rid);

            if ($buf['status'] > 0) {
                $this->session->set_userdata('last_error','已通过');
            } else {
                $this->session->set_userdata('last_error',$buf['data']['msg']);
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
    public function download_single_report()
    {
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
        $footer_format = 0;
        $template = 'a4.yaml';
        $_splite_by_category = 0;
        $_rid = $this->input->post('chosenids');
        $_rid = $this->input->post('chosenids');
        $rid = array();
        foreach($_rid as $r)
        {
            array_push($rid,$this->reim_cipher->encode($r));
        }
        $company = urlencode($group['group_name']);
        $hide_merchants = 0;
        if($config) {
            $config = json_decode($config,True);
            $with_no_note = 0;
            if(($config) && (array_key_exists('export_no_note', $config)) && ($config['export_no_note']))
            {
                $with_no_note = $config['export_no_note'];
            }
            if(($config) && (array_key_exists('hide_merchants', $config)) && ($config['hide_merchants']))
            {
                $hide_merchants = $config['hide_merchants'];
            }
            $_splite_by_category = 0;
            if(($config) && (array_key_exists('footer_format', $config)) && ($config['footer_format']))
            {
                $footer_format = $config['footer_format'];
            }
            if(($config) && (array_key_exists('same_category_pdf', $config)) && ($config['same_category_pdf']))
            {
                $_splite_by_category = $config['same_category_pdf'];
            }
            //log_message('debug','note:'.$with_no_note);

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
        // 需要获取部门信息
        // 0 -- 无
        // 1 -- 仅公司名称
        // 2 -- 仅部门名称
        // 3 -- 公司/部门
        $url = "https://www.yunbaoxiao.com/report/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1&catetable=" . $_splite_by_category . '&footer_format=' . $footer_format . "&hide_merchants=" . $hide_merchants;
        //$url = "http://admin.cloudbaoxiao.com:12345/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1&catetable=" . $_splite_by_category . '&footer_format=' . $footer_format . "&hide_merchants=" . $hide_merchants;
        log_message('debug','hhh'. $url);
        die(json_encode(array('url' => $url)));
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
        $_top_group = '';
        if($profile){
            $config = $profile['data']['profile'];
            if(array_key_exists('usergroups',$config) && count($config['usergroups']) > 0) {
                $_top_group = $config['usergroups'][0]['name'];
            }
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
        $_splite_by_category = 0;
        $footer_format = 0;
        foreach($_rid as $r)
        {
            array_push($rid,$this->reim_cipher->encode($r));
        }
        $company = urlencode($group['group_name']);
        $hide_merchants = 0;
        if($config) {
            $config = json_decode($config,True);
            $with_no_note = 0;
            if(($config) && (array_key_exists('export_no_note', $config)) && ($config['export_no_note']))
            {
                $with_no_note = $config['export_no_note'];
            }
            if(($config) && (array_key_exists('hide_merchants', $config)) && ($config['hide_merchants']))
            {
                $hide_merchants = $config['hide_merchants'];
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
            $_splite_by_category = 0;
            if(($config) && (array_key_exists('footer_format', $config)) && ($config['footer_format']))
            {
                $footer_format = $config['footer_format'];
            }
            if(($config) && (array_key_exists('same_category_pdf', $config)) && ($config['same_category_pdf']))
            {
                $_splite_by_category = $config['same_category_pdf'];
            }
            if(($config) && (array_key_exists('template', $config)) && ($config['template']))
            {
                $template = $config['template'];
            }
        }

        $archive = 1;
        $url = "https://www.yunbaoxiao.com/report/report?rid=" . implode(',',$rid) . "&with_note=" . $with_note ."&company=" . $company ."&template=" . $template . "&archive=1&catetable=" . $_splite_by_category . '&footer_format=' . $footer_format . "&hide_merchants=" . $hide_merchants;
        log_message('debug','hhh'. $url);
        die(json_encode(array('url' => $url)));
    }

    public function _logic($status){
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        // 获取当前所属的组

        $keyword = $this->input->get('keyword');
        $dept = $this->input->get('dept');
        $search = $keyword;
        $startdate = $this->input->get('startdate');
        $enddate = $this->input->get('enddate');

        $startdate = $this->input->get('startdate');
        if(!$startdate || !$enddate) {
            $startdate = date("Y-m-d", strtotime("-30 day"));
            $enddate = date('Y-m-d');
        }

        $query = array(
            'keyword' => $this->input->get('keyword'),
            'dept' => $this->input->get('dept'),
            'search' => $keyword,
            'startdate' => $startdate,
            'enddate' => $enddate
        );

        $usergroups = $this->ug->get_my_list();
        if($usergroups['status']>0) {
            $_usergroups=$usergroups['data']['group'];
        }
        else {
            $_usergroups = array();
        }
        log_message('debug','usergroup:'.json_encode($usergroups));
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
                    ,'status' => $status
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                    ,'query' => $query
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
                    ,'status' => $status
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                    ,'query' => $query
                )
            );
        }
        else if($status == 0)
        {
            $this->session->set_userdata("report_list_url", "bills/all_reports");
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '全部报销单'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '全部报销单','class' => '')
                    )
                    ,'status' => $status
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                    ,'query' => $query
                )
            );
        }
        else if($status == 1)
        {
            $this->session->set_userdata("report_list_url", "bills/in_progress");
            $this->session->set_userdata('item_update_in','3');
            $this->bsload('bills/index',
                array(
                    'title' => '全部报销单'
                    ,'error' => $error
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '审核中','class' => '')
                    )
                    ,'status' => $status
                    ,'usergroups' => $_usergroups
                    ,'search' => urldecode($search)
                    ,'query' => $query
                )
            );
        }
    }

    public function all_reports($search = '')
    {
        return $this->_logic(0, $search);
    }

    public function in_progress() {
        return $this->_logic(1);
    }

    public function index($search='') {
        return $this->_logic(2,$search);
    }

    public function finished($search=''){
        return $this->_logic(4,$search);
    }
    
    public function finance_flow($search = '')
    {

        $this->need_group_casher();
        $status = 1;
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组

        $submit_startdate = $this->input->get('submit_startdate');
        $submit_enddate = $this->input->get('submit_enddate');

        if(!$submit_startdate || !$submit_enddate) {
            $submit_startdate = date("Y-m-d", strtotime("-30 day"));
            $submit_enddate = date('Y-m-d');
        }

        $this->session->unset_userdata('last_error');
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
        // log_message('debug','usergroup:'.json_encode($usergroups));
        if($_tags && array_key_exists('tags', $_tags['data'])){
            $_tags = $_tags['data']['tags'];
        }
        $_group = $this->groups->get_my_list();

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->session->set_userdata("report_list_url", "bills/finance_flow");
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
                ,'status' => 1/*$status*/
                ,'category' => $_tags
                ,'search' => urldecode($search)
                ,'error' => $error
                ,'usergroups' => $_usergroups
                ,'query' => array(
                    'keyword' => $this->input->get('keyword'),
                    'dept' => $this->input->get('dept'),
                    'submit_startdate' => $submit_startdate,
                    'submit_enddate' => $submit_enddate,
                    'approval_startdate' => '',
                    'approval_enddate' => ''
                )
            )
        );
    }

    public function finance_by_status($status) {
        $this->need_group_casher();

        $keyword = $this->input->get('keyword');
        $dept = $this->input->get('dept');
        $submit_startdate = $this->input->get('submit_startdate');
        $submit_enddate = $this->input->get('submit_enddate');
        $approval_startdate = $this->input->get('approval_startdate');
        $approval_enddate = $this->input->get('approval_enddate');

        $bills = $this->reports->get_report_by_status_and_query(
            $status, 
            $keyword,
            $dept,
            $submit_startdate,
            $submit_enddate,
            $approval_startdate,
            $approval_enddate
        );

        $item_type_dic = $this->reim_show->get_item_type_name();
        $report_template_dic = $this->reim_show->get_report_template();

        if($bills['status'] < 1) {
            die(array());
        }
        $data = $bills['data']['data'];
        $_data = array();
        foreach($data as $d){
            if(array_key_exists('has_attachment',$d) && $d['has_attachment'])
            {
                $url = base_url('reports/show/' . $d['id']);
                $d['attachments'] = '<a href=' . htmlspecialchars($url) . '><img style="width:25px;height:25px" src="/static/images/default.png"></a>';
            }

            $prove_ahead = get_report_type_str($item_type_dic,$d['prove_ahead'],$d['pa_approval']);
            $d['prove_ahead'] = $prove_ahead;

            if(array_key_exists('template_id',$d) && array_key_exists($d['template_id'],$report_template_dic))
            {
                $d['report_template'] = $report_template_dic[$d['template_id']];
            }
            $d['date_str'] = date('Y-m-d H:i:s', $d['submitdt']);
            $d["approvaldt_str"] = "0000-00-00 00:00:00";
            if (array_key_exists("approvaldt", $d)) {
                $d["approvaldt_str"] = date('Y-m-d H:i:s', $d["approvaldt"]);
            }
            $d['amount'] =  sprintf("%.2f",$d['amount'] );
            $d['status_str'] = get_report_status_str($d['status']);
            $edit = '';
            $extra = '';
            if($d['status'] == 2) {
                $edit = 'green';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span><span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>';
            }
            if($d['status'] == 4 || $d['status'] == 7 || $d['status'] == 8) {
                $edit = 'gray';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>' ;
            }
            if($d['status'] == 1) {
                $edit = 'blue';
                $extra = '';
            }
            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . ''. $extra
                . '</div>';
            array_push($_data, $d);
        }
        //log_message('debug','alvayang _data:' . json_encode($_data));
        $bills['data'] = $_data;
        die(json_encode($bills['data']));
    }


    public function finance_done() {
        $approval_startdate = $this->input->get('approval_startdate');
        $approval_enddate = $this->input->get('approval_enddate');

        $submit_startdate = $this->input->get('submit_startdate');
        $submit_enddate = $this->input->get('submit_enddate');

        if(!$submit_startdate || !$submit_enddate) {
            $submit_startdate = $submit_enddate = '';
        }

        if(!$approval_startdate) {
            if(!$this->input->get('submit_startdate') && !$this->input->get('submit_enddate')) {
                $approval_startdate = date("Y-m-d", strtotime("-30 day"));
                $approval_enddate = date('Y-m-d');
            }
        }
        $status = 2;
        $this->need_group_casher();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $_tags = $this->tags->get_list();
        $usergroups = $this->ug->get_my_list();
        if($usergroups['status']>0) {
            $_usergroups=$usergroups['data']['group'];
        }
        else {
            $_usergroups = array();
        }
        log_message('debug','usergroup:'.json_encode($usergroups));
        if($_tags && array_key_exists('tags', $_tags['data'])){
            $_tags = $_tags['data']['tags'];
        }

        $_group = $this->groups->get_my_list();

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->session->set_userdata("report_list_url", "bills/finance_done");
            $this->bsload('bills/finance_flow',
                array(
                    'title' => '已审批'
                    ,'error' => $error
                    ,'members' => $gmember
                    , 'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('bills/index'), 'name' => '财务核算', 'class' => '')
                        ,array('url' => '','name' => '已审批','class' => '')
                    )
                    ,'status' => $status
                    ,'category' => $_tags
                    ,'error' => $error
                    ,'search' => urldecode('')
                    ,'usergroups' => $_usergroups
                    ,'query' => array(
                        'keyword' => $this->input->get('keyword'),
                        'dept' => $this->input->get('dept'),
                        'submit_startdate' => $submit_startdate,
                        'submit_enddate' => $submit_enddate,
                        'approval_startdate' => $approval_startdate,
                        'approval_enddate' => $approval_enddate
                    )
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

        $item_type_dic = $this->reim_show->get_item_type_name();
        $report_template_dic = $this->reim_show->get_report_template();

        log_message('debug','alvayang finance_reports: ' . json_encode($bills));
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $ugs = array();
        $_data = array();
        foreach($data as $d){
            if(array_key_exists('has_attachment',$d) && $d['has_attachment'])
            {
                $url = base_url('reports/show/' . $d['id']);
                $d['attachments'] = '<a href=' . htmlspecialchars($url) . '><img style="width:25px;height:25px" src="/static/images/default.png"></a>';
            }

            $prove_ahead = get_report_type_str($item_type_dic,$d['prove_ahead'],$d['pa_approval']);
            $d['prove_ahead'] = $prove_ahead;

            if(array_key_exists('template_id',$d) && array_key_exists($d['template_id'],$report_template_dic))
            {
                $d['report_template'] = $report_template_dic[$d['template_id']];
            }
            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            $d["approvaldt_str"] = "0000-00-00 00:00:00";
            if (array_key_exists("approvaldt", $d)) {
                $d["approvaldt_str"] = date('Y-m-d H:i:s', $d["approvaldt"]);
            }
            $d['amount'] =  sprintf("%.2f",$d['amount'] );
            $d['status_str'] = get_report_status_str($d['status']);
            $edit = '';
            $extra = '';
            if($d['status'] == 2) {
                $edit = 'green';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span><span class="ui-icon ui-icon ace-icon fa fa-check tapprove green" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon ui-icon red ace-icon fa fa-times tdeny" data-id="' . $d['id'] . '"></span>';
            }
            if($d['status'] == 4 || $d['status'] == 7 || $d['status'] == 8) {
                $edit = 'gray';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>' ;
            }
            if($d['status'] == 1) {
                $edit = 'blue';
                $extra = '';
            }
            $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . ''. $extra
                . '</div>';
            array_push($_data, $d);
        }
        //log_message('debug','alvayang _data:' . json_encode($_data));
        die(json_encode($_data));
    }

    public function listdata($status){
        $this->need_group_casher();


        $keyword =  $this->input->get('keyword');
        $dept =  $this->input->get('dept');
        $startdate =  $this->input->get('startdate');
        $enddate =  $this->input->get('enddate');

        $bills = $this->reports->get_bills_by_status_and_query($status, $keyword, $dept, $startdate, $enddate);
        $item_type_dic = $this->reim_show->get_item_type_name();
        $report_template_dic = $this->reim_show->get_report_template();
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $ugs = $bills['data']['ugs'];
        $_data = array();
        foreach($data as $d){
            if(array_key_exists('has_attachment', $d) && $d['has_attachment'])
            {
                $url = base_url('reports/show/' . $d['id']);
                $d['attachments'] = '<a href=' . htmlspecialchars($url) . '><img style="width:25px;height:25px" src="/static/images/default.png"></a>';
            }
            $prove_ahead = get_report_type_str($item_type_dic,$d['prove_ahead'],$d['pa_approval']);
            $d['prove_ahead'] = $prove_ahead;

            if(array_key_exists('template_id',$d) && array_key_exists($d['template_id'],$report_template_dic))
            {
                $d['report_template'] = $report_template_dic[$d['template_id']];
            }

            if($status !=  1) {
                if($status == 4 ) {
                    if(!in_array(intval($d['status']), array(4, 7, 8))) {
                        continue;
                    } else {
                        $d['status'] = 4;
                    }
                } else if($status != 0) {
                    if($d['status'] < 1) continue;
                    log_message("debug", "xContinue...");
                    if($d['status'] != $status) continue;
                }
            }else {
                    if($d['status'] < 1) continue;
                    if($d['status'] == 3) continue;
            }

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
            $d['status_str'] = get_report_status_str($d['status']);
            $edit = '';
            $extra = '';
            if($d['status'] == 2) {
                $edit = 'green';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>';
            }
            if($d['status'] == 4 || $d['status'] == 7 || $d['status'] == 8) {
                $edit = 'gray';
                $extra = '<span class="ui-icon ui-icon grey ace-icon fa fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table1" data-toggle="modal"></span>' ;
            }
            if($d['status'] == 1) {
                $edit = 'blue';
                $extra = '' ;
            }

            $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . ''. $extra
                . '</div>';
            array_push($_data, $d);
        }
        die(json_encode($_data));
    }

    public function get_finance_report_by_ids() {
        $this->need_group_casher();
        $chosenids = $this->input->get('ids');
        $chosenids = array_values(array_filter(array_map('intval', explode('|', $chosenids))));
        $bills = $this->reports->get_finance_report_by_ids($chosenids);
        if($bills['status'] < 1){
            die(json_encode(array()));
        }
        $data = $bills['data']['data'];
        $_data = array();
        foreach($data as $d){
            $d['date_str'] = date('Y-m-d H:i:s', $d['createdt']);
            //    $d['amount'] = '￥' . $d['amount'];
            $d['amount'] =  sprintf("%.2f",$d['amount'] );
            $d['status_str'] = $d['status'] == 2 ? '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>' : '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            $edit = $d['status'] != 2 ? 'gray' : 'green';
            $extra = $d['status'] = '';

            $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                          . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . $extra
                          . '</div>';
            array_push($_data, $d);
        }
        die(json_encode($_data));
    }
}
