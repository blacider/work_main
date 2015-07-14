<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
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
            $type = $this->input->post('type');
            if(!$type) $type = 1;
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

    public function newitem(){
        $category = $this->category->get_list();
        $categories = array();
        $tags = array();
        if($category && array_key_exists('data', $category) && array_key_exists('categories', $category['data'])){
            $categories = $category['data']['categories'];
            $tags = $category['data']['tags'];
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
                'tags' => $tags
            ));
    }
    public function index(){
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
        $amount = $this->input->post('amount');
        $category= $this->input->post('category');
        $timestamp = strtotime($this->input->post('dt'));
        log_message("debug", "TM:" . $timestamp);
        //$timestamp = mktime(0, $dt['tm_min'], $dt['tm_hour'], $dt['tm_mon']+1, $dt['tm_mday'], $dt['tm_year'] + 1900);

        $merchant = $this->input->post('merchant');
        $tags = $this->input->post('tags');
        $type = $this->input->post('type');
        $note = $this->input->post('note');
        $images = $this->input->post('images');
        $renew = $item['renew'];
        $obj = $this->items->create($amount, $category, $tags, $timestamp, $merchant, $type, $note, $images);
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
            foreach($item_data as &$s){
                //if($s['status'] < 0) continue;
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
                //$s['amount'] = '￥' . $s['amount'];
                $s['amount'] = '￥' . $s['amount'];
                $s['status_str'] = '';
                log_message("debug", "Item:" . json_encode($s));
                $trash= $s['status'] === 0 ? 'gray' : 'red';
                $edit = $s['status'] === 0 ? 'gray' : 'green';
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $s['id'] . '"></span></div>';
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
                default: {
                    $s['status_str'] = $s['status'];
                }
                }
                array_push($_items, $s);
            }
            die(json_encode($_items));
        }
    }


    public function del($id = 0){
        if(0 === $id) redirect(base_url('items'));
        $obj = $this->items->remove($id);
        redirect(base_url('items'));
    }


    public function show($id = 0){
        if(0 === $id) redirect(base_url('items'));
        $obj = $this->items->get_by_id($id);
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
        $cid = $item['category'];
        $_tags = $item['tags'];
        $__tags_name = array();


        // TODO 去提升效率
        foreach(explode(',', $_tags) as $t){
            foreach($tags as $_t){
                if($_t['id'] == $t){
                    array_push($__tags_name, $_t['tag_name']);
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
        case 1:{$_type = '预借';};break;
        case 2:{$_type = '预算';};break;
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

        $this->bsload('items/view',
            array(
                'title' => '查看消费',
                'categories' => $categories,
                'tags' => $tags,
                'item' => $item,
                'flow' => $flow
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

    public function edit($id = 0){
        if(0 === $id) redirect(base_url('items'));
        $item = $this->items->get_by_id($id);
        if($item['status'] < 1){
            redirect(base_url('items'));
        }
        $item = $item['data'];
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
        $this->bsload('items/edit',
            array(
                'title' => '修改消费',
                'categories' => $categories,
                'tags' => $tags,
                'images' => json_encode($_images),
                'item' => $item,
                'images_ids' => implode(",", $_image_ids)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('items/index'), 'name' => '消费', 'class' => '')
                    ,array('url'  => '', 'name' => '修改消费', 'class' => '')
                ),
            ));
    }

    public function update(){
        $id = $this->input->post('id');
        $amount = $this->input->post('amount');
        $category= $this->input->post('category');
        $timestamp = strtotime($this->input->post('dt'));
        log_message("debug", "TM:" . $timestamp);
        //$timestamp = mktime(0, $dt['tm_min'], $dt['tm_hour'], $dt['tm_mon']+1, $dt['tm_mday'], $dt['tm_year'] + 1900);

        $merchant = $this->input->post('merchant');
        $tags = $this->input->post('tags');
        $type = $this->input->post('type');
        $note = $this->input->post('note');
        $images = $this->input->post('images');
        $obj = $this->items->update($id, $amount, $category, $tags, $timestamp, $merchant, $type, $note, $images);
        // TODO: 提醒的Tips
        if($obj['status'] > 0){
            redirect(base_url('items/index'));
        } else {
            redirect(base_url('items/index'));
        }
        

    }

}

