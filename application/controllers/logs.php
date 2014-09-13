<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends REIM_Controller  {
    public function __construct(){   
        parent::__construct(); 
        $this->load->model('op/logs_model', 'logs');  
    }


    public function async(){
        $message = $this->input->post('message');
        $level = $this->input->post('level');
        $host = $this->input->post('host');
        $type = $this->input->post('type');


        if($this->logs->create($host, $level, $type, $message)){
            die(json_encode(array('status' => true, 'message' => '成功')));
        } else {
            die(json_encode(array('status' => false, 'message' => '写入数据库失败')));
        }
    }


    public function index(){
        $pn = $this->input->get('pn');
        $rn = $this->input->get('rn');
        $order = $this->input->get('order');
        if($pn <= 0){
            $pn = 1;
        }
        if($rn <= 0){
            $rn = 10;
        }
        $pn = $pn <= 0 ?  1 : $pn;
        $info = $this->logs->list_logs($pn - 1, $rn);
        $total = $info['total'];
        $data = $info['data'];
        $url = 'logs/index?';
        $page = $this->_pager($url, $total, $pn, $rn);
        $this->eload('opt/logs', array('title' => '日志管理', 'alist' => $data, 'pager' => $page));
    }
}
