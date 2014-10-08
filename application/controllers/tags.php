<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model', 'category');
        $this->load->model('group_model', 'groups');
    }

    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $category = $this->category->get_list();
        if($category){
            $_group = $category['data']['tags'];
            foreach($_group as &$n){
                if($n['pid'] == 0){
                    $n['icon'] = base_url('statics/img/executive.png'); 
                }  else {
                    $n['icon'] = base_url('statics/img/administrator.png'); 
                }
            }
        }
        if($group){
            $ginfo = $group['data']['ginfo'];
            $base = array('id' => 0, 'category_name' => $ginfo['group_name'], 'icon' => base_url('statics/img/executive.png'), 'open' => true);
            array_push($_group, $base);
        }
        $this->eload('tags/index',
            array(
                'title' => '分类管理'
                ,'category' => json_encode($_group)
            )
        );
    }

}
