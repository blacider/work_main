<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Register extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
        $this->load->model('Register_model');
        $this->load->helper('cookie');
        $this->cookie_register_name = 'register_cookie';
        $this->cookie_user = 'name';
        // 设置cookie有效期为30天
        $this->cookie_life = 86400 * 30;
        $this->load->library('user_agent');
    } 

    public function vcode_verify($addr = 'email'){
        if ($addr == 'email') {
            $user_addr = $this->input->post('email');
        } else if($addr == 'phone'){
            $user_addr = $this->input->post('phone');
        }else {
            echo json_encode(array('status' => 1,'msg' => '访问地址错误'));
            return;
        }
        $vcode = $this->input->post('vcode');

        $vcode_verify_back = $this->Register_model->vcode_verify($addr, $user_addr, $vcode);         
        $vcode_verify_back['status'] = 1;
        echo json_encode($vcode_verify_back); 
        return ;
    }

    public function ok()
    {
        $attacker = $this->agent->agent_string();
        // $attacker = "test start; ;JianKongBao Monitor test end";
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }

        $this->load->view('user/reg_successful', array('has_attacker'=>$hasAttacker));
    }

    public function getvcode($addr = 'email',$scene = 'register'){
        if($addr == 'email')
            $user_addr = $this->input->post('email');
        else if($addr == 'phone')
            $user_addr = $this->input->post('phone');
        else
        {
            echo json_encode(array('status' => 1,'msg' => '访问地址错误'));
            return;
        }

        if(!$user_addr)
        {
            echo json_encode(array('status' => 1,'msg' => '输入手机号或者email'));
            return ;
        }
        if($addr != 'email' && $addr != 'phone')
        {
            $check_user_back = $this->users->check_user($addr,$user_addr);
            if($check_user_back['data']['exists'] == 1)
            {
                echo json_encode(array('status' => 1,'msg' => '账号已被注册'));
                return ;
            }
        }
        $vcode_back = $this->Register_model->getvcode($addr,$user_addr,$scene);
        $vcode_back['status'] = 1;
        echo json_encode($vcode_back);
        return;
    }

    public function company_register(){
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        $vcode = $this->input->post('vcode');
        $company_name = $this->input->post('company_name');
        $name = $this->input->post('name');
        $position = $this->input->post('position');
        $platform = $this->input->post('platform');
        $reg_from = $this->input->post('reg_from');

        $data = array();
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['vcode'] = $vcode;
        $data['company_name'] = $company_name;
        $data['password'] = $password;
        $data['name'] = $name;
        $data['position'] = $position;
        $data['platform'] = $platform;
        $data['reg_from'] = $reg_from;

        $check_company_back = $this->users->check_company($company_name);
        if($check_company_back['data']['exists'] == 1)
        {
            echo json_encode(array('status' => 1,'code' => -1,'msg' => '公司名已被注册'));
            return ;
        }
        $register_back = $this->Register_model->register($data);
        $register_back['status'] = 1;
        echo json_encode($register_back);
        return ;
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
