<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        if ($this->session->userdata('oauth2_ak')) {
            return redirect(base_url('items'));
        }
        $this->load->library('user_agent');
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');
        $data =array();
        $user_agent = $this->agent->agent_string();

        // ie check
        $browser_not_supported = false;
        $lte_ie8 = false;
        $hasAttacker = false;
        if(stripos($user_agent, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        if ($this->agent->is_mobile('iphone') || $this->agent->is_mobile('android')) {
            $body = $this->load->view('user/login_mobile.php', array(
                'errors' => $error,
                'title' => '登录',
                'has_attacker' => $hasAttacker,
                'browser_not_supported' => $browser_not_supported
            ));
        } else {
            // ie check
            if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() < 8) {
                $browser_not_supported = true;
            }
            if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() <=8) {
                $lte_ie8 = true;
            }

            $body = $this->load->view('user/login.php', array(
                'errors' => $error,
                'title' => '登录',
                'has_attacker' => $hasAttacker,
                'browser_not_supported' => $browser_not_supported,
                'lte_ie8' => $lte_ie8,
            ));
        }
    }

    public function cslogin()
    {
        $this->load->library('user_agent');
        $body = $this->load->view('user/cslogin.php', array());
    }

    public function do_login(){
        $username = trim($this->input->post('u'));
        $password = $this->input->post('p');
        if(!$username or !$password){
            echo json_encode(array('status' => 1, 'msg' => '需要用户名密码'));
            return;
        }
        $ret = $this->user_model->oauth2_auth_pwd($username, $password);
        if ($ret !== true) {
            echo json_encode(['status' => -1, 'msg' => $ret]);
            return;
        }
        log_message('info', 'login ok');
        $this->user_model->refresh_session();
        echo json_encode(['status' => 1, 'url' => base_url('items')]);
    }

    public function dologout()
    {
        $this->user_model->logout();
        redirect(base_url());
    }

    public function wxlogin(){
        $code = $this->input->get('code');
        $ret = $this->user_model->exchange_weixin_token($code);
        if(array_key_exists('errcode', $ret)) {
            $this->session->set_userdata('login_error', '微信返回错误');  # FIXME
            redirect(base_url('/#login'));
        }
        $ret = $this->user_model->oauth2_auth_weixin($ret['openid'], $ret['access_token']);
        if ($ret !== true) {
            $this->session->set_userdata('login_error', $ret);
            redirect(base_url('#login'));
        }
        log_message('info', 'login by weixin ok');
        $this->user_model->refresh_session();
        redirect(base_url('items'));
    }

    public function reset_password($addr = 'email'){
        if($addr == 'email'){
            $user_addr = $this->input->post('email');
        } else if($addr == 'phone') {
            $user_addr = $this->input->post('phone');
        } else {
            echo json_encode(array('status' => 1, 'msg' => '访问地址错误'));
            return;
        }

        $password = $this->input->post('password');
        $vcode = $this->input->post('vcode');

        $data[$addr] = $user_addr;
        $data['vcode'] = $vcode;
        $data['password'] = $password;
        $reset_password_back = $this->user_model->reset_password($data);

        $reset_password_back['status'] = 1;
        echo json_encode($reset_password_back);
        return;
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

        $check_user_back = $this->user_model->check_user($addr, $user_addr);
        $check_user_back['status'] = 1;
        echo json_encode($check_user_back);
        return ;
    }


}
