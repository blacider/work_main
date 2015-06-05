<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
        $this->load->helper('cookie');
        $this->cookie_register_name = 'register_cookie';
        $this->cookie_user = 'name';
        // 设置cookie有效期为30天
        $this->cookie_life = 86400 * 30;
        $this->load->library('user_agent');
    } 


    public function index($code = 0, $name = ''){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->input->set_cookie($this->cookie_register_name, $code, $this->cookie_life);
        $name = urldecode($name);
        $args = array('name' => '');
        if($name){
            $args = json_decode($name, True);
        }
        $this->input->set_cookie($this->cookie_user, $args['name'], $this->cookie_life);
        $this->load->view('user/register', array('name' => $args['name']));
        /*
        if($this->agent->is_mobile()) {
            $this->load->view('user/mobile_register', array('nav' => '', 'body' => $body, 'title' => '注册'));
        } else {
            $body = $this->load->view('user/register', array('name' => $args['name'], 'errors' => $error), True);
            $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '登录'));
        }
         */
    }

    public function doregister(){
        $name = $this->input->post('u');
        $pass = $this->input->post('password');
        $_name = $this->input->cookie($this->cookie_user);
        log_message("debug", "Name: " . $name);
        log_message("debug", "_Name: " . $_name);
        if($name == "" && $_name == ""){
            $this->session->set_userdata('last_error', '用户名不能为空');
            return redirect(base_url('register/index'));
        }
        $name = $name ? $name : $_name;
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
        $ret = json_decode($ret, True);
        if($ret['status']) {
        $this->load->view('user/active_succ', array('name' => array(),'code'=>$code, 'msg' => '恭喜，你的账号已经注册成功，请点击<a href="https://admin.cloudbaoxiao.com">这里</a>登录。'));
        } else {
            $this->load->view('user/active_fail', array('name' => array(),'code'=>$code, 'msg' => '抱歉帐号注册失败，请稍后尝试。'));
            //$this->load->view('user/active_fail', array('name' => array(),'code'=>$code, 'msg' => '抱歉帐号注册失败，请稍后尝试。'));
        }
    }

    public function success($code = 0, $name = ''){
        $this->load->view('user/active_succ', array('name' => array(),'code'=>$code, 'msg' => '恭喜，你的账号已经注册成功，请点击<a href="https://admin.cloudbaoxiao.com">这里</a>登录。'));

        /*
        $name = urldecode($name);
        $args = array('name' => '');
        if($name){
            $args = json_decode($name, True);
        }
        $this->input->set_cookie($this->cookie_user, $args['name'], $this->cookie_life);

        $body = $this->load->view('user/register_success', array('name' => $args['name']), True);
        $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '登录'));
         */
    }



}
