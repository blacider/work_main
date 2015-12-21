<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
        $this->load->model('user_model', 'users');
        $this->load->model('report_model', 'reports');
        $this->load->model('group_model','groups');
        $this->load->model('reim_show_model','reim_show');
        $this->load->model('usergroup_model','ug');
        $this->load->model('account_set_model','account_set');
        $this->load->helper('report_view_utils');
    }

    public function confirm_success()
    {
        $rid = $this->input->post('rid');
        if(!$rid) redirect(base_url('reports'));
        $buf = $this->reports->confirm_success($rid);
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','操作成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$buf['data']['msg']);
        }
        echo json_encode(array());
    }

    public function get_coin_symbol($key = 'cny')
    {
        $symbol = '?';
        $coin_symbol_dic = array(
                            'cny'=>'￥','usd'=>'$','eur'=>'€','hkd'=>'$','mop'=>'$','twd'=>'$','jpy'=>'￥','ker'=>'₩',
                            'gbp'=>'£','rub'=>'₽','sgd'=>'$','php'=>'₱','idr'=>'Rps','myr'=>'$','thb'=>'฿','cad'=>'$',
                            'aud'=>'$','nzd'=>'$','chf'=>'₣','dkk'=>'Kr','nok'=>'Kr','sek'=>'Kr','brl'=>'$'
                            );
        if(array_key_exists($key,$coin_symbol_dic))
        {
            $symbol = $coin_symbol_dic[$key];
        }

        return $symbol;
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

    public function index($search='',$type = 1) {
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
        $this->session->set_userdata("report_list_url", "reports");
        $this->bsload('reports/index',
            array(
                'title' => '我的报销单'
                ,'items' => $item_data
                ,'error' => $error
                ,'type' => $type
                ,'search' => urldecode($search)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报销单', 'class' => '')
                    ,array('url'  => '', 'name' => '我的报销单', 'class' => '')
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
                $_report = '尚未添加到报销单';
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

                $s['coin_symbol'] = $this->get_coin_symbol($s['currency']);
                $s['amount'] = sprintf("%.2f",$s['amount']);
                $s['status_str'] = '';
                $trash= $s['istatus'] === 0 ? 'gray' : 'red';
                $edit = $s['istatus'] === 0 ? 'gray' : 'green';
                $s['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
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
        $item_type_dic = $this->reim_show->get_item_type_name();
        $_members = array();
        $members = $this->users->reim_get_user();
        if($members['status'] > 0){
            $_members = $members['data']['members'];
        }

        $_items = $this->_getitems();
        log_message('debug',json_encode($_items));

        $this->bsload('reports/new',
            array(
                'title' => '新建报销单',
                'members' => $_members,
                'item_type_dic' => $item_type_dic,
                'items' => $_items
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报销单', 'class' => '')
                    ,array('url'  => '', 'name' => '新建报销单', 'class' => '')
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

        $item_type_dic = $this->reim_show->get_item_type_name();
        $report_template_dic = $this->reim_show->get_report_template();

        $data = $items['data']['data'];
        foreach($data as &$d){
            if(array_key_exists('has_attachment',$d) && $d['has_attachment'])
            {
                $url = base_url('reports/show/' . $d['id']);
                $d['attachments'] = '<a href=' . htmlspecialchars($url) . '><img style="width:25px;height:25px" src="/static/images/default.png"></a>';
            }
            $trash= $d['status'] === 1 ? 'gray' : 'red';
            $edit = ($d['status'] === 1)   ? 'gray' : 'green';
            $export = ($d['status'] === 1)   ? 'gray' : 'grey';

            $base_icon = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">';
            $show_icon = '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>';
            $edit_icon = '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $d['id'] . '"></span>';
            $export_icon = '<span class="ui-icon ' . $export . '  fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span>';
            $trash_icon = '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span>';
            $confirm_icon = '<span class="ui-icon ace-icon fa fa-check green' . $trash . '  tconfirm" data-id="' . $d['id'] . '"></span>';
            $download_icon = '<span class="ui-icon ace-icon fa fa-download ' . 'blue' . '  tdown" data-id="' . $d['id'] . '"></span>';
            $end_icon = '</div>';

            if(in_array($d['status'],[0,3]))
            {
                $d['options'] = $base_icon . $edit_icon . $trash_icon . $end_icon;
            }
            else if(in_array($d['status'],[1]))
            {
                $d['options'] = $base_icon . $show_icon . $end_icon;
            }
            else if(in_array($d['status'],[2]))
            {
                $d['options'] = $base_icon . $show_icon .  $export_icon . $download_icon . $end_icon;
            }
            else if(in_array($d['status'],[7]))
            {
                $d['options'] = $base_icon . $show_icon . $export_icon . $download_icon . $confirm_icon . $end_icon;
            }
            else
            {
                $d['options'] = $base_icon . $show_icon . $export_icon .$download_icon . $end_icon;
            }

            /*
            if($d['status'] == 1) {
                $d['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span></div>';
            } else {
                if(in_array($d['status'],array(2,4,5)))
                {
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $export . '  fa-sign-in texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span></div>';
                    //. '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span></div>';
                } else if (in_array($d['status'],array(0,3))) {
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $d['id'] . '"></span></div>';
                }
                else
                {
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">'
                        . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>'
                        //. '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $d['id'] . '"></span>'
                        . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $d['id'] . '"></span></div>';
                }
            }
            */
            $d['date_str'] = date('Y年m月d日', $d['createdt']);
            $d['status_str'] = '待提交';
            //$d['amount'] = '￥' . $d['amount'];

            $prove_ahead = '报销';
            switch($d['prove_ahead']){
            case 0: {$prove_ahead = '<font color="black">' . $item_type_dic[0]  . '</font>';};break;
            case 1: {$prove_ahead = '<font color="green">' . $item_type_dic[1] . '</font>';};break;
            case 2: {$prove_ahead = '<font color="red">' . $item_type_dic[2]  . '</font>';};break;
            }
            $d['prove_ahead'] = $prove_ahead;


            if(array_key_exists('template_id',$d))
            {
                if(array_key_exists($d['template_id'],$report_template_dic))
                {
                    $d['report_template'] = $report_template_dic[$d['template_id']];
                }
            }

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
            $this->session->set_userdata('last_error','提交报销单不能为空');
            return redirect(base_url('reports/index'));
        }
        $title = $this->input->post('title');
        $receiver = $this->input->post('receiver');
        $cc = $this->input->post('cc');
        $force = $this->input->post('force');
        $template_id = $this->input->post('template_id');
        $type = $this->input->post('type');
        log_message('debug','template_id:' . $template_id);
        $extra = array();
        if($template_id) {
            $extra = $this->input->post('extra');
            log_message('debug','extra:' . json_encode($extra));
            foreach($extra as &$ex)
            {
                if($ex['type'] != 3) continue;

                $ex['value'] = strtotime($ex['value']);
                log_message('debug','time:' . $ex['value']);
            }
        }
        if(!$cc) $cc = array();
        if(!$force) $force = 0;
        $save = $this->input->post('renew');
        $ret = $this->reports->create($title, implode(',', $receiver), implode(',', $cc), implode(',', $items), $type, $save, $force, $extra , $template_id);
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
        $item_type_dic = $this->reim_show->get_item_type_name();
        if($id == 0) return redirect(base_url('reports/index'));
        $report = $this->reports->get_detail($id);
        if($report['status'] < 1){
            return redirect(base_url('reports/index'));
        }
        $report = $report['data'];
        $extra = array();
        if(array_key_exists('extras', $report) && $report['extras']) {
            $extra = json_decode($report['extras'], true);
        }
        $config = array();
        $banks = array();
        if(!empty($extra)){
            $profile = array();
            $_common = $this->users->get_common();
            if($_common['status'] > 0 && array_key_exists('profile',$_common['data']))
            {
                $profile = $_common['data']['profile'];
            }
            $config = array();
            if($profile && array_key_exists('report_setting',$profile)  && array_key_exists('templates', $profile['report_setting'])) {
                $report_template = $profile['report_setting']['templates'];
                foreach($report_template as $r) {
                    if($r['id'] == $report['template_id']) {
                        $config = $r;
                        break;
                    }
                }
            }
            $banks = array();
            if(array_key_exists('banks',$profile))
            {
                $banks = $profile['banks'];
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

        foreach($report['items'] as &$rt)
        {
            $rt['coin_symbol'] = $this->get_coin_symbol($rt['currency']);
        }

        $extra_dic = array();
        foreach($extra as $ex)
        {
            if(is_array($ex) && array_key_exists('id',$ex))
            {
                $extra_dic[$ex['id']] = $ex;
            }
        }
        log_message('debug','report:' . json_encode($report));
        log_message('debug','extra:' . json_encode($extra));
        log_message('debug','config:' . json_encode($config));
        $this->bsload('reports/edit',
            array(
                'title' => '修改报销单',
                'members' => $_members,
                'items' => $_items,
                'config' => $config,
                'extra' => $extra,
                'banks' => $banks,
                'extra_dic' => $extra_dic,
                'item_type_dic' => $item_type_dic,
                'report' => $report
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报销单', 'class' => '')
                    ,array('url'  => '', 'name' => '修改报销单', 'class' => '')
                ),
            ));
    }
    public function show($id = 0, $decision = 0){
        $item_type_dic = $this->reim_show->get_item_type_name();
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
                if($s['uid'] == $report['uid'] && $_s == 0) {
                        $audit = '待提交';
                }
                if($s['uid'] == $report['uid']) {
                    if($_s == 1) {
                        $audit = '已提交';
                    }
                    if($_s == 1 && array_key_exists('ticket_type',$s) && $s['ticket_type'] == 1)
                    {
                        $audit = '待审批';
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
        $extra = array();
        if(array_key_exists('extras', $report) && $report['extras']) {
            $extra = json_decode($report['extras'], true);
        }
        $config = array();
        if(!empty($extra)){
            $profile = array();
            $_common = $this->users->get_common();
            if($_common['status'] > 0 && array_key_exists('profile',$_common['data']))
            {
                $profile = $_common['data']['profile'];
            }
            $config = array();
            if($profile && array_key_exists('report_setting', $profile) && array_key_exists('templates', $profile['report_setting'])) {
                $report_template = $profile['report_setting']['templates'];
                foreach($report_template as $r) {
                    if($r['id'] == $report['template_id']) {
                        $config = $r;
                        break;
                    }
                }
            }
        }

        $url = $this->session->userdata("report_list_url");
        if ($url) {
            $url = base_url($url);
        }
        log_message("debug", "found report list page => " . $url);
        $extra_dic = array();
        foreach($extra as $ex)
        {
            if(is_array($ex) && array_key_exists('id',$ex))
            {
                $extra_dic[$ex['id']] = $ex;
            }
        }

        if(array_key_exists('items',$report))
        {
            foreach($report['items'] as &$item)
            {
                if(array_key_exists('attachments',$item))
                {
                    show_attachments($item);
                }
            }
        }

        $this->bsload('reports/view',
            array(
                'title' => '查看报销单',
                'report' => $report,
                'error' => $error,
                'flow' => $flow
                ,'rid' => $id
                ,'config' => $config
                ,'extra' => $extra
                ,'extra_dic' => $extra_dic
                ,'item_type_dic' => $item_type_dic
                ,'comments' => $comments
                ,'members' => $_members
                ,'decision' => $decision
                ,"report_list_url" => $url
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('reports/index'), 'name' => '报销单', 'class' => '')
                    ,array('url'  => '', 'name' => '查看报销单', 'class' => '')
                ),
            ));
    }

    public function update(){
        $id = $this->input->post('id');
        $items = $this->input->post('item');
        if(''==$items || !$id)
        {
            $this->session->set_userdata('last_error','提交报销单不能为空');
            return redirect(base_url('reports/index'));
        }
        $title = $this->input->post('title');
        $receiver = $this->input->post('receiver');
        $cc = $this->input->post('cc');
        $save = $this->input->post('renew');
        $force = $this->input->post('force');
        if(!$cc) $cc = array();
        $template_id = $this->input->post('template_id');
        $type = $this->input->post('type');
        $extra = array();
        if($template_id) {
            $extra = $this->input->post('extra');
            log_message('debug','extra:' . json_encode($extra));
            foreach($extra as &$ex)
            {
                if($ex['type'] != 3) continue;

                $ex['value'] = strtotime($ex['value']);
                log_message('debug','time:' . $ex['value']);
            }

        /*
            $_account = $this->input->post('account');
            $_account_name = $this->input->post('account_name');
            $_account_no = $this->input->post('account_no');
            $_payment = $this->input->post('payment');
            $_borrowing = $this->input->post('borrowing');
            $_location_from = $this->input->post('location_from');
            $_location_to = $this->input->post('location_to');
            $_period_start = $this->input->post('period_start');
            $_period_end = $this->input->post('period_end');
            $_contract = $this->input->post('contract');
            $_contract_note = $this->input->post('contract_note');
            $_note = $this->input->post('note');
            //$_contract = $_contract == 2 ? 0 : 1;
            $extra = array(
                'template_id' => $template_id
                ,'borrowing' => $_borrowing
                ,'account' => array(
                    'id' => $_account
                    ,'name' => $_account_name
                    ,'no' => $_account_no
                )
                ,'payment' => $_payment
                ,'period' => array('start' => $_period_start, 'end' => $_period_end)
                ,'location' => array('start' => $_location_from, 'dest' => $_location_to)
                ,'contract' => array('available' => $_contract, 'note' => $_contract_note)
                ,'note' => $_note
            );
            */
        }
        $ret = $this->reports->update($id, $title, implode(',', $receiver), implode(',', $cc), implode(',', $items), $type, $save, $force, $extra , $template_id);
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
                    //  array_push($categories,array($cate['id'] => $cate['category_name']));
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

    public function audit_cc($search=''){
        return $this->_audit('cc', $search);
    }

    public function audit_todo($search=''){
        return $this->_audit('todo', $search);
    }

    public function audit_done($search=''){
        return $this->_audit('done', $search);
    }

    public function audit($search=''){
        # FIXME
        return $this->_audit('all', $search);
    }

    private function _audit($filter, $search=''){
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
        $this->session->set_userdata("report_list_url", "reports/audit");
        $this->bsload('reports/audit',
            array(
                'title' => '收到的报销单',
                'items' => $item_data,
                'members' => $_members,
                'error' => $_error,
                'search' => urldecode($search),
                'filter' => $filter,
                'can_export_excel' => $filter == 'done' ? 'true' : 'false',
                'breadcrumbs' => [
                    ['url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon'],
                    ['url'  => base_url('reports/index'), 'name' => '报销单', 'class' => ''],
                    ['url'  => '', 'name' => '收到的报销单', 'class' => ''],
                ],
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
        $filter = $this->input->get('filter', 'all');
        $items = $this->items->get_suborinate(1, $filter);

        $item_type_dic = $this->reim_show->get_item_type_name();
        $report_template_dic = $this->reim_show->get_report_template();

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
            if(array_key_exists('has_attachment',$d) && $d['has_attachment']) {
                $url = base_url('reports/show/' . $d['id']);
                $d['attachments'] = '<a href=' . htmlspecialchars($url) . '><img style="width:25px;height:25px" src="/static/images/default.png"></a>';
            }
            log_message("debug", "xxx audit data:" . json_encode($d));
            $trash = $d['status'] === 1 ? 'grey' : 'red';
            $edit = ($d['status'] === 1)   ? 'grey' : 'green';
            $exports = ($d['status'] === 1) ? 'grey' : 'grey';
            $d['author'] = '';
            if(array_key_exists($d['uid'], $__members)){
                $d['author'] = $__members[$d['uid']]['nickname'];
            }
            log_message("debug", "Rstatus: **** " . json_encode($d));

            $download_icon = '<span class="ui-icon ace-icon fa fa-download ' . 'blue' . '  tdown" data-id="' . $d['id'] . '"></span>';

            if (in_array($d['status'],[2,4,5,7,8]) or
                ($d['status'] == 0 and $d['pa_approval'])
            ) {
                if($d['mdecision'] == 1 && !$d['cc_flag']){
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del"  data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-decision="1" data-id="' . $d['id'] . '"></span><span class="ui-icon ' . $edit . ' fa fa-check tpass" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  fa-sign-in texport' . $exports . '  fa fa-times texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span>' .   $download_icon . '<span class="ui-icon  ui-icon-closethick ' . $trash . '  fa fa-times tdeny" data-id="' . $d['id'] . '"></span></div>';
                } else {
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  fa-sign-in ' . $exports . '  fa fa-times texport" data-id="' . $d['id'] . '" href="#modal-table" data-toggle="modal"></span>' . $download_icon  . '</div>';
                }
            }
            else
            {
                if($d['mdecision'] == 1 && !$d['cc_flag']){
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-decision="1"  data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-decision="1" data-id="' . $d['id'] . '"></span><span class="ui-icon ' . $edit . ' fa fa-check tpass" data-id="' . $d['id'] . '"></span>' . '<span class="ui-icon  ui-icon-closethick ' . $trash . '  fa fa-times tdeny" data-id="' . $d['id'] . '"></span></div>';
                } else {
                    $d['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $d['id'] . '">' . '<span class="ui-icon fa fa-search-plus tdetail" data-id="' . $d['id'] . '"></span></div>';
                }
            }
            $d['date_str'] = date('Y年m月d日', $d['createdt']);
            $d['status_str'] = '待提交';

            $prove_ahead = '报销';
            switch($d['prove_ahead']){
            case 0: {$prove_ahead = '<font color="black">' . $item_type_dic[0]  . '</font>';};break;
            case 1: {$prove_ahead = '<font color="green">' . $item_type_dic[1]  . '</font>';};break;
            case 2: {$prove_ahead = '<font color="red">' . $item_type_dic[2]  . '</font>';};break;
            }
            $d['prove_ahead'] = $prove_ahead;

            if(array_key_exists('template_id',$d) && array_key_exists($d['template_id'],$report_template_dic))
            {
                $d['report_template'] = $report_template_dic[$d['template_id']];
            }

            //$d['amount'] = '￥' . (sprintf("%.2f",$d['amount']));
            $d['amount'] = sprintf("%.2f",$d['amount']);
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

    private function try_get_element() {
        if (func_num_args() == 0)
            return NULL;

        $data = func_get_arg(0);

        for ($i = 1; $i < func_num_args(); $i++) {
            $field = func_get_arg($i);
            if ($data && is_array($data) && array_key_exists($field, $data))
                $data = $data[$field];
            else
                return NULL;
        }

        return $data;
    }

    function get_bank_field_from_template($template, $bank_account_type) {
        foreach ($template["config"] as $fieldset) {
            foreach ($fieldset["children"] as $field) {
                if ($field["type"] == 4) {
                    if ($field["property"]["bank_account_type"] == $bank_account_type) {
                        return $field;
                    }
                }
            }
        }

        return NULL;
    }

    private function build_extra_cells($template, $extra) {
        log_message("debug", "build extra cells from " . json_encode($template));
        log_message("debug", "build extra cells with " . json_encode($extra));

        $extra_dict = array();
        $obj = array();
        // 空的extra也得构造这些自定义列，不然同模板的报销单列不相同，顺序就乱了
        if (!is_array($extra))
            $extra = array();

        foreach ($extra as $e) {
            if (is_array($e) && array_key_exists("id", $e)) {
                $extra_dict[$e["id"]] = $e;
            }
        }

        if (empty($template) || !array_key_exists("config", $template))
            return $obj;

        foreach ($template["config"] as $conf) {
            // 字段组
            if ($conf["type"] == 0) {
                if (array_key_exists("printable", $conf) && $conf["printable"]) {
                    foreach ($conf["children"] as $child) {
                        $child_name = $conf["name"] . " - " . $child["name"];
                        $id = $child["id"];
                        $value = $this->try_get_element($extra_dict, $id, 'value');
                        if ($child["type"] == 4) {
                            $bankinfo = json_decode($value, TRUE);

                            $obj[$child_name . " - 户名"] = $this->try_get_element($bankinfo, "account");
                            $obj[$child_name . " - 账号"] = $this->try_get_element($bankinfo, "cardno");
                            $obj[$child_name . " - 开户行"] = $this->try_get_element($bankinfo, "bankname");
                            $obj[$child_name . " - 开户地"] = $this->try_get_element($bankinfo, "bankloc");
                            $obj[$child_name . " - 开户支行"] = $this->try_get_element($bankinfo, "subbranch");
                        } else {
                            $obj[$child_name] = $value;
                        }
                    }
                }
            }
        }
        return $obj;
    }

    static $stat_style = [
        "金额" => [ "data_type" => "number" ],
        "已付" => [ "data_type" => "number" ],
        "应付" => [ "data_type" => "number" ],
    ];

    static $report_style = [
        "金额" => [ "data_type" => "number" ],
        "已付" => [ "data_type" => "number" ],
        "应付" => [ "data_type" => "number" ],
    ];

    static $item_style = [
        "日期" => [ "data_type" => "date" ],
        "时间" => [ "data_type" => "time" ],
        "金额" => [ "data_type" => "number" ],
        "外币金额" => [ "data_type" => "number" ],
        "汇率" => [ "data_type" => "number", "decimal_places" => 3 ],
        "人民币金额" => [ "data_type" => "number" ],
        "已付" => [ "data_type" => "number" ],
        "应付" => [ "data_type" => "number" ],
    ];

    static $category_style = [
        "总额" => [ "data_type" => "number" ],
        "已付" => [ "data_type" => "number" ],
        "应付" => [ "data_type" => "number" ],
    ];

    private function exports_by_rids($ids) {
        $_data = $this->reports->get_reports_by_ids($ids);
        if (empty($_data) || $_data["status"] < 0) {
            $this->session->set_userdata('last_error', $_data["_msg"]);
            return;
        }

        $data = $_data["data"];
        log_message("debug", "got data => " . json_encode($data));

        $dict_by_template = array();
        foreach ($data["report"] as $id => $r) {
            $template_id = 0;
            if (array_key_exists("template_id", $r) && $r["template_id"]) {
                $template_id = $r["template_id"];
            }

            if (!array_key_exists($template_id, $dict_by_template)) {
                $dict_by_template[$template_id] = array();
            }
            array_push($dict_by_template[$template_id], $r);
        }

        $_categories = $this->category->get_list();

        $simbol_dic = array('cny'=>'人民币','usd'=>'美元','eur'=>'欧元','hkd'=>'港币','mop'=>'澳门币','twd'=>'新台币','jpy'=>'日元','ker'=>'韩国元','gbp'=>'英镑','rub'=>'卢布','sgd'=>'新加坡元','php'=>'菲律宾比索','idr'=>'印尼卢比','myr'=>'马来西亚元','thb'=>'泰铢','cad'=>'加拿大元','aud'=>'澳大利亚元','nzd'=>'新西兰元','chf'=>'瑞士法郎','dkk'=>'丹麦克朗','nok'=>'挪威克朗','sek'=>'瑞典克朗','brl'=>'巴西里亚尔');
        $icon_dic = array('cny'=>'￥','usd'=>'$','eur'=>'€','hkd'=>'$','mop'=>'$','twd'=>'$','jpy'=>'￥','ker'=>'₩','gbp'=>'£','rub'=>'Rbs','sgd'=>'$','php'=>'₱','idr'=>'Rps','myr'=>'$','thb'=>'฿','cad'=>'$','aud'=>'$','nzd'=>'$','chf'=>'₣','dkk'=>'Kr','nok'=>'Kr','sek'=>'Kr','brl'=>'$');

        $profile = $_categories['data']['profile'];
        // 转换消费类型字典
        $dict_item_type_names = array();
        if (array_key_exists('item_type', $profile['group']))
            foreach ($profile['group']['item_type'] as $name)
                $dict_item_type_names[$name['type']] = $name['name'];

        // 转换自定义备注字段
        $dict_customized_note_field = array();
        if (array_key_exists('item_config', $profile['group'])) {
            foreach ($profile['group']['item_config'] as $conf) {
                if ($conf['cid'] == -1 && $conf['type'] == 1) {
                    if ($conf['active'] && !$conf['disabled']) {
                        $dict_customized_note_field[$conf['id']] = $conf['name'];
                    }
                }
            }
        }

        //添加汇率
        $open_exchange = 0 ;
        $company_config = array();
        if(array_key_exists('config',$profile['group']))
            $company_config = json_decode($profile['group']['config'],True);

        // 转换模板字典
        $dict_templates = array();
        if (array_key_exists("report_setting", $profile))
            if (array_key_exists("templates", $profile["report_setting"]))
                foreach ($profile["report_setting"]["templates"] as $t)
                    $dict_templates[$t["id"]] = $t;

        log_message("debug", "got templates => " . json_encode($dict_templates));

        if(array_key_exists('open_exchange',$company_config)) {
            $open_exchange = $company_config['open_exchange'];
        }

        //是否打印类目汇总sheet
        $statistic_using_category = 0;
        if(array_key_exists('statistic_using_category',$company_config))
        {
            $statistic_using_category = $company_config['statistic_using_category'];
        }

        $sobs = array();
        $_sobs = $this->account_set->get_account_set_list();
        if($_sobs['status'])
            $sobs = $_sobs['data'];
        $sob_dic = array();
        $sob_dic[0] = '默认帐套';
        foreach($sobs as $sob) {
            $sob_dic[$sob['sob_id']] = $sob['sob_name'];
        }

        $categories = array();
        $cate_dic = array();
        if($_categories['status'] > 0) {
            $categories = $_categories['data']['categories'];
            if (array_key_exists('categories_disabled', $_categories['data'])) {
                $categories = array_merge(
                    $categories,
                    $_categories['data']['categories_disabled']
                );
            }
        }

        foreach($categories as $cate) {
            if(array_key_exists($cate['sob_id'],$sob_dic))
                $cate_dic[$cate['id']] = array('id' => $cate['id'],'name' => $cate['category_name'],'pid' => $cate['pid'] , 'note' => $cate['note'],'sob_code' => $cate['sob_code'],'sob_name' => $sob_dic[$cate['sob_id']],'sob_id' => $cate['sob_id']);
            else
                $cate_dic[$cate['id']] = array('id' => $cate['id'],'name' => $cate['category_name'],'pid' => $cate['pid'] , 'note' => $cate['note'],'sob_code' => $cate['sob_code'],'sob_name' => '','sob_id' => $cate['sob_id']);

        }
        $group = $this->groups->get_my_full_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        //ugs部门
        $ug = array();
        $_ugs = $this->ug->get_my_list();
        if($_ugs['status'] > 0) {
            $ug = $_ugs['data']['group'];
        }
        $ug_dic = array();
        foreach($ug as $u) {
            $ug_dic[$u['id']] = array('id' => $u['id'], 'name' => $u['name'] ,'pid' => $u['pid']);
        }

        $member_dic = array();
        foreach($gmember as $gm) {
            $member_dic[$gm['id']] = $gm;
        }

        $_ranks = $this->reim_show->rank_level(1);
        $ranks = array();
        $_levels = $this->reim_show->rank_level(0);
        $levels = array();

        if($_ranks['status'] > 0) {
            $ranks = $_ranks['data'];
        }

        if($_levels['status'] > 0) {
            $levels = $_levels['data'];
        }

        $rank_dic = array();
        $level_dic = array();
        foreach($ranks as $r) {
            $rank_dic[$r['id']] = $r['name'];
        }
        foreach($levels as $l) {
            $level_dic[$l['id']] = $l['name'];
        }

        $banks = $data['banks'];
        $_banks = array();

        // TODO: banks 中的信息并不是用户默认的银行信息
        foreach($banks as $b){
            $_banks[$b['uid']] = $b;
        }

        $excel = array();
        foreach ($dict_by_template as $template_id => $_reports) {
            $template = array();
            if (array_key_exists($template_id, $dict_templates))
                $template = $dict_templates[$template_id];

            $_t_items = array();
            // 类目金额汇总
            $category_cells = array();
            $category_cells_dic = array();
            // 报销单汇总
            $stat_cells = array();
            // 报销单明细
            $report_cells = array();
            // 消费明细
            $item_cells = array();
            // 自定义属性 cell 记录
            // 记录这些值用来填充到消费中
            $dict_extra_cells = array();

            $user_bank_field = NULL;
            $public_bank_field = NULL;
            if (array_key_exists("config", $template)) {
                $user_bank_field = $this->get_bank_field_from_template($template, 0);
                $public_bank_field = $this->get_bank_field_from_template($template, 1);
            }

            foreach($_reports as &$r){
                log_message("debug", "process report => " . json_encode(($r)));

                $extra_json = $r["extras"];
                $extra = json_decode($extra_json, TRUE);

                // 用户收款银行
                $userbankinfo = array();
                // 付款账户
                $publicbankinfo = array();

                if ($template) {
                    // extra 里数据太乱了
                    if (is_array($extra)) {
                        $dict_extra = array();
                        foreach ($extra as $e) {
                            $dict_extra[$e["id"]] = $e;
                        }

                        // 尝试取自定义的用户付款银行
                        if (!empty($user_bank_field)) {
                            if (array_key_exists($user_bank_field["id"], $dict_extra)) {
                                $value = $dict_extra[$user_bank_field["id"]]["value"];
                                // 兼容混乱的输入
                                if (is_array($value))
                                    $userbankinfo = $value;
                                else
                                    $userbankinfo = json_decode($value, TRUE);
                                log_message("debug", "found user bank info => " . json_encode($userbankinfo));
                            }
                        }

                        // 尝试取自定义的用户收款银行
                        if (!empty($public_bank_field)) {
                            if (array_key_exists($public_bank_field["id"], $dict_extra)) {
                                $value = $dict_extra[$public_bank_field["id"]]["value"];
                                // 兼容混乱的输入
                                if (is_array($value))
                                    $publicbankinfo = $value;
                                else
                                    $publicbankinfo = json_decode($value, TRUE);
                                log_message("debug", "found public bank info => " . json_encode($publicbankinfo));
                            }
                        }
                    }
                }

                // 取设置的收款银行账号
                $cardno = "";
                if (is_array($userbankinfo) && array_key_exists("cardno", $userbankinfo)) {
                    $cardno = $userbankinfo["cardno"];
                }

                // 如果没有设置取用户的默认设置
                if (!$cardno) {
                    if (array_key_exists($r["uid"], $_banks)) {
                        $userbankinfo = $_banks[$r["uid"]];
                        $cardno = $_banks[$r["uid"]]["cardno"];
                    }
                }

                // 汇总key
                $key_array = array(
                    "name" => $r["nickname"],
                    "usercardno" => $cardno,
                    "publiccardno" => $this->try_get_element($publicbankinfo, "cardno")
                );
                $key = sha1(json_encode($key_array));

                // 构造汇总基本数据
                if (!array_key_exists($key, $stat_cells)) {
                    // 加载自定义字段名称
                    $user_bank_field_prefix = "收款银行";
                    if (!empty($user_bank_field)) {
                        $user_bank_field_prefix = $user_bank_field["name"];
                    }
                    // 加载自定义字段名称
                    $public_bank_field_prefix = "付款银行";
                    if (!empty($public_bank_field)) {
                        $public_bank_field_prefix = $public_bank_field["name"];
                    }

                    $_stat_cells = array();

                    $_stat_cells["提交人"] = $r["nickname"];
                    $_stat_cells[$user_bank_field_prefix . " - 户名"] = $this->try_get_element($userbankinfo, "account");
                    $_stat_cells[$user_bank_field_prefix . " - 账号"] = $this->try_get_element($userbankinfo, "cardno");
                    $_stat_cells[$user_bank_field_prefix . " - 开户行"] = $this->try_get_element($userbankinfo, "bankname");
                    $_stat_cells[$user_bank_field_prefix . " - 开户地"] = $this->try_get_element($userbankinfo, "bankloc");
                    $_stat_cells[$user_bank_field_prefix . " - 开户支行"] = $this->try_get_element($userbankinfo, "subbranch");

                    if (!empty($public_bank_field)) {
                        $_stat_cells[$public_bank_field_prefix . " - 户名"] = $this->try_get_element($publicbankinfo, "account");
                        $_stat_cells[$public_bank_field_prefix . " - 账号"] = $this->try_get_element($publicbankinfo, "cardno");
                        $_stat_cells[$public_bank_field_prefix . " - 开户行"] = $this->try_get_element($publicbankinfo, "bankname");
                        $_stat_cells[$public_bank_field_prefix . " - 开户地"] = $this->try_get_element($publicbankinfo, "bankloc");
                        $_stat_cells[$public_bank_field_prefix . " - 开户支行"] = $this->try_get_element($publicbankinfo, "subbranch");
                    }
                    $_stat_cells["金额"] = 0;
                    $_stat_cells["已付"] = 0;
                    $_stat_cells["应付"] = 0;
                    $_stat_cells["注释"] = "";

                    $stat_cells[$key] = $_stat_cells;
                }

                // 计算报销单审批人列表
                $flow = array();
                $_flow = $this->reports->report_flow($r['id']);
                if($_flow['status'] > 0) {
                    $flow_member = $_flow['data']['data'];
                    foreach($flow_member as $fm) {
                        if($fm['status'] == 2) {
                            array_push($flow,array('name' => $fm['nickname'],'step' => $fm['step']));
                        }
                    }
                }
                $r['flow'] = '';
                if($flow) {
                    usort($flow,function($a,$b) {
                        if($a['step'] == $b['step']) {
                            return 0;
                        }

                        return ($a['step'] > $b['step']) ? -1 : 1;
                    });
                    $f_m = array();
                    foreach($flow as $f) {
                        array_push($f_m,$f['name']);
                    }
                    $r['flow'] = implode(',',$f_m);
                }

                // 金额汇总
                $r['total'] = 0;
                $r['paid'] = 0;

                $_items = $r['items'];
                foreach($_items as $i){
                    $i['amount'] = round($i['amount'], 2);
                    $_rate = 1.0;
                    if(array_key_exists('currency', $i) && (strtolower($i['currency']) != "" && strtolower($i['currency']) != 'cny')) {
                        $_rate = $i['rate'] / 100;
                    }
                    if($open_exchange == 1)
                    {
                        if(array_key_exists('currency', $i) && (strtolower($i['currency']) != "" )){
                            $i['icon_type_name'] = $simbol_dic[$i['currency']];
                            $i['icon_simbol'] = $icon_dic[$i['currency']];
                        }
                        else
                        {
                            $i['icon_type_name'] = '';
                            $i['icon_simbol'] = '';
                        }

                    }

                    $r['total'] += ($i['amount'] * $_rate);
                    $i['paid'] = ($i['amount'] * $_rate);
                    if(in_array($r['status'], array(4, 7, 8))){
                        // 已完成状态的，付款额度就是已付额度
                        $i['paid'] = ($i['amount'] * $_rate);
                    } else {
                        $i['paid'] = 0;
                    }
                    $i['nickname'] = $r['nickname'];
                    $i['rid'] = $r['id'];
                    $i['flow'] = $r['flow'];
                    $i['member_info'] = array('account' => '', 'cardno' => '', 'bankname' => '');
                    if(array_key_exists($r['uid'], $member_dic)) {
                        $i['member_info'] = $member_dic[$r['uid']];
                    }
                    //$r['total'] += ($i['amount'] * $_rate);

                    array_push($_t_items, $i);
                    if($i['reimbursed'] == 0) {
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

                $obj = array();
                $obj['报销单名'] = $r['title'];
                $obj['创建者'] = $r['nickname'];
                $obj['创建日期'] = strftime('%Y年%m月%d日', $r['createdt']);

                // 根据模板信息填充自定义值
                $extra_cells = $this->build_extra_cells($template, $extra);
                $dict_extra_cells[$r["id"]] = $extra_cells;
                $obj = array_merge($obj, $extra_cells);

                $obj['金额'] = $r['total'];
                $obj['已付'] = $r['paid'];
                $obj['应付'] = $r['last'];

                // 累加已完成金额
                $stat_cells[$key]["金额"] += $r["total"];
                $stat_cells[$key]["已付"] += $r["paid"];
                $stat_cells[$key]["应付"] += $r["last"];

                array_push($report_cells, $obj);
            }

            $nicks = $data['nicks'];

            $__members = array();
            foreach($nicks as $i){
                $__members[$i['uid']] =  $i['nickname'];
            }

            foreach($_t_items as $i){
                //初始化类目汇总表单中对应的类目的信息
                if($statistic_using_category)
                {
                    if(!array_key_exists($i['category'],$category_cells_dic))
                    {
                        $sob_name = '';
                        if(array_key_exists($i['category'],$cate_dic))
                        {
                            $sob_name = $cate_dic[$i['category']]['sob_name'];
                        }
                        $category_cells_dic[$i['category']] = array(
                            'sob_name'=> $sob_name,
                            'category_name'=>$i['category_name'],
                            'category_code'=>$i['category_code'],
                            'amount'=>$i['amount'],
                            'pa_amount'=>$i['pa_amount']
                            );
                    }
                    else
                    {
                        $category_cells_dic[$i['category']]['amount'] += $i['amount'];
                        $category_cells_dic[$i['category']]['pa_amount'] += $i['pa_amount'];
                    }
                }

                $i['amount'] = round($i['amount'], 2);
                $_relates = explode(',', $i['relates']);
                $__relates = array();
                foreach($_relates as $r){
                    if(array_key_exists($r, $__members)){
                        array_push($__relates, $__members[$r]);
                    }
                }
                $s = $i['category_code'];
                if($s == 0) $s = '';
                $o = array();
                $o['日期'] = date('Y-m-d', $i['dt']);
                $o['时间'] = date('H:i:s', $i['dt']);
                $o['类别'] = $i['category_name'];
                $o['帐套'] = $this->try_get_element($cate_dic, $i['category'], 'sob_name');
                $o['创建者'] = $i['nickname'];
                $o['邮箱'] = '';
                $o['员工ID'] = '';
                $o['员工手机'] = '';
                $o['上级'] = '';
                $o['部门'] = '';
                $o['上级部门'] = '';
                if(array_key_exists('email',$i['member_info']))
                {
                    $o['邮箱'] = $i['member_info']['email'];
                }
                if(array_key_exists('client_id',$i['member_info']))
                {
                    $o['员工ID'] = $i['member_info']['client_id'];
                }
                if(array_key_exists('phone',$i['member_info']))
                {
                    $o['员工手机'] = $i['member_info']['phone'];
                }
                if(array_key_exists('manager',$i['member_info']))
                {
                    $o['上级'] = $i['member_info']['manager'];
                }
                $_department = array();
                $_higher_department = array();
                if(array_key_exists('d',$i['member_info']))
                {
                    // 20151022 menglin.qin
                    // 来了新玩法了，希望所有的直接部门和上级部门都能列出来，因此，不用再取第一个了
                    $unames = explode('/',$i['member_info']['d']);
                    foreach($unames as $name) {
                        $_name = explode("-", $name);
                        if(count($_name) > 1) {
                            array_push($_higher_department, $_name[0]);
                            array_push($_department, $_name[1]);
                        } else {
                            array_push($_department, $_name[0]);
                            array_push($_higher_department, '无');
                        }
                    }
                    $o['上级部门'] = implode(',', $_higher_department);
                    $o['部门'] = implode(',', $_department);
                }
                $o['级别'] = '';
                $o['职位'] = '';

                if(array_key_exists('rank_id',$i['member_info']))
                {
                    if($i['member_info']['rank_id'] > 0)
                    {
                        $o['级别'] = $rank_dic[$i['member_info']['rank_id']];
                    }
                }
                if(array_key_exists('level_id',$i['member_info']))
                {
                    if($i['member_info']['level_id'] > 0)
                    {
                        $o['职位'] = $level_dic[$i['member_info']['level_id']];
                    }
                }
                //$o['类别'] = $i['category_name'];
                $_str_afford_dept = $o['部门'];
                $_str_afford_member = $i['nickname'];
                if($i['afford_ids'] != "-1" && $i['afford_ids'] != "")
                {
                    $_str_afford_dept = trim($i['fee_afford_group_name'],',');
                    $_str_afford_member = trim($i['fee_afford_object_name'],',');
                }
                $o['商家'] = $i['merchants'];
                $o['参与人员'] = implode(',', $__relates);
                $o['承担部门'] = $_str_afford_dept;
                $o['承担对象'] = $_str_afford_member;
                if (array_key_exists("tag_names", $i)) {
                    $o['标签'] = $i['tag_names'];
                }
                $o['一级会计科目'] = '';
                $o['一级会计科目代码'] = '';
                $o['二级会计科目'] = '';
                $o['二级会计科目代码'] = '';
                if (array_key_exists($i['category'], $cate_dic)) {
                    $cate = $cate_dic[$i['category']];
                    if (array_key_exists($cate['pid'], $cate_dic)) {
                        $p_cate = $cate_dic[$cate['pid']];
                        $o['一级会计科目'] = $p_cate['name'];
                        $o['一级会计科目代码'] = $p_cate['sob_code'];
                        $o['二级会计科目'] = $cate['name'];;
                        $o['二级会计科目代码'] = $cate['sob_code'];;
                    } else {
                        $o['一级会计科目'] = $cate['name'];
                        $o['一级会计科目代码'] = $cate['sob_code'];
                    }
                }
                $o['报销审核人'] = $i['flow'];
                foreach ($dict_customized_note_field as $fid => $fname) {
                    $o[$fname] = '';
                    if (!empty($i['extra'][$fid])) {
                        $o[$fname] = $i['extra'][$fid]['value'];
                    }
                }
                $o['备注'] = $i['note'];
                $o['消费类型'] = $this->try_get_element($dict_item_type_names, $i['prove_ahead']);
                $_rate = 1.0;
                if($i['currency'] != '' && strtolower($i['currency']) != 'cny') {
                    $_rate = $i['rate'] / 100;
                }
                if($open_exchange == 1)
                {
                    $o['币种名称'] = $i['icon_type_name'] . '(' .$i['icon_simbol'] . ')';
                    //                        $o['外币金额'] = (string)$i['amount'] . $i['icon_simbol'];
                    $o['外币金额'] = $i['amount'];
                    $o['汇率'] = '1.0';
                    if($i['currency'] != 'cny')
                        $o['汇率'] = round($i['rate']/100,6);
                }
                $o['人民币金额'] = round($i['amount'] * $_rate, 2);
                $_paid = 0;
                if($i['prove_ahead'] > 0){
                    $_paid = $i['pa_amount'];
                }
                $_last = $i['amount'] - $_paid;
                //                $o['已付'] = (string)($i['paid']) . '￥';
                $o['已付'] = $i['paid'];
                //                $o['应付'] = (string)(($i['amount'] * $_rate) - $i['paid']) . '￥';
                $o['应付'] = $i['amount'] * $_rate - $i['paid'];
                $o['报销单名'] = $i['title'];
                $o['报销单ID'] = $i['rid'];

                // 合并进来自定义字段
                if (array_key_exists($i["rid"], $dict_extra_cells)) {
                    $o = array_merge($o, $dict_extra_cells[$i["rid"]]);
                }

                array_push($item_cells, $o);
            }

            $template_name = "";
            if ($template)
                $template_name = $template["name"];

            $template_excel = [
                [ "title" => "报销单汇总", "data" => array_values($stat_cells), "style" => self::$stat_style ],
                [ "title" => "报销单明细", "data"  => $report_cells, "style" => self::$report_style ],
                [ "title" => "消费明细", "data" => $item_cells, "style" => self::$item_style ],
            ];
            if($statistic_using_category)
            {
                foreach($category_cells_dic as $ccd)
                {
                    $o = array();
                    $o['帐套'] = $ccd['sob_name'];
                    $o['类目'] = $ccd['category_name'];
                    $o['类目代码'] = $ccd['category_code'];
                    $o['总额'] = $ccd['amount'];
                    $o['应付'] = $ccd['amount'] - $ccd['pa_amount'];
                    $o['已付'] = $ccd['pa_amount'];
                    array_push($category_cells,$o);
                }
                $template_excel[] = [ "title" => "类目金额汇总", "data" => $category_cells, "style" => self::$category_style ];
            }

            log_message("debug", "报销单汇总 => " . json_encode($stat_cells));
            log_message("debug", "报销单明细 => " . json_encode($report_cells));
            log_message("debug", "消费明细 => " . json_encode($item_cells));
            log_message("debug", "类目金额汇总 => " . json_encode($category_cells));

            // 重命名已存在同名模板
            if (array_key_exists($template_name, $excel)) {
                $_excel = $excel[$template_name];
                unset($excel[$template_name]);
                $excel[$template_name . "1"] = $_excel;
                $excel[$template_name . "2"] = $template_excel;
            } elseif (array_key_exists($template_name + "1", $excel)) {
                for ($i = 2; $i < 255; $i++) {
                    if (!array_key_exists($template_name . $i, $excel)) {
                        $excel[$template_name . $i] = $template_excel;
                        break;
                    }
                }
            } else {
                $excel[$template_name] = $template_excel;
            }
        }

        $excel_name = '报销报销单列表' . date('Y-m-d', time()) . '.xls';

        $data = array();
        foreach ($excel as $template_name => $template_excel) {
            foreach ($template_excel as $excel) {
                $title = $excel['title'];
                if (!empty($template_name))
                    $title = $template_name . " - " . $name;

                array_push($data, array(
                    "title" => $title,
                    "data" => $excel['data'],
                    "style" => $excel['style'],
                ));
            }
        }

        self::render_to_download_2($excel_name, $data);
    }

    public function exports(){
        ini_set('memory_limit', '1024M');
        $ids = $this->input->post('ids');
        if("" == $ids) die("");
        $this->exports_by_rids($ids);
    }

    public function exports_test($id)
    {
        $profile = $this->session->userdata('profile');
        $open_exchange = 0 ;
        $company_config = array();
        if(array_key_exists('config',$profile['group']))
            $company_config = json_decode($profile['group']['config'],True);
        if(array_key_exists('open_exchange',$company_config))
        {
            $open_exchange = $company_config['open_exchange'];
        }
        log_message('debug','open_exchange:' . $open_exchange);

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
        redirect(base_url('reports/audit_todo'));
    }

    public function export_u8(){
        $ids = $this->input->post('ids');
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
        if ($data['status'] <= 0) {
            return;
        }
        $_excel = array();
        $_members = array();
        $_reports = $data['data'];
        $reports = $_reports['report'];
        $groups = $_reports['groups'];
        //log_message("debug", "GROUPS:" . json_encode($groups));
        $_headers = array(
            '凭证ID' => 0,
            '会计年' => date('Y'),
            '会计期间' => date('m'),
            '制单日期' => date('Y-m-d'),
            '凭证类别' => '转',
            '凭证号' => 0,
            '制单人' => $_maker,
            '所附单据数' => '',
            '备注1' => '',
            '备注2' => '',
            '科目编码' => 0,
            '摘要' => '',
            '结算方式编码' => '',
            '票据号' => '',
            '票据日期' => '',
            '币种名称' => '人民币',
            '汇率' => '',
            '单价' => '',
            '借方数量' => '',
            '贷方数量' => '',
            '贷方数量' => '',
            '原币借方' => '',
            '原币贷方' => '',
            '借方金额' => 0,
            '贷方金额' => 0,
            '部门编码' => 0,
            '职员编码' => '',
            '客户编码' => '',
            '供应商编码' => '',
            '项目大类编码' => '',
            '项目编码' => '',
            '业务员' => '',
            '自定义项1' => '',
            '自定义项2' => '',
            '自定义项3' => '',
            '自定义项4' => '',
            '自定义项5' => '',
            '自定义项6' => '',
            '自定义项7' => '',
            '自定义项8' => '',
            '自定义项9' => '',
            '自定义项10' => '',
            '自定义项11' => '',
            '自定义项12' => '',
            '自定义项13' => '',
            '自定义项14' => '',
            '自定义项15' => '',
            '自定义项16' => '',
            '现金流项目' => '',
            '现金流量借方金额' => '',
            '现金流量贷方金额' => '',
        );
        $idx = 0;
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
            //log_message("debug", json_encode($r));
            $r['total'] = 0;
            $r['paid'] = 0;
            $_items = $r['items'];
            foreach($_items as $i){
                $idx += 1;
                //log_message("debug", "Item:" . json_encode($i));
                $o = $_headers;
                $o['凭证号'] = $r['id'];
                $o['摘要'] = '计提' . date('m月') . '员工报销 - ' . $i['category_name']  . ' - ' . $r['nickname'];
                $o['部门编码'] = implode(',', $_gids);
                $o['职员编码'] = $r['client_id'];

                $rate = 1.0;
                if(trim($i['currency']) != '' && strtolower($i['currency']) != 'cny') {
                    $rate = $i['rate'] / 100;
                }
                $_amount = round($i['amount'], 2);
                if($i['prove_ahead'] == 2){
                    $_amount = sprintf("%.2f", $i['amount'] - $i['pa_amount']);
                }
                $amount = sprintf("%.2f",$_amount * $rate);

                $o['凭证ID'] = $idx;
                $o['科目编码'] = $i['category_code'];
                $o['借方金额'] = $amount;
                $o['贷方金额'] = '';
                array_push($_excel, $o);

                $o['凭证ID'] = $idx;
                $o['科目编码'] = 1002;
                $o['借方金额'] = '';
                $o['贷方金额'] = $amount;
                array_push($_excel, $o);
            }
        }
        //print_r($_excel);

        $filename = 'u8_' . date('Y-m-d', time()) . ".xls";
        $style = [
            "制单日期" => [ "data_type" => "date" ],
            "科目编码" => [ "data_type" => "number", "decimal_places" => 0 ],
            "贷方金额" => [ "data_type" => "number" ],
            "借方金额" => [ "data_type" => "number" ],
        ];
        $data = [
            [
                'title' => 'sheet1',
                'data' => $_excel,
                'style' => $style,
            ]
        ];
        self::render_to_download_2($filename, $data);
    }

    public function report_template($id = 0){
        if($id == 0) return redirect(base_url('reports/newreport'));
        $profile = array();
        $_common = $this->users->get_common();
        if($_common['status'] > 0 && array_key_exists('profile',$_common['data']))
        {
            $profile = $_common['data']['profile'];
        }
        $item_type_dic = $this->reim_show->get_item_type_name();
        $config = array();
        if($profile && array_key_exists('report_setting',$profile) && array_key_exists('templates', $profile['report_setting'])) {
            $report_template = $profile['report_setting']['templates'];
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
                log_message('debug','config:' . json_encode($config));
                log_message('debug','profile:' . json_encode($profile));

                $banks = array();
                if(array_key_exists('banks',$profile))
                {
                    $banks = $profile['banks'];
                }
                return $this->bsload('reports/template_new',
                    array(
                        'title' => '新建[' . $config['name'] . '] 报销单',
                        'members' => $_members,
                        'config' => $config,
                        'banks' => $banks,
                        'item_type_dic' => $item_type_dic,
                        'items' => $_items
                        ,'breadcrumbs' => array(
                            array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                            ,array('url'  => base_url('reports/index'), 'name' => '报销单', 'class' => '')
                            ,array('url'  => '', 'name' => '新建' . $config['name'] . '', 'class' => '')
                        ),
            ));
            }
        }
        return redirect(base_url('reports/newreport'));
    }


    public function check_submit(){
        $items = $this->input->post('item');
        if(''==$items)
        {
            $this->session->set_userdata('last_error','提交报销单不能为空');
            return redirect(base_url('reports/index'));
        }
        $receiver = $this->input->post('receiver');
        $buf = $this->reports->submit_check(implode(',', $receiver), implode(',', $items));
        die($buf);
    }
}

