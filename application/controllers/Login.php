<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
        $this->load->model('Register_model');
        $this->load->helper('cookie');
        $this->load->library('reim_cipher');
    }

    public function reset_password($addr = 'email'){
        if($addr == 'email'){
            $user_addr = $this->input->post('email');
        } else if($addr == 'phone') {
            $user_addr = $this->input->post('phone');
        } else {
            echo json_encode(array('status' => 1, 'msg' => '访问地址错误'));
        }

        $password = $this->input->post('password');
        $vcode = $this->input->post('vcode');
        
        /*
        $vcode_verify_back = $this->Register_model->vcode_verify($addr,$user_addr,$vcode);
        if($vcode_verify_back['data']['validate'] == 0)
        {
            echo json_encode(array('status' => 1, 'msg' => '验证码错误'));
            return ;
        }
*/

        $data[$addr] = $user_addr;
        $data['vcode'] = $vcode;
        $data['password'] = $password;
        $reset_password_back = $this->users->reset_password($data);

        $reset_password_back['status'] = 1;
        echo json_encode($reset_password_back);
        return ;
    }

    public function check_user($addr = 'email'){
        if($addr == 'email'){
            $user_addr = $this->input->post('email');
        }
        else if($addr == 'phone'){
            $user_addr = $this->input->post('phone');
        } else if($addr == 'weixin'){
            $openid = $this->input->post('openid');
            $access_token = $this->input->post('access_token');
            $user_addr = array(
                'openid' => $openid,
                'access_token' => $access_token
            );
        } else {
            echo json_encode(array('status' => 1, 'msg' => '访问地址错误'));
            return ;
        }

        $check_user_back = $this->users->check_user($addr,$user_addr);
        $check_user_back['status'] = 1;
        echo json_encode($check_user_back);
        return ;
    }

    public function join_company()
    {
        $company = $this->input->post('invites');
        $buf = $this->users->join_company($company);

        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','加入成功');
            return redirect(base_url());
        }
        else
        {

            $this->session->set_userdata('last_error','加入成功');
            return redirect(base_url());
        }
    }

    public function index()
    {
        $this->load->library('user_agent');
        //$this->load->helper('user_agent', 'agent');
        $refer = $this->agent->referrer();
        log_message('debug', 'alvayang refer:' . $refer);
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $data =array();
        $username = $this->reim_cipher->decode($this->input->cookie('username'));
        $password = $this->reim_cipher->decode($this->input->cookie('password'));
        log_message("debug", "UserName:" . $username);
        log_message("debug", "Password:" . $password);

        $attacker = $this->agent->agent_string();
        // $attacker = "test start; ;JianKongBao Monitor test end";
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        $body = $this->load->view('user/login.php', 
            array(
                'errors' => $error,
                'title' => '登录',
                'username' => $username,
                'password' => $password,
                'has_attacker' => $hasAttacker
            )
        );
    }

    public function cslogin()
    {
        $this->load->library('user_agent');
        $body = $this->load->view('user/cslogin.php', array());
    }


    public function force_reset(){
        $user = $this->input->get('phone');
        $username = $this->reim_cipher->decode($this->input->cookie('username'));
        $this->load->view('user/forcelogin', array(
            'errors' => '您的口令存在风险，请修改密码'
            ,'name' => $username
            , 'title' => '重置密码'
        ));
    }

    public function do_login(){
        $username = trim($this->input->post('u', TRUE));
        $password = $this->input->post('p', TRUE);
        $is_r = $this->input->post('is_r',TRUE);
        log_message("debug","is_r:".$is_r);
        // 设置自动存储1个月
        $expire = 3600 * 24 * 30;

        if($is_r == 'on')
        {
            $_username = $this->reim_cipher->encode($username);
            $_password = $this->reim_cipher->encode($password);
            log_message('debug','_username:'.$_username);
            log_message('debug','_password:'.$_password);
            $cookie = array(
                'name'   => 'username',
                'value'  => $_username,
                'expire' => $expire,
                'domain' => '.cloudbaoxiao.com',
                'path'   => '/',
                'prefix' => '',
                'secure' => TRUE
            );
            $this->input->set_cookie($cookie);
            $cookie['name'] = 'password';
            $cookie['value'] = $_password;
            $this->input->set_cookie($cookie);
        }
        else
        {
            $this->input->set_cookie("username",$username);
            delete_cookie('password','.cloudbaoxiao.com','/','');
        }
        if(!$username){
            echo json_encode(array('status' => 1, 'msg' => '请输入用户名'));
            return ;
        }
        if(!$password){
            echo json_encode(array('status' => 1, 'msg' => '请输入密码'));
            return ;
        }
        $user = $this->users->reim_get_user($username, $password);
        $this->session->set_userdata('email', $username);
        $this->session->set_userdata('password', $password);
        log_message('debug', "Login:" . json_encode($user));
        if(!$user['status']) {
            //if($user['code'] == -75) {
            //    return redirect(base_url('login/force_reset'));
            //}
            echo json_encode(array('status' => 1, 'msg' => '用户名或者密码错误'));
            return ;
        }
        $server_token = $user['server_token'];
        $data = $user['data']['profile'];

        log_message('debug', "profile:" . json_encode($data));
        $__g = '';
        if(array_key_exists('group_name', $data)){
            $__g = $data['group_name'];
        }
        $__uid = '';
        if(array_key_exists('id', $data)){
            $__uid = $data['id'];
        }
        $this->session->set_userdata("uid", $__uid);
        $this->session->set_userdata("groupname", $__g);
        $this->session->set_userdata("server_token", $server_token);
        $goto = $this->session->userdata('last_url');
        // 获取一下组信息，然后设置一下
        echo json_encode(array('status' => 1, 'data' => base_url('items')));
        return ;
    }
    public function dologin(){
        $username = trim($this->input->post('u', TRUE));
        $password = $this->input->post('p', TRUE);
        $is_r = $this->input->post('is_r',TRUE);
        log_message("debug","is_r:".$is_r);
        // 设置自动存储1个月
        $expire = 3600 * 24 * 30;

        if($is_r == 'on')
        {
            $_username = $this->reim_cipher->encode($username);
            $_password = $this->reim_cipher->encode($password);
            log_message('debug','_username:'.$_username);
            log_message('debug','_password:'.$_password);
            $cookie = array(
                'name'   => 'username',
                'value'  => $_username,
                'expire' => $expire,
                'domain' => '.cloudbaoxiao.com',
                'path'   => '/',
                'prefix' => '',
                'secure' => TRUE
            );
            $this->input->set_cookie($cookie);
            $cookie['name'] = 'password';
            $cookie['value'] = $_password;
            $this->input->set_cookie($cookie);
        }
        else
        {
            $this->input->set_cookie("username",$username);
            delete_cookie('password','.cloudbaoxiao.com','/','');
        }
        if(!$username){
            $this->session->set_userdata('login_error', '请输入邮箱或者手机');
            return redirect(base_url('login'));
        }
        if(!$password){
            $this->session->set_userdata('login_error', '请输入密码');
            return redirect(base_url('login'));
        }
        $user = $this->users->reim_get_user($username, $password);
        $this->session->set_userdata('email', $username);
        $this->session->set_userdata('password', $password);
        log_message('debug', "Login:" . json_encode($user));
        if(!$user['status']) {
            //if($user['code'] == -75) {
            //    return redirect(base_url('login/force_reset'));
            //}
            $this->session->set_userdata('login_error', '用户名或者密码错误');
            redirect(base_url('login'));
            die();
        }
        $server_token = $user['server_token'];
        $data = $user['data']['profile'];

        log_message('debug', "profile:" . json_encode($data));
        $__g = '';
        if(array_key_exists('group_name', $data)){
            $__g = $data['group_name'];
        }
        $__uid = '';
        if(array_key_exists('id', $data)){
            $__uid = $data['id'];
        }
        $this->session->set_userdata("uid", $__uid);
        $this->session->set_userdata("groupname", $__g);
        $this->session->set_userdata("server_token", $server_token);
        /*
        $goto = $this->session->userdata('last_url');
        // 获取一下组信息，然后设置一下
        if($this->startsWith($goto, 'members/singlegroup')){
            $goto = 'items';
        }
        if(!$goto) {
            redirect(base_url('items'));
            die('');
        }
        redirect(base_url($goto));
        */
        redirect(base_url('items'));
    }

    public function dologout()
    {
        $this->users->logout();
        redirect(base_url());
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
        }
    }


}
