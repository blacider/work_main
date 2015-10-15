<?php

class Broadcast extends Reim_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
        $this->load->model('group_model', 'groups');
        $this->load->model('usergroup_model','ug');
        $this->load->model('account_set_model','account_set');
        $this->load->model('category_model','category');
        $this->load->model('reim_show_model','reim_show');
        $this->load->model('broadcast_model','broadcast');
    }

    public function index() {
        $broadcast = $this->broadcast->get_info();

        return $this->bsload('broadcast/list',
            array(
                'title' => '系统消息列表'
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('company/index'), 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '系统消息列表', 'class' => '')
                )
            ));
    }

    public function create() {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $_ranks = $this->groups->get_rank_level(1);
        $_levels = $this->groups->get_rank_level(0);
        $ranks = array();
        $levels = array();

        if($_ranks['status']>0)
        {
            $ranks = $_ranks['data'];
        }

        if($_levels['status']>0)
        {
            $levels = $_levels['data'];
        }
        $_members = $this->groups->get_my_list();
        $members = array();
        if($_members['status'] > 0)
        {
            $members = $_members['data']['gmember'];
        }
        $_sobs = $this->account_set->get_account_set_list();
        $sobs = array();
        $sob_ranks = array();
        $sob_levels = array();
        $sob_ranks_dic = array();
        $sob_levels_dic =array();
        $sob_members_dic =array();
        $sob_groups = array();
        $sob_members = array();
        $range = '';
        if($_sobs['status'])
        {
            $sobs = $_sobs['data'];
        }
        $range = 0;
        foreach($sob_ranks as $sr)
        {
            array_push($sob_ranks_dic,$sr['id']);
        }
        foreach($sob_levels as $sl)
        {
            array_push($sob_levels_dic,$sl['id']);
        }
        foreach($sob_members as $sm)
        {
            array_push($sob_members_dic,$sm['id']);
        }

        $_categories = $this->category->get_list();
        $categories = array();
        if($_categories['status'] > 0)
        {
            $categories = $_categories['data']['categories'];
        }
        log_message('debug','***category:' . json_encode($_categories));
        $sob_categories = array();
        $all_categories = array();
        $sob_keys =array();
        foreach($categories as $cate)
        {
            $all_categories[$cate['id']]=array();
            $path = "http://api.cloudbaoxiao.com/online/static/" . $cate['avatar'] .".png";
            if(array_key_exists('extra_type',$cate))
            {
                $all_categories[$cate['id']]=array('child'=>array(),'avatar_'=>$cate['avatar'],'avatar'=>$path,'id'=>$cate['id'],'pid'=>$cate['pid'],'name'=>$cate['category_name'],'sob_code'=>$cate['sob_code'],'note'=>$cate['note'],'force_attach'=>$cate['force_attach'], 'max_limit'=>$cate['max_limit'],'extra_type'=>$cate['extra_type']);
            }
            else
            {
                $all_categories[$cate['id']]=array('child'=>array(),'avatar_'=>$cate['avatar'],'avatar'=>$path,'id'=>$cate['id'],'pid'=>$cate['pid'],'name'=>$cate['category_name'],'sob_code'=>$cate['sob_code'],'note'=>$cate['note'],'force_attach'=>$cate['force_attach'], 'max_limit'=>$cate['max_limit'],'extra_type'=>0);
            }
        }

        $path = "http://api.cloudbaoxiao.com/online/static/0.png";
        $all_categories[0]=array('child'=>array(),'avatar_'=>0,'avatar'=>$path,'id'=>0,'pid'=>-1,'name'=>"顶级分类",'sob_code'=>0,'note'=>'','force_attach'=>0,'extra_type'=>0);
        foreach($categories as $cate)
        {
            if($cate['pid'] !=-1)
            {
                array_push($all_categories[$cate['pid']]['child'],array('id'=>$cate['id'],'name'=>$cate['category_name']));
            }
        }

        $gmember = array();
        $group = $this->groups->get_my_list();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }

        $members_dic = array();
        foreach($gmember as $m)
        {
            if(array_key_exists('email',$m))
            {
                $members_dic[$m['email']] = $m['id'];
            }
        }

        $ugroups = $this->ug->get_my_list();
        return $this->bsload('broadcast/new',
            array(
                'title' => '创建系统消息'
                ,'ugroups' => $ugroups['data']['group']
                ,'sob_data' => $sob_groups
                ,'sob_keys' => $sob_keys
                ,'all_categories' => $all_categories
                ,'members' => $members
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'sob_ranks' => $sob_ranks_dic
                ,'sob_levels' => $sob_levels_dic
                ,'sob_members' => $sob_members_dic
                ,'range' => $range
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('company/index'), 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '创建系统消息', 'class' => '')
                )));
    }
    public function docreate() {
        $_title = $this->input->post('title');
        $_content = $this->input->post('content');
        $_type = $this->input->post('range');
        $_groups = implode(',', $this->input->post('groups'));
        log_message('debug','title:' . $_title);
        log_message('debug','content:' . $_content);
        if($_title || $_content) {
            $this->broadcast->create($_title, $_content, $_type, $_groups);
        }
        return redirect(base_url('broadcast/index'));
    }
}
