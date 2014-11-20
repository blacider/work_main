<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('report_model', 'reports');
    }

    public function index(){
        $items = $this->items->get_list();
        if(!$items) redirect(base_url('login'));
        $item_data = array();
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['reports'];
        }
        $this->eload('reports/index',
            array(
                'title' => '报销管理'
                ,'items' => $item_data
            ));
    }

    public function create(){
        $items = $this->items->get_list();
        if(!$items) redirect(base_url('login'));
        $item_data = array();
        if($items && $items['status']) {
            $data = $items['data'];
            $item_data = $data['reports'];
        }
        $this->eload('reports/create',
            array(
                'title' => '创建报表'
            ));
    }

    public function del($id = 0){
        if($id == 0) {
            return redirect(base_url('reports/index'));
        }
        $obj = $this->reports->delete_report($id);
        return redirect(base_url('reports/index'));
    }
}

