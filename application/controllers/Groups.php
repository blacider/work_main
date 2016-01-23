<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('group_model', 'groups');
    }

    public function update(){
        $this->need_group_agent();
        $pid = $this->input->post('pgroup');
        $code = $this->input->post('gcode');
        $manager = $this->input->post('manager');
        $name = $this->input->post('gname');
        $uids = $this->input->post('uids');
        $pid = $this->input->post('pgroup');
        $manager = $this->input->post('manager');
        $uids = implode(",", $uids);
        $images = '';
        $_images = $this->input->post('images');
        if($_images)
        {
            $images = $_images;
        }        
        $info = $this->ug->create_group($manager,$uids, $name,$code,$pid,$images);
        
        if($info['status'] > 0)
        {
            $this->session->set_userdata('last_error','创建部门成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$info['data']['msg']);
        }
        redirect(base_url('members/groups'));
    }

    public function index(){
        $this->need_group_it();
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
        $this->bsload('groups/index',
            array(
                'title' => '成员组管理'
                ,'group' => $ginfo
                ,'members' => $gmember
            )
        );
    }


    public function save(){
        $this->need_group_it();
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
        if($oper == "del") {
            die($this->groups->delete_group($id));
        }



    }

    public function listdata(){
        $this->need_group_it();
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->ug->get_my_list();
        log_message("debug", "LISTDATA:" . json_encode($group));
        if($group['status']){
            foreach($group['data'] as &$s){
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon-trash tdel" data-id="' . $s['id'] . '"></span></div>';
            }
            die(json_encode($group['data']));
        }
    }

    public function invite() {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $this->need_group_it();
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
        $this->need_group_it();
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
        $this->need_group_it();
        $name = $this->input->post('groupname');
        $info = $this->groups->create_group($name);
        if($info && $info['status']) {
            $this->session->set_userdata('last_error', '创建成功');
        } else {
            $this->session->set_userdata('last_error', '创建失败');
        }
        redirect(base_url('members/groups'));
    }

    public function show_exports(){
        $this->need_group_it();
        $this->load->model('items_model', 'items');
        $obj = $this->items->get_exports(2, 'tianyu.an@rushucloud.com');
        if($obj && $obj['status']){
            $data = $obj['data'];
        }
    }
}

