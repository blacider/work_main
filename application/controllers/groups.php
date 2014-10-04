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
            $ginfo = $group['data']['ginfo'];
            $gmember = $group['data']['gmember'];
            $gmember = $gmember ? $gmember : array();

        }
        $this->eload('groups/index',
            array(
                'title' => '公司管理'
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
        if($info['status']) {
            $this->session->set_userdata('last_error', '邀请发送成功');
        } else {
            $this->session->set_userdata('last_error', '邀请发送失败');
        }
        redirect(base_url('groups'));
    }

}

