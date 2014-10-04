<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
        $this->load->helper('cookie');
        $this->cookie_register_name = 'register_cookie';
        // 设置cookie有效期为30天
        $this->cookie_life = 86400 * 30;
    } 


    public function index($code = 0){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->input->set_cookie($this->cookie_register_name, $code, $this->cookie_life);
        $body = $this->load->view('user/register', array('errors' => $error), True);
        $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '登录'));
    }

    public function doregister(){
        $name = $this->input->post('u');
        $pass = $this->input->post('p');
        $code = $this->input->cookie($this->cookie_register_name);
        $this->load->helper('email');
        $email = '';
        $phone = '';
        if(valid_email($name)){
            $email = $name;
        } else {
            $phone = $name;
        }
        $ret = $this->users->register($email, $pass, $phone, $code);
        if($ret['status']) die("Register Success");
        else die("Register Failed");
    }

}
