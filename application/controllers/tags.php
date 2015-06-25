<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $tags = $this->tags->get_list();
        if($tags){
            $tags = $tags['data']['tags'];
        }
        $this->bsload('tags/index',
            array(
                'title' => '标签管理'
                ,'category' => $tags
                ,'error' => $error
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa home-icon')
                        ,array('url'  => base_url('tags/index'), 'name' => '标签管理', 'class' => '')
                    ),
            )
        );
    }

   
    public function create(){
        $name = $this->input->post('category_name');
        $id = $this->input->post('category_id');
        if($id > 0){
            $obj = $this->tags->update($id, $name);
        } else {
            $obj = $this->tags->create($name);
        }

        if($obj && $obj['status']){
            $msg = '添加分类成功';
        } else {
            $msg = $obj['data']['msg'];
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('tags'));
    }


    public function drop($id = 0){
        if(!$id) {
            log_message("debug", "DROP: $id");
            $this->session->set_userdata('last_error', '参数错误');
            return redirect(base_url('category'));
        }
        $obj = $this->tags->remove($id);
        if($obj && $obj['status']){
            log_message("debug", "删除成功 S");
            $msg = '删除分类成功';
        } else {
            $msg = $obj['data']['msg'];
            log_message("debug", "删除失败 F");
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('tags'));
    }

}
