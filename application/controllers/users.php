<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('users/user_model', 'user');
        $this->load->model('users/customer_model', 'cmodel');  
    }

    public function admin(){
        $uid = $this->users->create('alvayang', 'alvayang', '杨松', '', 0);
        redirect(base_url('login'));
    }

    public function index(){
        // create menu
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $users = $this->user->get_all();
        $total_user = $users['total'];
        $users = $users['data'];
        $customers= $this->cmodel->get_all_customers();
        $total = $customers['count'];
        $customers = $customers['data'];
        $this->eload('user/index', array('title' => '用户管理', 'alist' => $users, 'customers' => $customers));
    }


    public function create_business_dir($domain) {
        $this->load->helper('message');
        $this->config->load('mq');

        //$this->config->load('mail');
        log_message("debug", "MQ Loaded");
        $conn_args = array(
            'host' => $this->config->item('mq_host'),
            'port' => $this->config->item('mq_port'),
            'login' => $this->config->item('mq_user'),
            'password' => $this->config->item('mq_password'),
            'vhost'=> $this->config->item('mq_vhost')
        );
        //TODO: 模板
        $_payload =  json_encode(array(
            'cmd' => 'newuser'
            ,'data' => array(
                # 异步创建，风险也有
                'domain' => $domain
                ,'callback' => base_url('async/callback')
            )));
        $exchange = $this->config->item('mq_exchange');
        $queue = $this->config->item('mq_queue');
        $route = $this->config->item('mq_route');
        log_message("debug", "send message to mq");
        send_message($_payload, $conn_args, $exchange, $queue, $route);
        return true;
    }

    public function create(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $role = $this->input->post('role');
        $ascription = $this->input->post('ascription');
        $user = $this->user->get_user($username);
        if($user){
            $this->session->set_userdata('last_error', '用户已存在');
            redirect(base_url('user/user', 'refresh'));
            die("");
        }
        $uid = $this->user->create($username, $password, $nickname, $ascription, $role);
        if($uid){
            // 发送任务
            $this->load->helper('message');
            $this->session->set_userdata('last_error', '创建成功');
        } else {
            $this->session->set_userdata('last_error', '创建失败');
        }
        redirect(base_url('users', 'refresh'));
    }

    public function delete($id = 0){
        $user = $this->user->get_by_id($id);
        if(!$user){
            $this->session->set_userdata('last_error', '参数错误');
            redirect(base_url('user/user', 'refresh'));
            die("");
        }
        $this->user->remove_by_id($id);
        $this->session->set_userdata('last_error', '删除成功');
        // 发送任务
        redirect(base_url('users', 'refresh'));
        die("");
    }

    public function info($id){
        $ret = array('status' => False, 'msg' => '用户不存在');
        $user = $this->user->get_by_id($id);
        if(!$user){
            die(json_encode($ret));
        }
        else {
            unset($user['passwd']);
            die(json_encode(array('status' => True, 'data' => $user)));
        }
    }

    public function update(){
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $role = $this->input->post('role');
        $ascription = $this->input->post('ascription');
        $uid = $this->input->post('uid');

        $user = $this->user->get_by_id($uid);
        if(!$user){
            $this->session->set_userdata('last_error', '用户不存在');
            redirect(base_url('user/user', 'refresh'));
            die("");
        }
        $this->user->update_admin($uid, $nickname, $role, $ascription, $password);
        $this->session->set_userdata('last_error', '更新成功');
        redirect(base_url('users', 'refresh'));
    }
}
