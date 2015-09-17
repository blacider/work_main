<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends Reim_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('module_model');
        $this->load->model('module_group_model');
        $this->load->model('module_tip_model');
    }

    public function index() {
        $data['title'] = '模块管理';
        $data['description'] = '管理功能模块';
        $data['username'] = $this->session->userdata('username');
        $data['uid'] = $this->session->userdata('uid');
        $data['menu'] = $this->user_model->get_menu($data['uid']);
        $data['tip'] = $this->module_tip_model->get_tip($data['uid']);
        $data['alist'] = $this->module_model->get();
        $data['module_group_list'] = $this->module_group_model->get();

        foreach($data['alist'] as &$_module){
            foreach($data['module_group_list'] as $_group){
                if($_module->group_id == $_group->id){
                    $_module->group_title = $_group->title;
                    break;
                }
            }
        }
        unset($_module);

        $this->aeload('admin/module', $data);

    }

    public function add(){
        // title, desc, path
        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $path = $this->input->post('path');
        $group_id = $this->input->post('module_group_id');

        if(empty($title) || empty($path)){
            echo 'wrong title or path';
die;
        }

        if($group_id == 0){
            // create new group
            $group_title = $this->input->post('new_group_title');
            if(empty($group_title)){
                echo '新建组，要输入组标题';
die;
            }
            $group_id = $this->module_group_model->create($group_title, '');
        }

        if($group_id){
            // 只在group_id 不是false, 不是0的时候才创建组
            $res = $this->module_model->create($title, $desc, $path, $group_id);
        }
        return redirect(base_url().'admin/module', 'refresh');
    }

    public function del(){
        $id = $this->input->get('id');
        if(empty($id)){
            echo 'wrong id';
die;
        }
        // delete from module model
        $this->module_model->delete($id);

        // delete from role_moduel_r model
        $this->load->model('role_module_relation_model');
        $this->role_module_relation_model->delete_by_module_id($id);
        return redirect(base_url().'admin/module', 'refresh');
    }

    public function get_avalible(){
        return array('user', 'role', 'module');
    }
}

