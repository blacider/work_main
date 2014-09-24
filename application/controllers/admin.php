<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users/user_model', 'users');
        $this->load->model('users/customer_model', 'cmodel');
    }
    public function index(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        //$users = $this->users->get_all();
        //$total_user = $users['total'];
        //$users = $users['data'];
        //$customers= $this->cmodel->get_all_customers();
        $this->eload('user/index',
            array(
                'title' => '用户管理'
                //, 'alist' => $users
                //, 'customers' => $customers['data']
            )
        );
    }
}
