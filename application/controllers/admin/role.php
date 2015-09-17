<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends Reim_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('role_model');
        $this->load->model('user_model');
        $this->load->model('module_model');
        $this->load->model('role_module_relation_model');
        $this->load->model('module_tip_model');
        $this->load->model('module_group_model');
    }

    public function index(){
        $data['title'] = '角色管理';
        $data['description'] = '管理用户角色';
        $data['username'] = $this->session->userdata('username');
        $data['uid'] = $this->session->userdata('uid');
        $data['menu'] = $this->user_model->get_menu($data['uid']);
        $data['tip'] = $this->module_tip_model->get_tip($data['uid']);
        $data['alist'] = $this->role_model->get_role_by_page();
        $data['group'] = $this->module_group_model->get();
        $data['module_list'] = $this->module_model->get();  //得到所有的module的所有信息

        foreach($data['alist'] as &$role){
            $_id = $role->id;
            $users = $this->user_model->get_user_by_role_id($_id);
            $username_arr = array();
            foreach($users as $user){
                $username_arr[] = $user->username;
            }
            $role->users = implode(', ', $username_arr);

            $_relations = $this->role_module_relation_model->get_by_role_id($_id);
            $_modules = array();
            foreach($_relations as $_r){
                $_module_id = $_r->module_id;
                foreach($data['module_list'] as $_m){
                    if($_module_id == $_m->id){
                        $_module_title = $_m->title;
                        break;
                    }
                }
                $module['module_id'] = $_module_id;
                $module['module_title'] = $_module_title;
                $_modules[] = $module;
            }
            $role->modules = $_modules;
            // var_dump($role->modules);
        }
        unset($role);

        $data['role_count'] = $this->role_model->get_role_count();
        $this->aeload('admin/role', $data);
    }

    public function del(){
        $id = $this->input->get('id');
        if(empty($id)){
            echo 'wrong id';
die;
        }
        // delete from role model
        $this->role_model->del($id);
        // delete from user model
        $this->user_model->remove_role_id($id);
        // delete from role_moduel_r model
        $this->role_module_relation_model->delete_by_role_id($id);
        return redirect(base_url() . 'admin/role', 'refresh');
    }
    public function rename(){
        $new_name= $this->input->post('new_name');
        $id = $this->input->post('id');
        if(empty($id)){
            echo 'wrong id';
die;
        }
        $this->role_model->update_role_name($id, $new_name);
        return redirect(base_url() . 'admin/role', 'refresh');
    }

    public function add(){
        $title = $this->input->post('title');
        $module_ids = explode(',', $this->input->post('module_ids'));
        $res = $this->role_model->create($title);
        if($res !== false){
            $role_id = $res;
            $this->role_module_relation_model->create_batch($role_id, $module_ids);
        }
        return redirect(base_url() . 'admin/role', 'refresh');
    }

    public function update(){
        $role_id = $this->input->post('update_role_id');
        $module_ids = explode(',', $this->input->post('update_module_ids'));
        $this->role_module_relation_model->delete_by_role_id($role_id);
        $this->role_module_relation_model->create_batch($role_id, $module_ids);
        return redirect(base_url() . 'admin/role', 'refresh');
    }
}

