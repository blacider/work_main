<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('report_model', 'reports');
    }

    public function index($type = 1){
        //$items = $this->items->get_list();
        $items = $this->items->get_suborinate($type);
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
        $this->eload('reports/index',
            array(
                'title' => '报销管理'
                ,'items' => $item_data
                ,'type' => $type
            ));
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

}

