<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resetpwd extends REIM_Controller  {
    public function __construct(){   
        parent::__construct(); 
        $this->load->model('user_model');  
    }

    public function index($code = '', $cid = '') {
        if(!$code || !$cid) redirect(base_url('login'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->load->view('resetpwd', array('code' => $code, 'cid' => $cid, 'error' => $error));
    }

    public function doupdate(){
        $pass = $this->input->post('pass');
        $repass = $this->input->post('passc');
        $code = $this->input->post('code');
        $cid = $this->input->post('cid');
        if(!$code || !$cid)  redirect(base_url('login'));
        if($pass != $repass) {
            $this->session->set_userdata('last_error', "密码不匹配");
            redirect(base_url('resetpwd/index/' . $code . "/" . $cid));
        }
        $category = $this->user_model->reset_pwd($pass,$code);
        //$category = $this->user_model->reim_update_password($code, $pass, $cid);
        $obj = json_decode($category, True);
        log_message("debug", $category);
        if($obj['status'] > 0){
            $this->session->set_userdata('last_error', "修改成功");
            redirect(base_url('login'));
        } else {
            $this->session->set_userdata('last_error', "修改失败");
            redirect(base_url('resetpwd/index/' . $code . "/" . $cid));
        }
    }

}
