<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends REIM_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('rule_model', 'rules');
        $this->load->model('category_model', 'category');
        $this->load->model('group_model', 'groups');
    }

    public function add(){
        $cates = $this->category->get_list();
        if($cates['status']){
            $cates = $cates['data']['categories'];
        }
        $group = $this->groups->get_my_list();
        $ggroup = $this->ug->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
            $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();

        }

        if($ggroup['status']){
            $ggroup = $ggroup['data'];
        }
        $this->bsload('rules/new',
            array(
                'title' => '成员组管理'
                ,'member' => $gmember
                ,'ggroup' => $ggroup
                ,'cates' => $cates
            )
        );
    }


    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $ggroup = $this->ug->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
            $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();

        }

        if($ggroup['status']){
            $ggroup = $ggroup['data'];
        }

        $this->bsload('rules/index',
            array(
                'title' => '成员组管理'
                ,'group' => $ginfo
                ,'members' => $gmember
                ,'ggroup' => $ggroup
            )
        );
    }


    public function update(){
        $gid = $this->input->post('src');
        $uid = $this->input->post('dest');
        $cates = $this->input->post('cates');
        $amounts = $this->input->post('threshold');
        if(count($cates) != count($amounts)){
            $this->session->set_userdata('error', '数据错');
            //return redirect(base_url('rules'));
        } 
        $this->rules->update($gid, $uid, join(',', $cates), join(',', $amounts));
        //return redirect(base_url('rules'));
        //print_r($cates);
        //print_r($amounts);
    }
}
