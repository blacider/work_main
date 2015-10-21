<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
        $this->load->model('report_model', 'report');
        $this->load->model('user_model','user');
        $this->load->model('group_model', 'groups');
    }

    public function avatar(){
        if(!empty($_FILES)) {
            // 默认是item
            //$type = $this->input->post('type');
            //if(!$type) $type = 0;
            $type = 0;
            log_message("debug", json_encode($_FILES));
            log_message("debug", "type: " . $type);
            $uploaddir = '/data/uploads/';
            $uploadfile = $uploaddir . md5(time()) . "_" . basename($_FILES['file']['name']);
            if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $img = $this->items->upload_image($uploadfile, $type);
                if($img['status'] > 0) unlink($uploadfile);
                die(json_encode($img));
            }
        } else {
            die("");
        }
        //$file = realpath('snapshot.jpg'); //要上传的文件

    }

    public function images(){
        if(!empty($_FILES)) {
            // 默认是item
            //$type = $this->input->post('type');
            $type = 1;
            log_message("debug", json_encode($_FILES));
            log_message("debug", "type: " . $type);
            $uploaddir = '/data/uploads/';
            $uploadfile = $uploaddir . md5(time()) . "_" . basename($_FILES['file']['name']);
            log_message("debug", "还行~haixing");
            if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

                $img = $this->items->upload_image($uploadfile, $type);
                if ($img['status'] > 0) unlink($uploadfile);
                die(json_encode($img));
            }
        } else {
            die('');

        }
        //log_message("debug", "还行~haixing");
        //$file = realpath('snapshot.jpg'); //要上传的文件


    }

    public function newitem(){
        //        $profile = $this->session->userdata('profile');
        $_profile = $this->user->reim_get_user();	
        $profile = array();
        $group_config = array();
        $item_configs = array();
        $item_config = array();
        if($_profile)
        {
            $profile = $_profile['data']['profile'];
        }
        log_message('debug' , 'profile:' . json_encode($profile));
        if(array_key_exists('group',$profile))
        {
            $group_config = $profile['group'];
            if(array_key_exists('item_config',$group_config))
            {
                $item_configs = $group_config['item_config'];
                foreach($item_configs as $conf)
                {
                    array_push($item_config,array('active'=>$conf['active'],'id'=>$conf['id'],'type'=>$conf['type'],'cid'=>$conf['cid'], 'name' => $conf['name']));	
                }
            }
        }
        $afford = array();
        if(array_key_exists('fee_afford', $profile)){
            $afford = $profile['fee_afford'];
        }
        $sobs = array();
        if(array_key_exists('sob',$profile))
        {
             $sobs = $profile['sob'];
        }
        $_sob_id = array();
        $_sobs = array();
        foreach($sobs as $i) {
            log_message('debug', "alvayang:" . json_encode($i));
            array_push($_sob_id, $i['sob_id']);
            array_push($_sobs, $i);
        }
        $category = $this->category->get_list();
        log_message('debug', "category:" . json_encode($category));
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }

        $_categories = array();
        foreach($categories as $cate) {
            log_message('debug', "alvayang category:" . json_encode($cate));
            if(count($_sob_id) > 0) {
                if(in_array('sob_id', $cate) && in_array($cate['sob_id'], $_sob_id)) {
                    array_push($_categories, $cate);
                }
            } else {
                array_push($_categories, $cate);
            }
        }
        $user = $this->session->userdata('profile');
        $group = $this->groups->get_my_list();
        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
		log_message('debug','afford:'. json_encode($afford));
        $is_burden = true;
        if(!$afford)
        {
           $is_burden = false; 
        }
        $this->bsload('items/new',
            array(
                'title' => '新建消费'
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                    ,array('url'  => '', 'name' => '新建消费', 'class' => '')
                ),
                'categories' => $categories,
                'afford' => $afford,
                'sobs' => $_sobs,
                'user' => $user['id'],
                'member'=>$gmember,
                'categories' => $_categories,
                'tags' => $tags,
                'item_config' => $item_config,
                'is_burden' => $is_burden
            ));
    }
    public function index(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->session->set_userdata('item_update_in','0');
        $items = $this->items->get_list();
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $categories) && array_key_exists('categories', $categories['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['items'];
            $this->bsload('items/index',
                array(
                    'title' => '我的消费',
                    'category' => $categories,
                    'tags' => $tags,
                    'error' => $error,
                    'items' => $item_data
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                        ,array('url'  => '', 'name' => '我的消费', 'class' => '')
                    ),
                ));
        }
    }

    public function create(){
        $_uids = $this->input->post('uids');
        $uids = '';
        if($_uids)
        {
            $uids = implode(',',$_uids);
        }
        $profile = $this->session->userdata('profile');
        $afford_ids = $this->input->post('afford_ids');
        if(!$afford_ids) $afford_ids = -1;
        $amount = $this->input->post('amount');
        $category= $this->input->post('category');
        $timestamp = strtotime($this->input->post('dt'));
        $endtime = strtotime($this->input->post('dt_end'));
        $config_id = $this->input->post('config_id');
        $config_type = $this->input->post('config_type');
        $subs = $this->input->post('peoples');
        $note_2 = $this->input->post('note_2');
        log_message('debug','config_id:' . $config_id);
        log_message('debug','config_type:' . $config_type);
        log_message('debug','afford_ids:' . $afford_ids);
        $extra = array();
        $_extra = array();
        if($config_type == 2)
        {
            $_extra = array('id'=>$config_id ,'type'=>$config_type,'value'=>$endtime);
        }
        if($config_type == 1)
        {
            $_extra = array('id'=>$config_id ,'type'=>$config_type,'value'=>$note_2);
        }

        if($config_type == 5)
        {
            $_extra = array('id'=>$config_id ,'type'=>$config_type,'value'=>$subs);
        }
        array_push($extra,$_extra);
        $_hidden_extra = $this->input->post('hidden_extra');
        if($_hidden_extra) {
            $_hidden_extra = json_decode($_hidden_extra);
            array_push($_hidden_extra, $_extra);
            $extra = $_hidden_extra;
        }
        $__extra = json_encode($extra);
        $merchant = $this->input->post('merchant');
        $tags = $this->input->post('tags');
        $type = $this->input->post('type');
        $note = $this->input->post('note');
        $images = $this->input->post('images');
        $renew = $this->input->post('renew');
        $obj = $this->items->create($amount, $category, $tags, $timestamp, $merchant, $type, $note, $images,$__extra,$uids, $afford_ids);
        log_message('debug','TM extra:' . $__extra);

        log_message('debug','create_item_back:' . json_encode($obj));
        // TODO: 提醒的Tips
        if($renew){
            redirect(base_url('items/newitem'));
        } else {
            redirect(base_url('items/index'));
        }
    }


    public function listdata(){
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
            log_message("debug","list item:" . json_encode($data));
            foreach($item_data as &$s){
                //if($s['status'] < 0) continue;
                $s['cate_str'] = '未指定的分类';
                $s['createdt'] = strftime("%Y-%m-%d %H:%M", intval($s['createdt']));
                $s['dt'] = strftime("%Y-%m-%d %H:%M", intval($s['dt']));
                $_type = '报销';
                switch($s['type']){
                case 1: {$_type = '预算';};break;
                case 2: {$_type = '预借';};break;
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
                //$s['amount'] = '￥' . $s['amount'];
                //$s['amount'] = '￥' . $s['amount'];
                $s['status_str'] = '';
                log_message("debug", "Item:" . json_encode($s));
                $trash= $s['status'] === 0 ? 'gray' : 'red';
                $edit = $s['status'] === 0 ? 'gray' : 'green';
                $edit_str = '';
                if(in_array($s['status'], array(-1, 0, 3))) {
                    $edit_str =  '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $s['id'] . '"></span>'
                  	.  '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>';
                } else {
                    $edit_str =  '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $s['id'] . '"></span>';
                }


                $s['options'] = '<div class="action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . $edit_str
                    . '</div>';
                switch($s['status']){
                case -1: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#A07358;background:#A07358 !important;">待提交</button>';
                };break;
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
                case 7: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成待确认</button>';
                };break;
                case 8: {
                    $s['status_str'] = '<button class="btn  btn-minier disabled" style="opacity:1;border-color:#CFD1D2;background:#CFD1D2 !important;">完成已确认</button>';
                };break;
                default: {
                    $s['status_str'] = $s['status'];
                }
                }
                array_push($_items, $s);
            }
            die(json_encode($_items));
        }
    }


    public function del($id = 0,$flag = 0){
        if(0 == $id) redirect(base_url('items'));
        $obj = $this->items->remove($id);
        log_message('debug' , 'del_item:' . json_encode($obj));
        if(!$obj['status']) {
            $msg = $obj['data']['msg'];
            $this->session->set_userdata('last_error', $msg);
        }
        if ($flag == 1) 
        {
           // redirect(base_url('reports/newreport'));
           die(josn_encode(array('data'=>'success'))); 
        }
        else redirect(base_url('items'));
    }

    public function ishow($id = 0) {
        if(0 === $id) redirect(base_url('items'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $_profile = $this->user->reim_get_user();	
        $profile = array();
        $group_config = array();
        $item_configs = array();
        $item_config = array();
        if($_profile)
        {
            $profile = $_profile['data']['profile'];
        }
        log_message('debug' , 'profile:' . json_encode($profile));
        if(array_key_exists('group',$profile))
        {
            $group_config = $profile['group'];
            if(array_key_exists('item_config',$group_config))
            {
                $item_configs = $group_config['item_config'];
                foreach($item_configs as $conf)
                {
                    array_push($item_config,array('id'=>$conf['id'],'type'=>$conf['type'],'cid'=>$conf['cid'], 'name' => $conf['name']));	
                }
            }
        }
        $obj = $this->items->get_by_id($id);
        $item_update_in = $this->session->userdata('item_update_in');	
        if($obj['status'] < 1){
            redirect(base_url('items'));
        }
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }
        $item = $obj['data'];
		$fee_afford_ids = array();
		if(array_key_exists('afford_ids',$item))
		{
			$fee_afford_ids = explode(',',$item['afford_ids']);
		}
		
        $afford = array();
        if(array_key_exists('fee_afford', $profile)){
            $afford = $profile['fee_afford'];
        }
		$afford_dic = array();
		foreach($afford as $af)
		{
			$afford_dic[$af['id']] = array();
			if(array_key_exists('dept',$af)){
				foreach($af['dept'] as $a){
					if(array_key_exists('member',$a)){
						foreach($a['member'] as $m)
						{
							array_push($afford_dic[$af['id']],$m['id']);
						}
					}
					else
					{
							array_push($afford_dic[$af['id']],$a['id']);
					}
				}	
			}
		}
		log_message('debug','afford_dic:' . json_encode($afford_dic));
		
		$afford_type = -1 ;
		if($fee_afford_ids){
			foreach($afford_dic as $key => $it){
				if(in_array($fee_afford_ids[0],$it)){
					$afford_type = $key;
					break;
				}
			}
		}
	log_message('debug','fee_afford_ids : ' .json_encode($fee_afford_ids));
	log_message('debug','fee_afford_type : ' .json_encode($afford_type));
    /*$item_value = '';
    if(array_key_exists('extra',$item))
    {
        foreach($item['extra'] as $it)
        {
        log_message('debug' , 'it:' . json_encode($it));
        if(array_key_exists('value',$it))
        {
            $item_value = $it['value'];	
        $item_value = date('Y-m-d H:i:s',$item_value);
        }
        }
    }
     */
        $item_value = array();
        if(array_key_exists('extra',$item))
        {
            $_item_value = $item['extra'];
            foreach($_item_value as $it)
            {
                $item_value[$it['type']] = array('id'=>$it['id'],'type'=>$it['type'],'value'=>$it['value']);
            }
        }
        $cid = $item['category'];
        $_tags = $item['tags'];
        $__tags_name = array();

        $user = $this->session->userdata('profile');
        log_message('debu','item_info:' . json_encode($item));
        log_message("debug", "USER:" . json_encode($user));
        $_uid = $user['id'];

        $_editable = 0;
        //log_message("debug", "***** Rstatus: $_uid ********** " . $item['rstatus'] . ", " . $item['uid']);
        // 收到的,检查我是否是被cc，以及状态
        $_rid = $item['rid'];
        if($_rid > 0 ){
            $_relate_report = $this->report->get_report_by_id($_rid);
            //log_message("debug", "Find :" . json_encode($_relate_report));
            //log_message("debug", "Relate Report:" . $_relate_report['data']['status']);
            if($_relate_report['status']){
                $_report = $_relate_report['data'];
                $_cc = $_relate_report['data']['cc'];
                if(in_array($_relate_report['data']['status'], array(0, 3))) {
                    $_editable = 1;
                }
            }
        } else {
            $_editable = 1;
        }
        //}


        // TODO 去提升效率
        foreach(explode(',', $_tags) as $t){
            foreach($tags as $_t){
                if($_t['id'] == $t){
                    if(array_key_exists('tag_name',$_t))
                    {
                        array_push($__tags_name, $_t['tag_name']);
                    }
                }
            }
        }

        $item['tags'] = implode(',', $__tags_name);
        foreach($categories as $c){
            if($c['id'] == $cid) {
                $item['category'] = $c['category_name'];
            }
        }
        $_type = '报销';
        $prove_ahead = $item['prove_ahead'];
        switch($prove_ahead) {
        case 0:{$_type = '报销';};break;
        case 1:{$_type = '预算';};break;
        case 2:{$_type = '预借';};break;
        }
        $item['prove_ahead'] = $_type;

        $_flow = $this->items->item_flow($id);
        $flow = array();
        if ($_flow['status'] == 1) {
            foreach ($_flow['data'] as $d) {
                $peropt = $this->str_split_unicode($d['newvalue'],1);
                array_push($flow, array(
                    'operator' => $peropt['name'],
                    'optdate' => $d['submitdt'],
                    'operation' => $peropt['opt'],
                ));
            }
        }
        $group = $this->groups->get_my_list();
        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $item['dt'] = date('Y-m-d H:i:s',$item['dt']);
        log_message("debug", "ITEM:" . json_encode($item));
        $this->bsload('items/iview',
            array(
                'title' => '查看消费',
                'categories' => $categories,
                'tags' => $tags,
                'item' => $item,
                'previous_url' => base_url("items"),
                "item_config" => $item_config,
                'editable' => $_editable,
                'flow' => $flow
                ,'item_value' => $item_value
                ,'error' => $error
                ,'member' => $gmember
				,'afford' => $afford
				,'fee_afford_ids' => implode(',',$fee_afford_ids)
				,'fee_afford_type' => $afford_type
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                    ,array('url'  => '', 'name' => '查看消费', 'class' => '')
                ),
            ));
    }

    public function show($id = 0, $from_report = 0){
        if(0 === $id) redirect(base_url('items'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $obj = $this->items->get_by_id($id);
        if($obj['status'] < 1){
            redirect(base_url('items'));
        }

        $_profile = $this->user->reim_get_user();	
        $profile = array();
        $group_config = array();
        $item_configs = array();
        $item_config = array();
        if($_profile)
        {
            $profile = $_profile['data']['profile'];
        }
        log_message('debug' , 'profile:' . json_encode($profile));
        if(array_key_exists('group',$profile))
        {
            $group_config = $profile['group'];
            if(array_key_exists('item_config',$group_config))
            {
                $item_configs = $group_config['item_config'];
                foreach($item_configs as $conf)
                {
                    array_push($item_config,array('id'=>$conf['id'],'type'=>$conf['type'],'cid'=>$conf['cid'], 'name' => $conf['name']));	
                }
            }
        }
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }
        $item = $obj['data'];
        //$item_value = '';
        $item['dt'] = date('Y-m-d H:i:s',$item['dt']);
        $item_value = array();
        if(array_key_exists('extra',$item))
        {
            $_item_value = $item['extra'];
            foreach($_item_value as $it)
            {
                $item_value[$it['type']] = array('id'=>$it['id'],'type'=>$it['type'],'value'=>$it['value']);
            }
        }
        $cid = $item['category'];
        $_tags = $item['tags'];
        $__tags_name = array();

        $user = $this->session->userdata('profile');
        $_uid = $user['id'];

        $_editable = 0;
        //if($_uid == $item['uid'] ) {
        //    // 如果是自己的，那么检查状态
        //log_message("debug", "***** Rstatus: $_uid ********** " . $item['rstatus'] . ", " . $item['uid']);
        //    if(in_array($item['rstatus'], array(-1, 0, 3))) {
        //        $_editable = 1;
        //    }
        //} else {
        // 收到的,检查我是否是被cc，以及状态
        $_rid = $item['rid'];
        if($_rid > 0 ){
            $_relate_report = $this->report->get_report_by_id($_rid);
            log_message("debug", "Find :" . json_encode($_relate_report));
            log_message("debug", "Relate Report:" . $_relate_report['data']['status']);
            if($_relate_report['status']){

                $_report = $_relate_report['data'];
                $_cc = $_relate_report['data']['cc'];
                log_message("debug", "Report UID:" . $_report['uid'] . ", CUID:" . $_uid);
                if($_cc < 0 && $user['admin'] > 0) {
                    $_editable = 1;
                } else {
                    if($_report['uid'] == $_uid) {
                        if(in_array($_relate_report['data']['status'], array(0, 3))) {
                            $_editable = 1;
                        }
                    } elseif (in_array($_relate_report['data']['status'], array(1, 2))) {
                        $_editable = 1;
                    }
                }
            }
        } else {
            $_editable = 1;
        }



        log_message("debug","_tags*****".json_encode(explode(',', $_tags)));
        log_message("debug","tags#####".json_encode($tags));
        // TODO 去提升效率
        foreach(explode(',', $_tags) as $t){
            foreach($tags as $_t){
                if($_t['id'] == $t){
                    if(array_key_exists('tag_name',$_t))
                    {
                        array_push($__tags_name, $_t['tag_name']);
                    }
                }
            }
        }

        $item['tags'] = implode(',', $__tags_name);
        foreach($categories as $c){
            if($c['id'] == $cid) {
                $item['category'] = $c['category_name'];
            }
        }
        $_type = '报销';
        $prove_ahead = $item['prove_ahead'];
        switch($prove_ahead) {
        case 0:{$_type = '报销';};break;
        case 1:{$_type = '预算';};break;
        case 2:{$_type = '预借';};break;
        }
        $item['prove_ahead'] = $_type;

        $_flow = $this->items->item_flow($id);
        $flow = array();
        if ($_flow['status'] == 1) {
            foreach ($_flow['data'] as $d) {
                //                $peropt = $this->str_split_unicode($d['newvalue'],1);
                $peropt = $this->flow_str_split($d['newvalue']);
                array_push($flow, array(
                    'operator' => $peropt['name'],
                    'optdate' => $d['submitdt'],
                    'operation' => $peropt['opt'],
                ));
            }
        }
        $group = $this->groups->get_my_list();
        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }

        $previous_url = base_url("items");
        if ($from_report)
            if ($item["rid"])
                $previous_url = base_url("reports/show/" . $item["rid"]);
        
        log_message("debug","item_updta_in".$this->session->userdata("item_update_in"));
        log_message("debug","flow".json_encode($flow));
        log_message("debug","users:".json_encode($user));
        
        $this->bsload('items/view',
            array(
                'title' => '查看消费',
                'categories' => $categories,
                'tags' => $tags,
                'item' => $item,
                "from_report" => $from_report,
                "item_config" => $item_config,
                'previous_url' => $previous_url,
                'editable' => $_editable,
                'flow' => $flow
                ,'item_value' => $item_value
                ,'error' => $error
                ,'member' => $gmember
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                    ,array('url'  => '', 'name' => '查看消费', 'class' => '')
                ),
            ));
    }


    function str_split_unicode($str, $l = 0) {
        if ($l > 0) {
            $ret = array();
            $len = mb_strlen($str, "UTF-8");
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l, "UTF-8");
            }
            $arr = $ret;
            $i = 0;
            for (; $i < count($arr); $i++) { 
                if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$arr[$i])) {
                    break;
                }
            }
            $name = array();
            $opt = array();
            for ($j = 0; $j < count($arr); $j++) {
                if ($j < $i) {
                    array_push($name, $arr[$j]);
                } else {
                    array_push($opt, $arr[$j]);
                }   
            }
            $name = join($name);
            $opt = join($opt);
            return array(
                'name' => $name,
                'opt' => $opt
            );
        }

        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
    function flow_str_split($str)
    {
        if($str!='')
        {
            $temp = explode(' ',$str,2);
            return array('name' => $temp[0]
                ,'opt' => $temp[1]);
        }
        else
        {
            return array('name' => ''
                ,'opt' => '');
        }
    }

    public function edit($id = 0, $from_report = 0) {
        log_message('debug','item_id' . $id);
        if(0 === $id) redirect(base_url('items'));
        $_profile = $this->user->reim_get_user();	
        $profile = array();
        $group_config = array();
        $item_configs = array();
        $item_config = array();
        if($_profile)
        {
            $profile = $_profile['data']['profile'];
        }
        log_message('debug' , 'profile:' . json_encode($profile));
        if(array_key_exists('group',$profile))
        {
            $group_config = $profile['group'];
            if(array_key_exists('item_config',$group_config))
            {
                $item_configs = $group_config['item_config'];
                foreach($item_configs as $conf)
                {
                    array_push($item_config,array('active'=>$conf['active'],'id'=>$conf['id'],'type'=>$conf['type'],'cid'=>$conf['cid'], 'name' => $conf['name']));	
                }
            }
        }
        $item = $this->items->get_by_id($id);
        $item_update_in = $this->session->userdata('item_update_in');
        if($item['status'] < 1){
            $this->session->set_userdata('last_error',$item['data']['msg']);
            redirect(base_url('items'));
        }
        $item = $item['data'];

		log_message('debug','afford_items:' . json_encode($item));

		$fee_afford_ids = array();
		if(array_key_exists('afford_ids',$item))
		{
			$fee_afford_ids = explode(',',$item['afford_ids']);
		}
		
        $afford = array();
        if(array_key_exists('fee_afford', $profile)){
            $afford = $profile['fee_afford'];
        }
		log_message('debug','afford:' . json_encode($afford));
		$afford_dic = array();
		foreach($afford as $af)
		{
			$afford_dic[$af['id']] = array();
			if(array_key_exists('dept',$af)){
				foreach($af['dept'] as $a){
					if(array_key_exists('member',$a)){
						foreach($a['member'] as $m)
						{
							array_push($afford_dic[$af['id']],$m['id']);
						}
					}
					else
					{
							array_push($afford_dic[$af['id']],$a['id']);
					}
				}	
			}
		}
		log_message('debug','afford_dic:' . json_encode($afford_dic));
		
		$afford_type = -1 ;
		if($fee_afford_ids){
			foreach($afford_dic as $key => $it){
				if(in_array($fee_afford_ids[0],$it)){
					$afford_type = $key;
					break;
				}
			}
		}
		log_message('debug','afford_type:' . json_encode($afford_type));
		log_message('debug','fee_afford_ids:' . json_encode($fee_afford_ids));
		
        $item_value = array();
        if(array_key_exists('extra',$item))
        {
            foreach($item['extra'] as $it)
            {
                log_message('debug' , 'extra it:' . json_encode($it));
                if(array_key_exists('value',$it))
                {
                    $item_value[$it['type']] = array('id'=> $it['id'], 'type' => $it['type'], 'value' => $it['value']);
                }
            }
        }
        log_message('debug','all_item:' . json_encode($item));
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
        }
        $images = $item['images'];
        $_images = array();
        $_image_ids = array();
        foreach($images as $i){
            array_push($_image_ids, $i['id']);
            $info = get_headers($i['path']);
            $_type = '';
            $_size = 0;
            foreach($info as $t){
                $t = strtolower($t);
                if(substr($t, 0, strlen('content-type')) == "content-type"){
                    $_type = substr($t, strlen('content-type: '));
                }
                if(substr($t, 0, strlen('content-length')) == "content-length"){
                    $_size = substr($t, strlen('content-length: '));
                }
            }
            $ob = array('name' => $i['id'], 'size' => $_size, 'type' => $_type, 'url' => $i['path'], 'id' => $i['id']);
            array_push($_images, $ob);
        }
        $item_sob = 0;
        $_want_key = '';
        foreach($categories as $cate)
        {
            log_message('debug','cate_id:'.$cate['id'] . " sob_id:" . $cate['sob_id']);
            if($cate['id'] == $item['category'])
            {
                $_want_key = $cate['category_name'];
                $item_sob = $cate['sob_id'];
                log_message('debug','cate---:' . $cate['sob_id']);
            }
        }
        log_message('debug', 'item:' . $item['category']);
        log_message('debug' , 'sob:' . $item_sob);
        $group = $this->groups->get_my_list();
        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $item['dt'] = date('Y-m-d H:i:s',$item['dt']);
        $is_burden = true;
        if(!$afford)
        {
           $is_burden = false; 
        }
        $this->bsload('items/edit',
            array(
                'title' => '修改消费'
                ,'categories' => $categories
                ,'images' => json_encode($_images)
                ,'item' => $item
                ,'from_report' => $from_report
                ,'tags' => $tags
                ,'item_config'=>$item_config
                ,'images_ids' => implode(",", $_image_ids)
                ,'sob_id' => $item_sob
                ,'category_name' => $_want_key
                ,'item_value' => $item_value
                ,'member' => $gmember
				,'afford' => $afford
				,'fee_afford_ids' => implode(',',$fee_afford_ids)
				,'fee_afford_type' => $afford_type
				,'is_burden' => $is_burden
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                    ,array('url'  => '', 'name' => '修改消费', 'class' => '')
                ),
            ));
    }

    public function update(){
        $item_update_in = $this->session->userdata('item_update_in');
        $_uids = $this->input->post('uids');
        $uids = '';
        if($_uids)
        {
            $uids = implode(',',$_uids);
        }

		$afford_ids = $this->input->post('afford_ids');
        $id = $this->input->post('id');
        $rid = $this->input->post('rid');
        $from_report = $this->input->post("from_report");
        $_uid = $this->input->post('uid');
        $amount = $this->input->post('amount');
        $category= $this->input->post('category');
        $_hidden_category = $this->input->post('hidden_category');
        if(0 < $_hidden_category) {
            $category = $_hidden_category;
        }
        $subs = $this->input->post('peoples');
        log_message('debug', "##TM SRC:" . $this->input->post('dt1'));
        $time = $this->input->post('dt1');
        $timestamp = strtotime($this->input->post('dt1'));
        $temestamp = $timestamp*1000;
        $endtime = strtotime($this->input->post('dt_end1'));
        $config_id = $this->input->post('config_id');
        $config_type = $this->input->post('config_type');
        log_message('debug','config_id:' . $config_id);
        log_message('debug','config_type:' . $config_type);
        log_message('debug','dtend :' . $endtime);
        log_message('debug','dtend :' . $this->input->post('dt_end'));
        log_message('debug','dtend :' . $this->input->post('dt_end1'));
        $extra = array();
        $_extra = array();
        $profile = $this->session->userdata('profile');
        if($config_type == 2)
        {
            $_extra = array('id'=>$config_id ,'type'=>$config_type,'value'=>$endtime);
        }

        if($config_type == 5)
        {
            $_extra = array('id'=>$config_id ,'type'=>$config_type,'value'=>$subs/*$profile['subs']*/);
        }
        //array_push($extra,$_extra);
        array_push($extra,$_extra);
        $_hidden_extra = $this->input->post('hidden_extra');
        if($_hidden_extra) {
            $_hidden_extra = json_decode($_hidden_extra);
            array_push($_hidden_extra, $_extra);
            $extra = $_hidden_extra;
        }
        $__extra = json_encode($extra);
        log_message('debug','extra:' . $__extra);
        $item_update_in = 0;
        if($profile['id'] != $_uid){
            $item_update_in = 1;
        }
        log_message("debug", "##UID  $_uid :" . $profile['id']);

        $merchant = $this->input->post('merchant');
        $tags = $this->input->post('tags');
        $type = $this->input->post('type');
        $note = $this->input->post('note');
        $images = $this->input->post('images');
        log_message("debug", "alvayang: Item Update In:" . $item_update_in);
        $_item_data = $this->items->get_by_id($id);
        log_message('debug', 'item_get_by_id:' . json_encode($_item_data));
        if($item_update_in != 0) {
            $item_data = $this->items->get_by_id($id);
            $data = $item_data['data'];
            if($amount == $data['amount'])
            {
                $amount=-1;
            }
            if($category == $data['category'])
            {
                $category = -1;
            }
            if($tags == $data['tags'])
            {
                $tags = -1;
            }
            log_message("debug",'time:'.strtotime($time));
            log_message("debug","gettime:".$data['dt']);

            if(strtotime($time) == $data['dt'] || $time == '')
            {
                $timestamp = -1;
            }
            if($merchant == $data['merchants'])
            {
                $merchant = -1;
            }
            if($note == $data['note'])
            {
                $note = -1;
            }
            $obj = $this->items->update_item($id, $amount, $category, $tags, $timestamp, $merchant, $type, $note, $images,$__extra);
            log_message('debug','xx item_data:'.json_encode($obj));
            if(!$obj['status']) {
                $this->session->set_userdata('last_error', $obj['data']['msg']);
            }

        }
        else
        {
			$obj = $this->items->update($id, $amount, $category, $tags, $timestamp, $merchant, $type, $note, $images,$__extra,$uids,$afford_ids);
            log_message('debug','zz item_data:'.json_encode($obj));
        }
        log_message('debug','rid:' . $rid);
        if(!$id) {
            return redirect(base_url('items/index'));
        } else {
            log_message("debug", "from report flag => " . $from_report);
            if ($from_report)
                return redirect(base_url("items/show/" . $id . "/1"));
                                
            return redirect(base_url('items/show/'. $id));
        }
    }

}

