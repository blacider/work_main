<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends REIM_Controller  {
    public function __construct(){   
        parent::__construct(); 
        $this->load->model('users/user_model');  
        $this->load->model('users/customer_model', 'cmodel');  
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $customers= $this->cmodel->get_all_customers();
        $total = $customers['count'];
        $customers = $customers['data'];
        $this->eload('user/customers', array('title' => '客户管理', 'alist' => $customers, 'error' => $error));
    }

    public function create(){
        $name = $this->input->post('name');
        if(!$name){
            $this->session->set_userdata('last_error', '参数错误');
            redirect(base_url('admin/customers', 'refresh'));
            die("");
        }
        $id = $this->cmodel->create($name);
        if($id){
            $this->session->set_userdata('last_error', '创建成功');
        } else {
            $this->session->set_userdata('last_error', '创建失败');
        }
        redirect(base_url('customers', 'refresh'));
    }

    public function delete($id){
        $this->cmodel->destory_customer_by_id($id);
        $this->session->set_userdata('last_error', '删除成功');
        redirect(base_url('customers', 'refresh'));
    }

    public function update(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');

        $item = $this->cmodel->get_customer_by_id($id);
        if(empty($item)){
            $this->session->set_userdata('last_error', '参数错误');
            redirect(base_url('customers', 'refresh'));
            die("");
        }
        $this->cmodel->update_customer($id, $name);
        $this->session->set_userdata('last_error', '修改成功');
        redirect(base_url('customers', 'refresh'));
    }
}
