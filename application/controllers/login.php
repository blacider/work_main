<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
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
        $user = $this->users->get_user($username, $password);
        if(!$user['status']) {
            $this->session->set_userdata('login_error', $user['data']['msg']);
            redirect(base_url('login'));
            die();
        }
        redirect(base_url('items'));
    }

    public function dologout()
    {
        $this->session->unset_userdata('userid');
        redirect(base_url());
    }

}
