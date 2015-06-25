<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model', 'category');
          $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $category = $this->category->get_list();
        if($category){
            $_group = $category['data']['categories'];
        }
        $this->bsload('category/index',
            array(
                'title' => '分类管理'
                ,'category' => $_group
                ,'error' => $error
                //,'category' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('category/index'), 'name' => '标签和分类', 'class' => '')
                        ,array('url'  => '', 'name' => '分类管理', 'class' => '')
                    ),
            )
        );
    }

public function tags(){
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

    public function newcategory(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $category = $this->category->get_list();
        if($category){
            $_group = $category['data']['categories'];
        }
        $this->bsload('category/newcategory',
            array(
                'title' => '分类管理'
                ,'category' => $_group
                ,'error' => $error
                //,'category' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('category/index'), 'name' => '标签和分类', 'class' => '')
                        ,array('url'  => '', 'name' => '分类管理', 'class' => '')
                    ),
            )
        );
    }


    public function create(){
        $name = $this->input->post('category_name');
        $pid = $this->input->post('pid');
        $prove_ahead= $this->input->post('prove_ahead');
        $max_limit = $this->input->post('max_limit');
        $cid = $this->input->post('category_id');
        $msg = '添加分类失败';
        $obj = null;
        if($cid > 0){
            $obj = $this->category->update($cid, $name, $pid, $prove_ahead, $max_limit);
        } else {
            $obj = $this->category->create($name, $pid, $prove_ahead, $max_limit);
        }
        if($obj && $obj['status']){
            $msg = '添加分类成功';
        } else {
            $msg = $obj['data']['msg'];
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('category'));
    }

    public function drop($id){
        if(!$id) {
            log_message("debug", "DROP: $id");
            $this->session->set_userdata('last_error', '参数错误');
            return redirect(base_url('category'));
        }
        $obj = $this->category->remove($id);
        if($obj && $obj['status']){
            log_message("debug", "删除成功 S");
            $msg = '删除分类成功';
        } else {
            $msg = $obj['data']['msg'];
            log_message("debug", "删除失败 F");
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('category'));
    }
    public function gettreelist(){
    	$category = $this->category->get_list();
        //$data = $category['data'];
       // $group = $data['categories'];

	    //$category['data']['categroies'];
        //$hello = array('a' => 1,'b' => 2);
        $group = $category['data']['categories'];
        $tree = array();
        foreach ($group as $item) {  
            # code...
            array_push($tree,array($item['category_name'] => array('name' => $item['category_name'] ,'type' => 'folder','icon-class' => 'red')));
        };
        die(json_encode($tree));
    }
}
