<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');

    }
    public function alogin()
    {
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $body = $this->load->view('user/login.old.php', array('errors' => $error, 'title' => '登录'));
    }


    public function index()
    {
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $body = $this->load->view('user/login', array('errors' => $error, 'title' => '登录'));
    }

    public function dologin(){
        $username = $this->input->post('u', TRUE);
        $password = $this->input->post('p', TRUE);
        if(!$username){
            $this->session->set_userdata('login_error', '请输入邮箱或者手机');
            return redirect(base_url('login'));
        }
        if(!$password){
            $this->session->set_userdata('login_error', '请输入密码');
            return redirect(base_url('login'));
        }
        $user = $this->users->get_user($username, $password);
        if($user){
            $this->session->set_userdata('user', $user);
            $this->session->set_userdata('uid', $user->id);
            redirect(base_url() . 'admin/index', 'refresh');
        } else {
            $user = $this->users->reim_get_user($username, $password);
            $this->session->set_userdata('email', $username);
            $this->session->set_userdata('password', $password);
            if(!$user['status']) {
                $this->session->set_userdata('login_error', '用户名或者密码错误');
                redirect(base_url('login'));
                die();
            }
            $server_token = $user['server_token'];
            $data = $user['data']['profile'];
            $__g = '';
            if(array_key_exists('group_name', $data)){
                $__g = $data['group_name'];
            }
            log_message("debug", "Login: server token:" . $server_token);
            $this->session->set_userdata("groupname", $__g);
            $this->session->set_userdata("server_token", $server_token);
            // 获取一下组信息，然后设置一下
            redirect(base_url('items'));
        }
    }

    public function dologout()
    {
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('profile');
        $this->session->unset_userdata('user');
        redirect(base_url());
    }

    private function _check_user($username, $password){
        $errors = '';
        $success= '登录成功...';

        echo "in check";
        if(empty($username)){
            $errors = '请输入用户名.';
            return array(false, $errors);
        }
        if(empty($password)){
            return array(false, $errors);
        }

        if(!$errors){
        echo "in get user";
            $data = $this->users->get_user($username, $password);

            if(count($data) > 0){
                $this->session->set_userdata('user', $data);
                $this->session->set_userdata('uid', $data['id']);
                $this->session->set_userdata('username', $data['username']);
                return array(TRUE, $success);
            }
            else{
                $errors = '用户名不存在.';
            }
        }

        return array(FALSE, $errors);

    }

}
