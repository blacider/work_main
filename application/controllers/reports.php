<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
        $this->load->model('user_model', 'users');
        $this->load->model('report_model', 'reports');
        $this->load->model('group_model','groups');
    }

    public function add_comment() {
        $rid=$this->input->post("rid");
        $comment = $this->input->post("comment");
        $buf = $this->reports->add_comment($rid,$comment);
        redirect(base_url('reports/show/' . $rid));
    }

    public function revoke($id = 0) {
        $buf = $this->reports->revoke($id);
        return redirect('reports');
    }

    public function sendout() {
        $rid = $this->input->post('report_id');	
        $email = $this->input->post('email');
        $buf = $this->reports->sendout($rid,$email);
        log_message("debug","###".json_encode($buf));
        die($buf);
    }

    public function index($type = 1) {
        $items = $this->items->get_suborinate($type);
        if(!$items['status']){
            return redirect(base_url('items'));
        }
        $this->session->set_userdata('item_update_in','1');
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $ret = array();
        if(!$items) redirect(base_url('login'));
        $item_data = array();
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['data'];
        }
        $this->bsload('reports/index',
            array(
                'title' => '我的报告'
                ,'items' => $item_data
                ,'error' => $error
                ,'type' => $type
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                    ,array('url'  => '', 'name' => '我的报告', 'class' => '')
                ),
            ));
    }

    public function _getitems(){
        $items = $this->items->get_list();
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }
        $_items =  array();
        if($items && $items['status']) {
            $_cates = array();
            foreach($categories as $c){
                $_cates[$c['id']] = $c['category_name'];
            }
            $data = $items['data'];
            $item_data = $data['items'];
            foreach($item_data as &$s){
                if($s['istatus'] < 0) continue;
                $s['cate_str'] = '未指定的分类';
                $s['createdt'] = strftime("%Y-%m-%d %H:%M", intval($s['createdt']));
                $_type = '报销';
                switch($s['type']){
                case 1: {$_type = '预借';};break;
                case 2: {$_type = '预算';};break;
                }
                $s['type'] = $_type;

                if(array_key_exists($s['category'], $_cates)){
                    $s['cate_str'] = $_cates[$s['category']];
                }
                $_report = '尚未添加到报告';
                if($_report) {
                }
                $s['report'] = $_report;
                $s['img_str'] = $s['image_id'] == "" ? '无发票' : '有发票';
                $images = explode(',', $s['image_paths']);
                if(count($images) > 0){
                    $s['img_str'] = '';
                    foreach($images as $i){
                        if($i){
                            $d = explode(".", $i);
                            $sufix = array_pop($d);
                            $last = array_pop($d);
                            $last .= "_32";
                            array_push($d, $last);
                            array_push($d, $sufix);
                            $i = implode(".", $d);
                            $s['img_str'] .= '<span><img src="http://reim-avatar.oss-cn-beijing.aliyuncs.com/' . $i . '"></span>';
                        }
                    }
                }
//                $s['amount'] = '￥' . $s['amount'];
            $s['amount'] = sprintf("%.2f",$s['amount']);
                $s['status_str'] = '';
                $trash= $s['istatus'] === 0 ? 'gray' : 'red';
                $edit = $s['istatus'] === 0 ? 'gray' : 'green';
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $s['id'] . '"></span></div>';
                switch($s['istatus']){
                case 0: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
                };break;
                case 1: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
                };break;
                case 2: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
                };break;
                case 3: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#B472B1;background:#B472B1 !important;">退回</button>';
                };break;
                case 4: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
                };break;
                case 5: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
                };break;
                case 6: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#42B698 !important;">待支付</button>';
                };break;
                default: {
                    $s['status_str'] = $s['status'];
                }
                }
                array_push($_items, $s);
            }
        }
        return $_items;
    }

    public function newreport() {
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }

        $_items = $this->_getitems();
        log_message('debug',json_encode($_items));

        $this->bsload('reports/new',
            array(
                'title' => '新建报告',
                'members' => $_members,
                'items' => $_items
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                    ,array('url'  => '', 'name' => '新建报告', 'class' => '')
                ),
            ));
    }

    public function listdata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $items = $this->items->get_suborinate();
        if(!$items['status']){
            die(json_encode(array()));
        }

        $data = $items['data']['data'];
        foreach($data as &$d){
            $trash= $d['status'] === 1 ? 'gray' : 'red';
            $edit = ($d['status'] === 1)   ? 'gray' : 'green';
            $export = ($d['status'] === 1)   ? 'gray' : 'grey';
            if($d['status'] == 1) {
                $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span></div>';
                //. '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span></div>';
            } else {
                if(in_array($d['status'],array(2,4,5)))
                {
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $export . '  fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span></div>';
                    //. '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span></div>';
                } else if (in_array($d['status'],array(0,3))) {
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $d['id'] . '"></span></div>';
                }
                else
                {
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                        //. '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $d['id'] . '"></span></div>';
                }
            }
            $d['date_str'] = date('Y年m月d日', $d['createdt']);
            $d['status_str'] = '待提交';
            //$d['amount'] = '￥' . $d['amount'];
            $prove_ahead = '报销';
            switch($d['prove_ahead']){
            case 2: {$prove_ahead = '<font color="red">预借</font>';};break;
            case 1: {$prove_ahead = '<font color="green">预算</font>';};break;
            }
            $d['prove_ahead'] = $prove_ahead;
            switch($d['status']) {
            case 0: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
            };break;
            case 1: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
            };break;
            case 2: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
            };break;
            case 3: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#B472B1;background:#B472B1 !important;">退回</button>';
            };break;
            case 4: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 5: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 6: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#42B698 !important;">待支付</button>';
            };break;
            case 7: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成待确认</button>';
            };break;
            case 8: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成已确认</button>';
            };break;
            }
            $d['date_str'] = date('Y年m月d日', $d['createdt']);
            $d['status_str'] = '待提交';
            //$d['amount'] = '￥' . $d['amount'];
        /*
                $prove_ahead = '报销';
                switch($d['prove_ahead']){
                case 2: {$prove_ahead = '<font color="red">预借</font>';};break;
                case 1: {$prove_ahead = '<font color="green">预算</font>';};break;
                }
                $d['prove_ahead'] = $prove_ahead;

         */
            switch($d['status']) {
            case 0: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
            };break;
            case 1: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
            };break;
            case 2: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
            };break;
            case 3: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#B472B1;background:#B472B1 !important;">退回</button>';
            };break;
            case 4: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 5: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 6: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#42B698 !important;">待支付</button>';
            };break;
            case 7: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成待确认</button>';
            };break;
            case 8: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成已确认</button>';
            };break;
            }
        }
        die(json_encode($data));
    }

    public function detail($id){
        if($id == 0) {
            return redirect(base_url('reports/index'));
        }
        $obj = $this->reports->get_detail($id);
        die(json_encode($obj));
        //return redirect(base_url('reports/index'));
    }

    public function create(){
        $items = $this->input->post('item');
        if(''==$items)
        {
            $this->session->set_userdata('last_error','提交报告不能为空');
            return redirect(base_url('reports/index')); 
        }
        $title = $this->input->post('title');
        $receiver = $this->input->post('receiver');
        $cc = $this->input->post('cc');
        $force = $this->input->post('force');
        $template_id = $this->input->post('template_id');
        $extra = array();
        if($template_id) {
            // 获取并构造extra
            $_account = $this->input->post('account');
            $_payment = $this->input->post('payment');
            $_borrowing = $this->input->post('borrowing');
            $_location_from = $this->input->post('location_from');
            $_location_to = $this->input->post('location_to');
            $_period_start = $this->input->post('period_start');
            $_period_end = $this->input->post('period_end');
            $_contract = $this->input->post('contract');
            $_contract_note = $this->input->post('contract_note');
            $_note = $this->input->post('note');
            $_contract = $_contract == 2 ? 0 : 1;
            $extra = array(
                'template_id' => $template_id
                ,'borrowing' => $_borrowing
                ,'account' => $_account
                ,'payment' => $_payment
                ,'period' => array('start' => $_period_start, 'end' => $_period_end)
                ,'location' => array('start' => $_location_from, 'dest' => $_location_to)
                ,'contract' => array('available' => $_contract, 'note' => $_contract_note)
                ,'note' => $_note
            );
        }
        if(!$cc) $cc = array();
        if(!$force) $force = 0;
        $save = $this->input->post('renew');
        $ret = $this->reports->create($title, implode(',', $receiver), implode(',', $cc), implode(',', $items), 0, $save, $force, $extra);
        $ret = json_decode($ret, true);
        if($ret['code'] <= 0) {
            log_message("debug", "Cates:" . $ret['code']);
            if($ret['code'] == -71)
            {
                log_message("debug", "Cates:" . json_encode(-71));
                $quota = $ret['data']['quota'];
                $str = '';
                $info = $this->category->get_list();
                if($info['status'] > 0)
                {
                    $_categories = $info['data']['categories'];
                }
                else
                {
                    $_categories = array();
                }
                $categories = array();

                foreach($_categories as $cate)
                {
                    $categories[$cate['id']] = $cate['category_name'];
                }
                foreach($quota as $key => $q)
                {
                    $str = $str . $categories[$key] . ' ';
                }	
                $this->session->set_userdata('last_error', $str . '金额超出公司月度限额，是否仍要提交');
            } elseif($ret['code'] == -63) {
                $info = $this->category->get_list();
                if($info['status'] > 0) {
                    $_categories = $info['data']['categories'];
                } else {
                    $_categories = array();
                }
                $categories = array();

                foreach($_categories as $cate)
                {
                    $categories[$cate['id']] = $cate['category_name'];
                }
                $quota = $ret['data']['quota'];
                $str = '';
                foreach($quota as $key => $q)
                {
                    if($q < 0)
                    {
                        $str = $str . $categories[$key] . ' ';
                        log_message('debug','value:' . $str);
                    }
                }	
                $this->session->set_userdata('last_error', '你的 ' . $str .'提交次数已经超出公司规定');
            } else {
                log_message("debug", "alvayang:" . json_encode($ret));
                $this->session->set_userdata('last_error', $ret['data']['msg']);
            }
        }

        $_error = '成功';
        if($this->session->userdata('last_error')) {
            $_error = $this->session->userdata('last_error');
            $this->session->unset_userdata('last_error');
        }
        die(json_encode(Array('status' => $ret['code'], 'msg' => $_error)));
        //return redirect(base_url('reports'));
    }

    public function del($id = 0){
        if($id == 0) {
            log_message("debug", "NO  Delete  ID:");
            return redirect(base_url('reports/index'));
        }
        $obj = $this->reports->delete_report($id);
        log_message("debug", "Delete ***********" . json_encode($obj));
        if(!$obj['status']) {
            $this->session->set_userdata('last_error', $obj['data']['msg']);
        }

        return redirect(base_url('reports/index'));
    }


    public function get_suborinate($me = 0){
        $items = $this->items->get_suborinate($me);
        if(!$items['status']){
            die(json_encode(array()));
        }
        $ret = array();
        foreach($items['data']['data'] as $i){
            $o = array();
            $p = '';
            if($i['prove_ahead']) {
                $p = '<span class="icon"><i class="icon_yu"><img src="/static/images/icon_yu.png" /></i></span>';
            }
            array_push($o, $p);
            array_push($o, date('m月d日', $i['lastdt']));
            array_push($o, $i['title']);
            array_push($o, $i['item_count']);
            array_push($o, 
                '<i class="tstatus tstatus_' . $i['status'] . "></i>" . 
                '<strong class="price">&yen;' . $i['amount'] . '</strong>'
            );

            array_push($o, $i['status']);
            array_push($o, $i['prove_ahead']);
            array_push($o, $i['createdt']);

            array_push($ret, $o);
        }
        print_r(json_encode(array('data' => $ret)));
    }


    public function edit($id = 0){
        if($id == 0) return redirect(base_url('reports/index'));
        $report = $this->reports->get_detail($id);
        if($report['status'] < 1){
            return redirect(base_url('reports/index'));
        }
        $report = $report['data'];
        $extra = array();
        if(array_key_exists('extras', $report)) {
            $extra = json_decode($report['extras'], true);
        }
        $config = array();
        if(!empty($extra)){
            $profile = $this->session->userdata('profile');
            $config = array();
            if($profile &&  array_key_exists('templates', $profile)) {
                $report_template = $profile['templates'];
                foreach($report_template as $r) {
                    if($r['id'] == $extra['template_id']) {
                        $config = $r;
                        break;
                    }
                }
            }
        }

        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }

        $_managers = array();
        foreach($report['receivers']['managers'] as $m){
            array_push($_managers, $m['id']);
        }
        $_ccs = array();
        foreach($report['receivers']['cc'] as $m){
            array_push($_ccs, $m['id']);
        }

        $report['receivers']['managers'] = $_managers;
        $report['receivers']['cc'] = $_ccs; 
        $_items = $this->_getitems();

        $this->bsload('reports/edit',
            array(
                'title' => '修改报告',
                'members' => $_members,
                'items' => $_items,
                'config' => $config,
                'extra' => $extra,
                'report' => $report
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                    ,array('url'  => '', 'name' => '修改报告', 'class' => '')
                ),
            ));
    }
    public function show($id = 0, $decision = 0){
        if($id == 0) return redirect(base_url('reports/index'));
        $report = $this->reports->get_detail($id);
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        if($report['status'] <= 0){
            return redirect(base_url('reports/index'));
        }
        $report = $report['data'];

        $comments = $report['comments']['data'];
        foreach($comments as &$comment)
        {
            $comment['lastdt'] = date('Y-m-d H:i:s',$comment['lastdt']);
        }
        $_managers = array();
        foreach($report['receivers']['managers'] as $m){
            array_push($_managers, $m['nickname']);
        }
        $_ccs = array();
        foreach($report['receivers']['cc'] as $m){
            array_push($_ccs, $m['nickname']);
        }
        $_msg = '公司管理员';
        if(count($_managers) > 0) {
            $report['receivers']['managers'] = implode(',', $_managers);
        } else {
            $report['receivers']['managers'] = $_msg;
            if($report['status'] == 0) {
            $report['receivers']['managers'] = '<待提交>';
            }
        }
        if(count($_ccs) > 0){
            $report['receivers']['cc'] = implode(',', $_ccs);
        } else {
            $report['receivers']['cc'] = ' ';
        }
        $_flow = $this->reports->report_flow($id);

        $flow = array();
        $_ts = '';
        log_message("debug", "Rreport" . json_encode($report));
        if($report['createdt'] > 0) {
            $_ts = date('Y-m-d H:i:s', $report['createdt']);
        }
        /*
        array_push($flow, array(
            'nickname' => $report['nickname']
            ,'ts' =>  $_ts           
            ,'status' => '提交'
            ,'step' => 0
            ,'wingman' => '' 
        ));
        */


        //获取全体员工
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $members_dic = array();
        foreach($gmember as $mem)
        {
            $members_dic[$mem['id']] = $mem['nickname'];
        }
        log_message("debug","all_members:" . json_encode($members_dic));
        // 先找到提交的信息
        // 昵称，审核意见，时间，step
        log_message("debug", 'flow data:' . json_encode($_flow));
        if($_flow['status'] == 1) {
            foreach($_flow['data']['data'] as $s){
                $_s = $s['status'] % 100;
                $audit = '待审批';
                if($s['uid'] == $report['uid']) {
                    $audit = '待提交';
                }
                if($s['uid'] == $report['uid']) {
                    if($_s == 1) {
                        $audit = '待提交';
                    }
                }
                if($_s == 2)  {
                    $audit = '通过';
                }
                if($_s == 3)  {
                    $audit = '拒绝';
                    if($s['uid'] == $report['uid']) {
                    $audit = '撤回';
                    }
                }
                if($_s == 4 || $_s == 5)  {
                    $audit = '已完成';
                }
                if($_s == 6)  {
                    $audit = '待支付';
                }
                if($_s == 7)  {
                    $audit = '完成待结束';
                }
                if($_s == 8)  {
                    $audit = '完成已结束';
                }
                $_ts = '';
                if($s['udt'] != '0') {
                    $_ts = date('Y-m-d H:i:s', $s['udt']);
                }

                $s['wingman_name'] = '';
                log_message("debug","wingman:" . $s['wingman']);
                if(array_key_exists('wingman',$s))
                {
                    if(array_key_exists($s['wingman'],$members_dic))
                    {
                       $s['wingman_name'] = $members_dic[$s['wingman']]; 
                    }
                }
                array_push($flow, array(
                    'status' => $audit
                    ,'nickname' => $s['nickname']
                    ,'ts' => $_ts
                    ,'step' => $s['step']
                    ,'wingman' => $s['wingman_name'] 
                ));
            }
        }
        usort($flow, function($a,$b)
                {
                    if($a['step'] == $b['step'])
                    {
                        return 0;
                    }
                    return ($a['step'] < $b['step']) ?-1:1;
                });
        foreach($flow as &$x) {
        }
        log_message("debug", "Recievers: ---> " . json_encode($flow));

        log_message("debug","*********:".json_encode($report));
        $prove_ahead = $report['prove_ahead'];
        switch($prove_ahead) {
        case 0:{$_type = '报销';};break;
        case 1:{$_type = '预算';};break;
        case 2:{$_type = '预借';};break;
        }
        $report['prove_ahead'] =  $_type;
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }
        $this->bsload('reports/view',
            array(
                'title' => '查看报告',
                'report' => $report,
                'error' => $error,
                'flow' => $flow
                ,'rid' => $id
                ,'comments' => $comments
                ,'members' => $_members
                ,'decision' => $decision
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                    ,array('url'  => '', 'name' => '查看报告', 'class' => '')
                ),
            ));
    }

    public function update(){
        $id = $this->input->post('id');
        $items = $this->input->post('item');
        if(''==$items || !$id)
        {
            $this->session->set_userdata('last_error','提交报告不能为空');
            return redirect(base_url('reports/index')); 
        }
        $title = $this->input->post('title');
        $receiver = $this->input->post('receiver');
        $cc = $this->input->post('cc');
        $save = $this->input->post('renew');
        $force = $this->input->post('force');
        if(!$cc) $cc = array();
        $template_id = $this->input->post('template_id');
        $extra = array();
        if($template_id) {
            // 获取并构造extra
            $_account = $this->input->post('account');
            $_payment = $this->input->post('payment');
            $_borrowing = $this->input->post('borrowing');
            $_location_from = $this->input->post('location_from');
            $_location_to = $this->input->post('location_to');
            $_period_start = $this->input->post('period_start');
            $_period_end = $this->input->post('period_end');
            $_contract = $this->input->post('contract');
            $_contract_note = $this->input->post('contract_note');
            $_note = $this->input->post('note');
            $_contract = $_contract == 2 ? 0 : 1;
            $extra = array(
                'template_id' => $template_id
                ,'borrowing' => $_borrowing
                ,'account' => $_account
                ,'payment' => $_payment
                ,'period' => array('start' => $_period_start, 'end' => $_period_end)
                ,'location' => array('start' => $_location_from, 'dest' => $_location_to)
                ,'contract' => array('available' => $_contract, 'note' => $_contract_note)
                ,'note' => $_note
            );
        }
        $ret = $this->reports->update($id, $title, implode(',', $receiver), implode(',', $cc), implode(',', $items), 0, $save, $force, $extra);
        $ret = json_decode($ret, true);
        log_message("debug", "xx:" . json_encode($ret));
        if($ret['code'] <= 0) {
            if($ret['code'] == -71)
            {
                $info = $this->category->get_list();
                if($info['status'] > 0)
                {
                    $_categories = $info['data']['categories'];
                }
                else
                {
                    $_categories = array();
                }
                $categories = array();
                foreach($_categories as $cate)
                {
                    $categories[$cate['id']] = $cate['category_name'];
                }
                log_message("debug", "Cates:" . json_encode($categories));
                $quota = $ret['data']['quota'];
                $str = '';
                foreach($quota as $key => $q)
                {
                    $str = $str . $categories[$key] . ' ';
                }	
                if($str) 
                    $this->session->set_userdata('last_error', $str . '金额超出公司月度限额，是否仍要提交');
            }
            else if($ret['code'] == -63)
            {
                $info = $this->category->get_list();
                if($info['status'] > 0)
                {
                    $_categories = $info['data']['categories'];
                }
                else
                {
                    $_categories = array();
                }
                $categories = array();

                foreach($_categories as $cate)
                {
                    //	array_push($categories,array($cate['id'] => $cate['category_name']));
                    $categories[$cate['id']] = $cate['category_name'];
                }
                $quota = $ret['data']['quota'];
                $str = '';
                foreach($quota as $key => $q)
                {
                    if($q < 0)
                    {
                        $str = $str . $categories[$key] . ' ';
                        log_message('debug','value:' . $str);
                    }
                }	
                $this->session->set_userdata('last_error', '你的 ' . $str .'提交次数已经超出公司规定');
            } else {
                log_message("debug", "alvayang:" . json_encode($ret));
                $this->session->set_userdata('last_error', $ret['data']['msg']);
            }
        }

        $_error = '成功';
        if($this->session->userdata('last_error')) {
            $_error = $this->session->userdata('last_error');
            $this->session->unset_userdata('last_error');
        }
        die(json_encode(Array('status' => $ret['code'], 'msg' => $_error)));
    }

    public function check_permission() {
        //{'complete' => 0/1, 'suggestion' => array($uid1, $uid2, $uid3)}
        $rid = $this->input->get('rid');
        $rep = $this->reports->get_permission($rid);
        die($rep);
        //niu
    }
    public function audit(){
        $this->session->set_userdata('item_update_in',4);
        $items = $this->items->get_suborinate();
        if(!$items['status']){
            die(json_encode(array()));
        }
        $ret = array();
        if(!$items) redirect(base_url('login'));
        $item_data = array();
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['data'];
        }
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }
        $_error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        log_message("debug", "Last Error:" . $_error);
        $this->bsload('reports/audit',
            array(
                'title' => '收到的报告'
                ,'items' => $item_data
                ,'members' => $_members
                ,'error' => $_error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                    ,array('url'  => '', 'name' => '收到的报告', 'class' => '')
                ),
            ));
    }


    public function listgroupmember(){
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }
        die(json_encode($_members));

    }

    public function listauditdata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $items = $this->items->get_suborinate(1);
        if(!$items['status']){
            die(json_encode(array()));
        }
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }
        $__members = array();
        foreach($_members as $m){
            $__members[$m['id']] = $m;
        }

        $data = $items['data']['data'];
        foreach($data as &$d){
            log_message("debug", "xxx audit data:" . json_encode($d));
            $trash= $d['status'] === 1 ? 'grey' : 'red';
            $edit = ($d['status'] === 1)   ? 'grey' : 'green';
            $exports = ($d['status'] === 1) ? 'grey' : 'grey';
            $d['author'] = '';
            if(array_key_exists($d['uid'], $__members)){
                $d['author'] = $__members[$d['uid']]['nickname'];
            }
            log_message("debug", "Rstatus: **** " . json_encode($d));
            if(in_array($d['status'],[2,4,5,7,8]))
            {
                if($d['mdecision'] == 1 && !$d['cc_flag']){
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del"  data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-decision="1" data-id="' . $d['id'] . '"></span><span class="ui-icon ' . $edit . ' fa fa-check tpass" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  fa-sign-in texport' . $exports . '  fa fa-times texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span>' .  '<span class="ui-icon  ui-icon-closethick ' . $trash . '  fa fa-times tdeny" data-id="' . $d['id'] . '"></span></div>';
                } else { 
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  fa-sign-in ' . $exports . '  fa fa-times texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span></div>';
                }

            }
            else
            {
                if($d['mdecision'] == 1 && !$d['cc_flag']){
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-decision="1"  data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-decision="1" data-id="' . $d['id'] . '"></span><span class="ui-icon ' . $edit . ' fa fa-check tpass" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  ui-icon-closethick ' . $trash . '  fa fa-times tdeny" data-id="' . $d['id'] . '"></span></div>';
                } else {
                    $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span></div>';
                }
            }
            $d['date_str'] = date('Y年m月d日', $d['createdt']);
            $d['status_str'] = '待提交';
        /*
            $prove_ahead = '报销';
            switch($d['prove_ahead']){
            case 1: {$prove_ahead = '<font color="red">预算</font>';};break;
            case 2: {$prove_ahead = '<font color="green">预借</font>';};break;
            }
         */
            //$d['amount'] = '￥' . (sprintf("%.2f",$d['amount']));
            $d['amount'] = sprintf("%.2f",$d['amount']);
            //            $d['prove_ahead'] = $prove_ahead;
            switch($d['status']) {
            case 0: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
            };break;
            case 1: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#46A3D3;background:#46A3D3 !important;">审核中</button>';
            };break;
            case 2: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#42B698;background:#42B698 !important;">待结算</button>';
            };break;
            case 3: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#B472B1;background:#B472B1 !important;">退回</button>';
            };break;
            case 4: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 5: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">已完成</button>';
            };break;
            case 6: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#42B698 !important;">待支付</button>';
            };break;
            case 7: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成待确认</button>';
            };break;
            case 8: {
                $d['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成已确认</button>';
            };break;
            }
        }
        die(json_encode($data));
    }


    private function exports_by_rids($ids) {
        $data = $this->reports->get_reports_by_ids($ids);
        $_excel = array();
        $_members = array();
        if($data['status'] > 0){
            $_reports = $data['data'];
            $reports = $_reports['report'];
            $banks = $_reports['banks'];
            $_banks = array();
            foreach($banks as $b){
                $_banks[$b['uid']] = $b;
            }
            $_t_items = array();
            foreach($reports as &$r){
                if(!array_key_exists($r['uid'], $_members)){
                    $_members[$r['uid']] = array('credit_card' => $r['credit_card'], 'nickname' => $r['nickname'], 'paid' => 0);
                }
                $r['total'] = 0;
                $r['paid'] = 0;
                //log_message('debug', json_encode($r));
                $_items = $r['items'];
                foreach($_items as $i){
                    $i['amount'] = sprintf("%.2f", $i['amount']);
                    $_rate = 1.0;
                    if(array_key_exists('currency', $i) && (strtolower($i['currency']) != "" && strtolower($i['currency']) != 'cny')) {
                        $_rate = $i['rate'] / 100;
                    }
                    log_message("debug", "Items23:"  . json_encode($i));
                    $r['total'] += ($i['amount'] * $_rate);
                    log_message("debug", "Items13:"  . json_encode($i['amount']));
                    log_message("debug", "Items33:"  . json_encode($_rate));
                    $i['paid'] = ($i['amount'] * $_rate);
                    if(in_array($r['status'], array(4, 7, 8))){
                        // 已完成状态的，付款额度就是已付额度
                        $i['paid'] = ($i['amount'] * $_rate);
                    } else {
                        $i['paid'] = 0;
                    }
                    $i['nickname'] = $r['nickname'];
                    //$r['total'] += ($i['amount'] * $_rate);
                    //log_message("debug", "Items2:"  . json_encode($i));
                    array_push($_t_items, $i);
                    if($i['reimbursed'] == 0) {
                        log_message("debug", "Ignore :"  . json_encode($i));
                        continue;
                    }
                    if($i['prove_ahead'] > 0){
                        $r['paid'] += ($i['pa_amount'] * $_rate);
                    }

                }
                if(in_array($r['status'], array(4, 7, 8))){
                    // 已完成状态的，付款额度就是已付额度
                    $r['paid'] = $r['total'];
                }
                $r['last'] = $r['total'] - $r['paid'];
                log_message("debug", $r['status'] . "," . $r['id'] . " Total:" . $r['total']);
                log_message("debug", $r['status'] . "," . $r['id'] . " Paid:" . $r['paid']);
                log_message("debug", $r['status'] . "," . $r['id'] . " Last:" . $r['last']);
                $_members[$r['uid']]['paid'] += $r['total'];//$r['last'];
                $_members[$r['uid']]['uid'] = $r['uid'];
                $obj = array();
                $obj['报告名'] = $r['title'];
                $obj['创建者'] = $r['nickname'];
                $obj['创建日期'] = strftime('%Y年%m月%d日', $r['createdt']);
                $obj['金额'] = $r['total'];
                $obj['已付'] = $r['paid'];
                $obj['应付'] = $r['last'];
                array_push($_excel, $obj);
            }
            log_message("debug", "export --> " . json_encode($_t_items));
            log_message("debug", "export Mmeber *** --> " . json_encode($_members));



            $members = array();
            foreach($_members as $x){
                log_message("debug", "Member:" . json_encode($x));
                $_bank = array('cardno' => '', 'account' => '', 'bankloc' => '', 'bankname' => '');
                if(array_key_exists($x['uid'], $_banks)) $_bank = $_banks[$x['uid']];
                $o = array();
                $o['帐号'] = $_bank['cardno'];
                $o['户名'] = $_bank['account'];
                $o['金额'] = $x['paid'];
                $o['开户行'] = $_bank['bankname'];
                $o['开户地'] = $_bank['bankloc'];
                $o['昵称'] = $x['nickname'];
                $o['注释'] = '';
                array_push($members, $o);
            }

            $nicks = $_reports['nicks'];

            $__members = array();
            foreach($nicks as $i){
                $__members[$i['uid']] =  $i['nickname'];
            }
            $_detail_items = array();
            foreach($_t_items as $i){
                $i['amount'] = sprintf("%.2f", $i['amount']);
                log_message('debug', "alvayang Itemx :" .json_encode($i));
                $_relates = explode(',', $i['relates']);
                $__relates = array();
                foreach($_relates as $r){
                    if(array_key_exists($r, $__members)){
                        array_push($__relates, $__members[$r]);
                    }
                }
                $s = $i['category_code'];
                if($s == 0) $s = '';
                log_message("debug", "export item:" . json_encode($i));
                $o = array();
                $o['日期'] = date('Y年m月d日', date($i['createdt']));
                $o['时间'] = date('H:i:s', date($i['createdt']));
                $o['员工姓名'] = $i['nickname'];
                $o['员工邮箱'] = $i['nickname'];
                $o['类别'] = $i['category_name'];
                $o['商家'] = $i['merchants'];
                $o['参与人员'] = implode(',', $__relates);
                $o['会计科目'] = $s;
                $o['备注'] = $i['note'];
                $_rate = 1.0;
                if($i['currency'] != '' && strtolower($i['currency']) != 'cny') {
                    $_rate = $i['rate'] / 100;
                }
                $o['金额'] = $i['amount'] * $_rate;
                $_paid = 0;
                if($i['prove_ahead'] > 0){
                    $_paid = $i['pa_amount'];
                }
                $_last = $i['amount'] - $_paid;
                $o['已付'] = $i['paid'];
                $o['应付'] = ($i['amount'] * $_rate) - $i['paid'];
                $o['报告名'] = $i['title'];
                array_push($_detail_items, $o);
            }

            log_message("debug", json_encode($o));
            self::render_to_download('报告汇总', $members, 'Finace_' . date('Y-m-d', time()) . ".xls", '报告明细', $_excel, '消费明细', $_detail_items);

        }
    }

    public function exports(){
        $ids = $this->input->post('ids');
        if("" == $ids) die("");
        $this->exports_by_rids($ids);
    }


    public function permit($status = 3, $rid = 0){
        $content = '';
        if($rid == 0){
            $rid = $this->input->post('rid');
            $status = $this->input->post('status');
            log_message('debug','report_status:' . $status);
            $receivers = implode(',', $this->input->post('receiver'));
            $content = $this->input->post('content');
            if($this->input->post('pass') == 1) {
                $receivers = '';
            }
        } else {
            $receivers = '';
        }
        $buf = $this->reports->audit_report($rid, $status, $receivers, $content);
        $buf_json = json_encode($buf);
        log_message("debug","#########:$buf_json");
        if(!$buf['status']) {
            $this->session->set_userdata('last_error', '操作失败');
            log_message("debug","**********:$buf");
        }
        redirect(base_url('reports/audit'));
    }


    public function export_u8(){
        $ids = $this->input->post('ids');
        //$_ids = explode(",", $ids);
        if("" == $ids) {
            $this->session->set_userdata('last_error', '没有选择任何报销');
            die("<script language='javascript'>history.go(-1); </script>");
            //return redirect(base_url('reports/index'));
        }
        $user = $this->session->userdata('user');
        $username = '';
        if(is_array($user)){
            $username = $user['email'];
            if($user['nickname']){
                $username = $user['nickname'];
            }
        } else {
            $username = $user->username;
            if($user->nickname){
                $username = $user->nickname;
            }
        }
        $_maker = $username;
        $data = $this->reports->get_reports_by_ids($ids);
        $_excel = array();
        $_members = array();
        if($data['status'] > 0){
            $_reports = $data['data'];
            $reports = $_reports['report'];
            $groups = $_reports['groups'];
            log_message("debug", "GROUPS:" . json_encode($groups));
            $_headers =  array(
                '凭证ID' => 0
                ,'会计年' => date('Y')
                ,'会计期间' => date('m')
                ,'制单日期' => date('Y-m-d')
                ,'凭证类别' => '转'
                ,'凭证号' => 0
                ,'制单人' => $_maker
                ,'所附单据数' => ''
                ,'备注1' => ''
                ,'备注2' => ''
                ,'科目编码' => 0
                ,'摘要' => ''
                ,'结算方式编码' => ''
                ,'票据号' => ''
                ,'币种名称' => '人民币'
                ,'汇率' => ''
                ,'单价' => ''
                ,'借方数量' => ''
                ,'贷方数量' => ''
                ,'贷方数量' => ''
                ,'原币借方' => ''
                ,'原币贷方' => ''
                ,'借方金额' => 0
                ,'贷方金额' => 0
                ,'部门编码' => 0
                ,'客户编码' => ''
                ,'供应商编码' => ''
                ,'项目大类编码' => ''
                ,'项目编码' => ''
                ,'业务员' => ''
                ,'自定义项1' => ''
                ,'自定义项2' => ''
                ,'自定义项3' => ''
                ,'自定义项4' => ''
                ,'自定义项5' => ''
                ,'自定义项6' => ''
                ,'自定义项7' => ''
                ,'自定义项8' => ''
                ,'自定义项9' => ''
                ,'自定义项10' => ''
                ,'自定义项11' => ''
                ,'自定义项12' => ''
                ,'自定义项13' => ''
                ,'自定义项14' => ''
                ,'自定义项15' => ''
                ,'自定义项16' => ''
                ,'现金流项目' => ''
                ,'现金流量借方金额' => ''
                ,'现金流量贷方金额' => ''
                ,'金额' => ''
		,'员工姓名' => ''
		,'员工号' => ''
            );
            $idx = 0;
            $_total_amount = 0;
            foreach($reports as &$r){
                $_items = $r['items'];
                foreach($_items as $item){
                    $rate = 1.0;
                    if($item['currency'] != '' && strtolower($item['currency']) != 'cny') {
                        $rate = $item['rate'] / 100;
                    }
                    $_amount = sprintf("%.2f", $item['amount']);
                    if($item['prove_ahead'] == 2){
                        $_amount = sprintf("%.2f", $item['amount'] - $item['pa_amount']);

                    }
                    $_total_amount += $_amount * $rate;
                }
            }
            foreach($reports as &$r){
                if(!array_key_exists($r['uid'], $_members)){
                    $_members[$r['uid']] = array('credit_card' => $r['credit_card'], 'nickname' => $r['nickname'], 'paid' => 0);
                }
                $_gname = '';
                $_gids = array();
                if(array_key_exists($r['uid'], $groups)){
                    $_uid = $r['uid'];
                    $_name = array();
                    $_groups = $groups[$_uid];
                    foreach($_groups as $s){
                        array_push($_name, $s['gname']);
                        array_push($_gids, $s['gcode']);
                    }
                    $_gname = implode('/', $_name);
                }
                log_message("debug", json_encode($r));
                $r['total'] = 0;
                $r['paid'] = 0;
                $_items = $r['items'];
                foreach($_items as $i){
                    $idx += 1;
                    log_message("debug", "Item:" . json_encode($i));
                    $o = $_headers;
                    $o['凭证ID'] = $idx;
                    $o['凭证号'] = $r['id'];
                    $o['科目编码'] = $i['category_code'];
                    $o['摘要'] = '计提' . date('m月') . '员工报销 - ' . $i['category_name']  . ' - ' . $r['nickname']; 
                    $rate = 1.0;
                    if(trim($i['currency']) != '' && strtolower($i['currency']) != 'cny') {
                        $rate = $i['rate'] / 100;
                    }
                    $_amount = sprintf("%.2f", $i['amount']);
                    if($i['prove_ahead'] == 2){
                        $_amount = sprintf("%.2f", $i['amount'] - $i['pa_amount']);
                    }
                    $o['借方金额'] = sprintf("%.2f",$_amount * $rate); 
                    $o['贷方金额'] = $_total_amount;
                    $o['部门编码'] = implode(',', $_gids);
		    $o['员工姓名'] = $r['nickname'];
		    $o['员工号'] = $r['client_id'];
                    /*
                     */
                    array_push($_excel, $o);
                }
            }
            //print_r($_excel);
            self::render_to_download('工作表1', $_excel, 'u8_' . date('Y-m-d', time()) . ".xls");
        }
    }

    public function report_template($id = 0){
        if($id == 0) return redirect(base_url('reports/newreport'));
        $profile = $this->session->userdata('profile');
        $config = array();
        if($profile &&   array_key_exists('templates', $profile)) {
            $report_template = $profile['templates'];
            foreach($report_template as $r) {
                if($r['id'] == $id) {
                    $config = $r;
                }
            }
            if(!empty($config)){
                $_members = array();
                $members = $this->users->reim_get_user();
                if($members['status'] > 0){
                    $_members = $members['data']['members'];
                }

                $_items = $this->_getitems();
                log_message('debug',json_encode($_items));

                return $this->bsload('reports/template_new',
                    array(
                        'title' => '新建[' . $config['name'] . '] 报告',
                        'members' => $_members,
                        'config' => $config,
                        'items' => $_items
                        ,'breadcrumbs' => array(
                            array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                            ,array('url'  => base_url('reports/index'), 'name' => '报告', 'class' => '')
                            ,array('url'  => '', 'name' => '新建[' . $config['name'] . '] 报告', 'class' => '')
                        ),
            ));
            }
        }
        return redirect(base_url('reports/newreport'));
    }
}

