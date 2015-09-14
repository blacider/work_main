<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Reim_Controller {
    private $_err_code;
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $this->load->model('role_model');
    }

    public function index()
    {
        $data['title'] = '用户管理';
        $data['description'] = '添加，修改用户信息等';
        $data['username'] = $this->session->userdata('username');
        $data['uid'] = $this->session->userdata('uid');
        $data['menu'] = $this->user_model->get_menu($data['uid']);
        $data['tip'] = $this->module_tip_model->get_tip($data['uid']);
        $data['alist'] = $this->user_model->get();
        //$data['teach_stu'] = $this->user_model->get_teach_stu();
        foreach($data['alist'] as &$_user){
            $_role = $this->role_model->get_role_by_id($_user->role_id);
            if(!empty($_role)){
                $_user->role_name = $_role->name;
            }
            else{
                $_user->role_name = '-';
            }
        }
        unset($_user);

        $data['roles'] = $this->role_model->get();

        $this->aeload('admin/user', $data);
    }

    public function update(){
        $user_id = $this->input->post('user_id');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $role_id = $this->input->post('user_role_id');
        $this->user_model->update($user_id, $nickname, $email, $role_id, $password);
        return redirect(base_url() . 'admin/user', 'refresh');
    }
    public function ban(){
        $id = $this->input->get('id');
        if(empty($id)){
            echo 'wrong id';
die;
}
$this->user_model->ban($id);
return redirect(base_url() . 'admin/user', 'refresh');
    }


    public function del(){
        $id = $this->input->get('id');
        if(empty($id)){
            echo 'wrong id';
die;
}
$this->user_model->del($id);
return redirect(base_url() . 'admin/user', 'refresh');
    }

    public function add(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $role_id = $this->input->post('user_role_id');

        if($this->_is_duplicate($username)){
            echo 'username duplicate';
die;
}
$this->user_model->create($username, $password, $nickname, $email, $role_id);

return redirect(base_url() . 'admin/user', 'refresh');
    }

    private function _is_duplicate($username){
        $user = $this->user_model->get_by_username($username);
        return !empty($user);
    }
}


