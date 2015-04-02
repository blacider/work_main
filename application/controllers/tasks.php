<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('errors_model', 'errors');
    }

    public function index($page = 0, $pagesize = 20){
        $errors = $this->errors->get_list($page, $pagesize);
        $data = $errors['data'];
        $count = $errors['total'];
        $this->load->library('pagination');

        $config['base_url'] = base_url('tasks/index');
        $config['total_rows'] = $count;
        $config['per_page'] = 20; 

        $this->pagination->initialize($config); 

        $links = $this->pagination->create_links();

        $this->aeload('tasks/index',
            array(
                'title' => '后台任务列表'
                ,'alist' => $data
                ,'count' => $count
                ,'pager' => $links
            ));

    }
}
