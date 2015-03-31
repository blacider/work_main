<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends REIM_Controller {

    public function __construct() {
        parent::__construct();
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
        $this->eload('groups/index',
            array(
                'title' => '公司成员'
                ,'group' => $ginfo
                ,'members' => $gmember
            )
        );
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
        redirect(base_url('groups'));
    }

    public function show_exports(){
        $this->load->model('items_model', 'items');
        $obj = $this->items->get_exports(2, 'tianyu.an@rushucloud.com');
        if($obj && $obj['status']){
            $data = $obj['data'];
        }
    }

}

