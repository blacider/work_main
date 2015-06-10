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

    public function index2()
    {
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $body = $this->load->view('user/login2', array('errors' => $error, 'title' => '登录'));
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

    public function wxlogin(){
        // 
        $_code = $this->input->get('code');
        $appid = 'wxa718c52caef08633';
        $appsec = '02c3df9637d1210a84447524f3606dc1';
        $auth_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsec&code=$_code&grant_type=authorization_code";
        $buf = $this->do_Get($auth_url);
        $obj = json_decode($buf, True);
        if(array_key_exists('errcode', $obj)) {
            //TODO: 
        } else {
            $openid  = $obj['openid'];
            $token = $obj['access_token'];
            $unionid = $obj['unionid'];
            $user = $this->users->reim_oauth($unionid, $openid, $token);
            if(!$user['status']) {
                $this->session->set_userdata('login_error', '用户名或者密码错误');
                redirect(base_url('login'));
                die();
            }
            $data = $user['data']['profile'];
            $__g = '';
            if(array_key_exists('group_name', $data)){
                $__g = $data['group_name'];
            }
            $this->session->set_userdata("email", $unionid);
            $this->session->set_userdata("server_token", $user['server_token']);
            $this->session->set_userdata("groupname", $__g);
            // 获取一下组信息，然后设置一下
            redirect(base_url('items'));

            /*
        {
            access_token: "OezXcEiiBSKSxW0eoylIeE-sVMTrnjgr4HIMn_AwB1y5A2UVTp_O_NcCS5iN4nvFjJUphBgZlnp1dJPg-WuyGX7s5LnFPVP78lypuqTC3Zn9y0SwiIjH7tKL3kvbN7b9U6zMB_4Cw07PtMaB6hakAQ",
                expires_in: 7200,
                refresh_token: "OezXcEiiBSKSxW0eoylIeE-sVMTrnjgr4HIMn_AwB1y5A2UVTp_O_NcCS5iN4nvFsZkvMXThshUm1rnmouUsUeiUU_5p5LaNpO4dh8wRQJIPegwxghSNePnKdo7YxwF_FOS8UPrBh434OipAiaNbCw",
                openid: "oqu3At1tE-Yz-qbjvvTbk6tr9oXE",
                scope: "snsapi_login",
                unionid: "oEdh1uAvUA3Fjc-Ua-YOjLEIH79k"
        }
             */
        }
    }

}
