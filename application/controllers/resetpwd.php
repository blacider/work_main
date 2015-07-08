<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resetpwd extends REIM_Controller  {
    public function __construct(){   
        parent::__construct(); 
        $this->load->model('user_model');  
        $this->load->model('user_model', 'users');
        $this->load->helper('cookie');
        $this->cookie_register_name = 'register_cookie';
        $this->cookie_user = 'name';
        // 设置cookie有效期为30天
        $this->cookie_life = 86400 * 30;
        $this->load->library('user_agent');
    }

    public function index($code = '', $name = '') {
        /*
        if(!$code || !$cid) redirect(base_url('login'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->load->view('resetpwd', array('code' => $code, 'cid' => $cid, 'error' => $error));
         */
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->input->set_cookie($this->cookie_register_name, $code, $this->cookie_life);
        $name = urldecode($name);
        $args = array('name' => '');
        if($name){
            $args = json_decode($name, True);
        }
        $this->input->set_cookie($this->cookie_user, $args['name'], $this->cookie_life);
        $this->load->view('resetpwd', array('name' => $args['name'], 'code' => $code, 'cid' => $name, 'error' => $error));
        //$this->load->view('user/register', array('name' => $args['name']));
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
