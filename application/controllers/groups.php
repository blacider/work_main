<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('group_model', 'groups');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->eload('groups/index',
            array(
                'title' => '公司管理'
            )
        );
    }

}

