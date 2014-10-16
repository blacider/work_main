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
        $obj = $this->users->joingroup($code);
        if($obj['status']) {
            echo "Success";
            // TODO: 引导进入成功页面
        } else {
            echo "Failed";
            // TODO：进入错误页面
        }
    }

}
