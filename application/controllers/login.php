<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('users/user_model', 'users');
    }

    public function index()
    {
        log_message("debug", "IN Login");
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $body = $this->load->view('user/login', array('errors' => $error), True);
        $this->load->view('default', array('nav' => '', 'body' => $body, 'title' => '登录'));
    }

    public function dologin(){
        $username = $this->input->post('u', TRUE);
        $password = $this->input->post('p', TRUE);
        $user = $this->users->get_user($username);
        if(!$user) {
            $this->session->set_userdata('login_error', '用户不存在');
            redirect(base_url('login'));
            die();
        }

        if($user['passwd'] != md5($password)){
            $this->session->set_userdata('login_error', '密码错误');
            redirect(base_url('login'));
            die();
        }
        redirect(base_url('admin/index'));
    }

    public function dologout()
    {
        $this->session->unset_userdata('userid');
        redirect(base_url());
    }

}
