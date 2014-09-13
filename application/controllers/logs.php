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
        $info = $this->logs->list_logs();
        $total_user = $info['total'];
        $data = $info['data'];
        $this->eload('opt/logs', array('title' => '日志管理', 'alist' => $data));
    }
}
