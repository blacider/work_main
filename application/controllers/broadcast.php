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

    public function delete_info($id)
    {
        $this->need_group_it();
        $info = $this->broadcast->delete($id);
        if($info['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$info['msg']);
        }
        return redirect(base_url('broadcast/index'));
    }

    public function update_info($id , $show = 0)
    {
        $this->need_group_it();
        $info = $this->broadcast->get_info($id);
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);
        $ranks = array();
        $levels = array();
        $members = array();
        $_ugroups = array();

        if($_ranks['status'] > 0)
            $ranks = $_ranks['data'];
        if($_levels['status'] > 0)
            $levels = $_levels['data'];

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

        $ugroups = $this->ug->get_my_list();
        if($ugroups['status'] > 0)
        {
            $_ugroups = $ugroups['data']['group'];
        }

        if($info['status'] <= 0)
        {
            $this->session->set_userdata('last_error','权限不足');
            return redirect(base_url('broadcast/index'));
        }

        $broadcast = $info['data'];

        return $this->bsload('broadcast/update_info',
            array(
                'title' => '消息编辑'
                ,'broadcast' => $broadcast
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'members' => $gmember
                ,'ugroups' => $_ugroups
                ,'id' => $id
                ,'show' => $show
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('company/index'), 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '消息编辑', 'class' => '')
                )
            ));
    }

    public function index() {
        $info = $this->broadcast->get_info();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $broadcast = array();
        if($info['status'] > 0) 
            $broadcast = $info['data'];
            
        
        return $this->bsload('broadcast/list',
            array(
                'title' => '系统消息列表'
                ,'broadcast' => $broadcast
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
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
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '创建系统消息', 'class' => '')
                )));
    }
    public function docreate($id = 0) {
        $_title = $this->input->post('title');
        $_content = $this->input->post('content');
        $_type = $this->input->post('range');
        $_groups = $this->input->post('groups');
        $_ranks= $this->input->post('ranks');
        $_levels = $this->input->post('levels');
        $_member = $this->input->post('members');
        $all = $this->input->post('all');
        if(!$all)
            $all = "0";
        else
            $all = "1";
        $send = $this->input->post('send');
        $_bd_info = $this->input->post('bd_info');
        $bd_info = json_decode($_bd_info,True);
        $profile= $this->session->userdata('profile');

        $uid = $profile['id'];

        $groups = '';
        $ranks = '';
        $levels = '';
        $member = '';
        
        $origin_info = array();
        if($bd_info)
        {
            $origin_info = array('title' => trim($bd_info['title']),
                                 'content' => trim($bd_info['content']),
                                 'users' => implode(',',$bd_info['users']),
                                 'groups' => implode(',',$bd_info['groups']),
                                 'ranks' => implode(',',$bd_info['ranks']),
                                 'levels' => implode(',',$bd_info['levels']),
                                 'all' => $bd_info['all']
                                );
        }

        if($_groups) {
            sort($_groups);
            $groups = implode(',',$_groups); 
        }

        if($_ranks)
        {
            sort($_ranks);
            $ranks = implode(',',$_ranks); 
        }
        
        if($_levels) 
        {
            sort($_levels);
            $levels = implode(',',$_levels); 
        }

        if($_member) 
        {
            sort($_member);
            $member = implode(',',$_member); 
        }

        $new_info = array('title' => trim($_title),
                         'content' => trim($_content),
                         'users' => trim($member),
                         'groups' => trim($groups),
                         'ranks' => trim($ranks),
                         'levels' => trim($levels),
                         'all' => $all 
        );

        $origin_info_str = json_encode($origin_info);
        $new_info_str = json_encode($new_info);
        log_message('debug','origin_info:' . json_encode($origin_info));
        log_message('debug','new_info:' . json_encode($new_info));
        log_message('debug','new_info:' . (json_encode($new_info) == json_encode($origin_info)));
        log_message('debug','profile:' . json_encode($profile));
        log_message('debug','title:' . $_title);
        log_message('debug','send:' . $send);
        log_message('debug','content:' . $_content);
        log_message('debug','groups:' . $groups . 'ranks:' . $ranks . 'levels:' . $levels . 'member:' . $member);
        log_message('debug','bd_info:' . json_encode($bd_info));
        if($_title || $_content) {
            if($id == 0)
            {
                $info = $this->broadcast->create($uid, $_title, $_content, $member, $groups, $ranks, $levels, $all);
                if($info['status'] > 0)
                    $this->session->set_userdata('last_error','创建消息成功');
                else
                    $this->session->set_userdata('last_error',$info['data']['msg'] . ',创建消息失败');

                if($send == 1 && $info['status'] > 0)
                {
                    $is_send = $this->broadcast->send($info['data']['id']); 
                    if($info['status'] > 0)
                        $this->session->set_userdata('last_error','创建消息成功,并且发送成功');
                    else
                        $this->session->set_userdata('last_error','创建消息成功,' . $info['data']['msg']);
                }
            }
            else //更新信息
            {
                /*消息未发送的情况*/
                if(!$bd_info['sent'])
                {
                        if($origin_info_str != $new_info_str)
                        {
                                $info = $this->broadcast->update($id, $uid, $_title, $_content, $member, $groups, $ranks, $levels ,$all);
                                
                                if($info['status'] > 0)
                                    $this->session->set_userdata('last_error','修改消息成功');
                                else
                                {   
                                    if($send == 1)
                                        $this->session->set_userdata('last_error',$info['data']['msg'] . '修改消息失败,发送失败');
                                    else
                                        $this->session->set_userdata('last_error',$info['data']['msg'] . '修改消息失败');
                                    return redirect(base_url('broadcast/index'));
                                }
                        }       

                        if($send == 1)
                        {
                            $is_send = $this->broadcast->send($id); 
                            if($is_send['status'] > 0)
                                $this->session->set_userdata('last_error','发送成功');
                            else
                                $this->session->set_userdata('last_error',$is_send['data']['msg'] . ',发送失败');
                        }
                }
                else //消息已经发送过
                {
                        if($origin_info_str != $new_info_str)
                        {
                                $info = $this->broadcast->create($uid, $_title, $_content, $member, $groups, $ranks, $levels, $all);
                                if($info['status'] > 0)
                                    $this->session->set_userdata('last_error','创建消息成功');
                                else
                                    $this->session->set_userdata('last_error',$info['data']['msg'] . ',创建消息失败');

                                if($send == 1 && $info['status'] > 0)
                                {
                                    $is_send = $this->broadcast->send($info['data']['id']); 
                                    if($info['status'] > 0)
                                        $this->session->set_userdata('last_error','创建消息成功,并且发送成功');
                                    else
                                        $this->session->set_userdata('last_error','创建消息成功,' . $info['data']['msg']);
                                }
                        }
                        else
                        {
                            if($send == 1)
                                $this->session->set_userdata('last_error','已经发送过一条相同信息,请修改后重新发送');
                            else
                                $this->session->set_userdata('last_error','消息未修改，请修改后重新保存');
                                
                        }
                }
            }
        }
        else
        {
             $this->session->set_userdata('last_error','标题和正文不能为空');    
        }
        return redirect(base_url('broadcast/index'));
    }
    public function doupdate($id) 
    {
        $this->docreate($id);
    }
}
