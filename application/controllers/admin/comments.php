<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends Reim_Controller {
    private $_err_code;
    public function __construct(){
        parent::__construct();
        $this->load->model('comments_model', 'comments');
        $this->load->model('user_model');
    }

    public function index($page = 0, $pagesize = 20)
    {
        $data['uid'] = $this->session->userdata('uid');
        //  $user = $this->session->userdata('user');
        $data['menu'] = $this->user_model->get_menu($data['uid']);

        if(!empty($data['menu'])){
            foreach($data['menu'] as $_menu){
                if($_menu->type == 'comments'){
                    $url = $_menu->path;
                    break;
                }
            }
            $comments = $this->comments->get_list($page, $pagesize);
            if(!$comments['status']){
                echo "出错了";
            }
            $comments = $comments['data'];
            $data = $comments['data'];
            $count = $comments['total'];
            $this->load->library('pagination');

            $config['base_url'] = base_url('tasks/index');
            $config['total_rows'] = $count;
            $config['per_page'] = $pagesize; 
            $this->pagination->initialize($config); 
            $links = $this->pagination->create_links();
            $this->aeload('admin/comments', array('alist' => $data, 'pager' => $links, 'title' => '用户反馈'));
        }
        else{
            echo '无权访问本系统功能';
        }
    }

    public function add(){
        $rid = $this->input->post('mid');
        $msg = $this->input->post('msg');
        $work_id = $this->session->userdata('uid');
        $this->comments->add_worker($work_id, $msg, $rid);
        redirect(base_url('admin/comments'));
    }

}
