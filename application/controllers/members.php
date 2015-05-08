<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('group_model', 'groups');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
            $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();

        }
        $this->bsload('members/index',
            array(
                'title' => '公司成员'
                ,'group' => $ginfo
                ,'members' => $gmember
            )
        );
    }


    public function save(){
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $credit_card = $this->input->post('credit_card');
        $admin = $this->input->post('admin');
        $id = $this->input->post('id');
        $oper = $this->input->post('oper');

        if($oper == "edit"){
            die($this->groups->update_profile($nickname, $email, $phone, $credit_card, $admin, $id));
        }



    }

    public function listdata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->groups->get_my_list();
        log_message("debug", json_encode($group));
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
            $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();

        }
        foreach($gmember as &$g){
            if($g['admin'] == 0){
                $g['admin'] = '员工';
            }
            elseif($g['admin'] == 1){
                $g['admin'] = '管理员';
            }
            elseif($g['admin'] == 2){
                $g['admin'] = '会计';
            }
        }
        die(json_encode($gmember));
    }

    public function invite() {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $name = $this->input->post('username');
        $info = $this->groups->set_invite($name);
        if($info && $info['status']) {
            $this->session->set_userdata('last_error', '邀请发送成功');
        } else {
            $this->session->set_userdata('last_error', '邀请发送失败');
        }
        redirect(base_url('groups'));
    }

    public function setadmin($uid = 0){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $ids = $this->input->post('data');
        if(count($ids) == 0){
            die("");
        }
        $_ids = implode(',', $ids);
        $_type = $this->input->post('type');
        $info = $this->groups->setadmin($_ids, $_type);
        redirect(base_url('groups'));
    }

    public function create(){
        $name = $this->input->post('groupname');
        $info = $this->groups->create_group($name);
        if($info && $info['status']) {
            $this->session->set_userdata('last_error', '创建成功');
        } else {
            $this->session->set_userdata('last_error', '创建失败');
        }
        redirect(base_url('members'));
    }

    public function show_exports(){
        $this->load->model('items_model', 'items');
        $obj = $this->items->get_exports(2, 'tianyu.an@rushucloud.com');
        if($obj && $obj['status']){
            $data = $obj['data'];
        }
    }
    public function add() {
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->bsload('groups/new',
            array(
                'title' => '成员组管理',
                'member' => $gmember
            )
        );
    }

    public function listgroup(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->ug->get_my_list();
        log_message("debug", "LISTDATA:" . json_encode($group));
        /// 结构好奇怪啊
        //
        if($group['status']){
            //die(json_encode(array('data' => $group['data'])));
            die(json_encode($group));
        }
    }


    public function newmember(){
        $group = $this->ug->get_my_list();
        $this->bsload('members/new',
            array(
                'title' => '成员组管理',
                'groups' => $group['data']
            )
        );
    }

    public function docreate(){
        $nickname = $this->input->post('nickname');
        $phone = $this->input->post('mobile');
        $credit = $this->input->post('credit');
        $email = $this->input->post('email');
        $groups = $this->input->post('groups');
        $renew = $this->input->post('renew');
        if($email == "" && $phone == ""){
            // 出错
            $this->show_error('手机号或者邮箱必须填写一项');
        }
        $name = $email;
        if(!$name) {
            $name = $phone;
            $phone = '';
        }
        // 等逻辑
        $this->groups->set_invite($email, $nickname, $phone, $credit, $groups);
        if($renew) {
            redirect(base_url('members/newmember'));
        } else {
            redirect(base_url('members/index'));
        }
    }













}

