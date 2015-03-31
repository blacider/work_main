<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Join extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
    }

    public function index($code = ''){
        if($code == "") {
            // TODO: 展示出错页面
            return;
        } 
        $obj = $this->users->reim_joingroup($code);
        if($obj['status']) {
            // TODO: 引导进入成功页面
            $this->active_succ($code);
        } else {
            // TODO：进入错误页面
            $this->active_fail();
        }
    }


    private function active_succ($code = 0, $name = ''){
        $body = $this->load->view('user/active_succ', array('name' => $name,'code'=>$code), True);
        $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '激活成功'));
    }

    private function active_fail(){
        $body = $this->load->view('user/active_fail', array(), True);
        $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '激活失败'));
    }


    public function active($code = ''){
        if($code == "") {
            // TODO: 展示出错页面
            return;
        } 
        $obj = $this->users->reim_active_user($code);
        // TODO: 检查是否需要使用统一 的成功页面
        if($obj['status']) {
            // TODO: 引导进入成功页面
            $this->active_succ($code);
        } else {
            // TODO：进入错误页面
            $this->active_fail();
        }
    }
}

