<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
    }


    public function images(){
        if(!empty($_FILES)) {
            log_message("debug", json_encode($_FILES));
            $uploaddir = '/data/uploads/';
            $uploadfile = $uploaddir . md5(time()) . "_" . basename($_FILES['file']['name']);
            if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $img = $this->items->upload_image($uploadfile, $_FILES['file']['type']);
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
                'title' => '新建报销',
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
                    'title' => '消费列表',
                    'category' => $categories,
                    'tags' => $tags,
                    'items' => $item_data
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
        $obj = $this->items->create($amount, $category, $tags, $timestamp, $merchant, $type, $note, $images);
        // TODO: 提醒的Tips
        if($obj['status'] > 0){
            redirect(base_url('items/index'));
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
                log_message("debug", "Item:" . json_encode($s));
                if($s['istatus'] < 0) continue;
                $s['cate_str'] = '未指定的分类';
                $s['createdt'] = strftime("%Y-%m-%d %H:%M", intval($s['createdt']));
                $_type = '报销';
                switch($s['type']){
                case 1: {$_type = '预算';};break;
                case 2: {$_type = '借款';};break;
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
                $s['amount'] = '￥' . $s['amount'];
                $s['status_str'] = '';
                $trash= $s['istatus'] === 0 ? 'gray' : 'red';
                $edit = $s['istatus'] === 0 ? 'gray' : 'green';
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon ace-icon fa fa-search-plus tdetail" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ' . $edit . ' ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ui-icon-trash ' . $trash . '  tdel" data-id="' . $s['id'] . '"></span></div>';
                switch($s['istatus']){
                case 0: {
                    $s['status_str'] = '<button class="btn  btn-minier btn-yellow disabled">待提交</button>';
                };break;
                case 1: {
                    $s['status_str'] = '审核中';
                };break;
                case 2: {
                    $s['status_str'] = '已通过';
                };break;
                case 3: {
                    $s['status_str'] = '已退回';
                };break;
                case 4: {
                    $s['status_str'] = '已完成';
                };break;
                case 5: {
                    $s['status_str'] = '已完成';
                };break;
                case 6: {
                    $s['status_str'] = '待支付';
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
        case 1:{$_type = '预算';};break;
        case 2:{$_type = '借款';};break;
        }
        $item['prove_ahead'] = $_type;
        $this->bsload('items/view',
            array(
                'title' => '查看报销',
                'categories' => $categories,
                'tags' => $tags,
                'item' => $item
            ));
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
                'title' => '修改报销',
                'categories' => $categories,
                'tags' => $tags,
                'images' => json_encode($_images),
                'item' => $item,
                'images_ids' => implode(",", $_image_ids)
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

