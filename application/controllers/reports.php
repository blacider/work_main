<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
    }

    public function index(){
        $items = $this->items->get_list();
        if(!$items) redirect(base_url('login'));
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['reports'];
            $this->eload('reports/index',
                array(
                    'title' => '报销管理'
                    ,'items' => $item_data
                ));
        }
    }
}

