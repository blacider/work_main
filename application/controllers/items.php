<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('category_model', 'category');
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
            $this->eload('items/index',
                array(
                    'title' => '报销管理',
                    'category' => $categories,
                    'tags' => $tags,
                    'items' => $item_data
                ));
        }
    }

    public function create(){
        print_r($_POST);
        print_r($_FILES);

    }
}

