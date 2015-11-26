<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('user_model', 'users');
        $this->load->model('group_model', 'groups');
        $this->load->model('reim_show_model','reim_show');
    }

    public function set_managers()
    {
        $this->need_group_it();
        $_members = $this->input->post('persons');
        $members = json_decode($_members,True);
        log_message('debug',"Person:" . json_encode($members));
        $_members = array();
        foreach($members as $m) {
            if(array_key_exists('id', $m) && array_key_exists('manager', $m)) {
                array_push($_members, $m);
            }
        }
        $members = $_members;
        log_message("debug", "Set Manager:" . json_encode($members));

        $buf = $this->groups->set_managers($members);
        $set_manager_back = array();
        $set_success = array();
        if($buf['status']>0)
        {
            $set_manager_back = $buf['data'];
        }
        foreach($set_manager_back as $back)
        {
            if($back['code'] == 0)
            {
                array_push($set_success,$back['id']);
            }
        }
        log_message('debug','set_success' . json_encode($set_success));
        die(json_encode(array('data'=>$set_success)));
    /*
    if($buf['status']>0)
    {
        die(json_encode(array('msg'=>'设置成功')));
    }
    else
    {
        die(json_encode(array('msg'=>'设置失败')));
    }
     */
    }

    public function members_del()
    {
        $this->need_group_it();
        $email = $this->input->post('email');
        log_message('debug','email:' . $email);
        $buf = $this->users->del_email($email);
        log_message('debug','email:' . $email);

        if($buf['status']>0)
        {
            die(json_encode(array('status'=>1,'msg'=>'删除成功')));
        }
        else
        {
            die(json_encode(array('status'=>0,'msg'=>$buf['data']['msg'])));
        }
    }

    public function delmembers()
    {
        $this->need_group_it();
        $_members = $this->groups->get_my_list();
        $members = array();
        if($_members['status'] > 0)
        {
            $members = $_members['data']['gmember'];
        }
        $this->bsload('members/delmembers',
            array(
                'title' => '删除员工'
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/groups'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '删除员工', 'class' => '')
                )
                ,'members' => $members
            )
        );
    }

    public function imports_create_group()
    {
        $this->need_group_it();
        $name=$this->input->post('name');
        $ug = array();
        $_ug = $this->ug->get_my_list();
        if($_ug['status'] > 0)
        {
            $ug = $_ug['data']['group'];
        }
        foreach($ug as $u)
        {
            if($u['name'] == $name)
            {
                die(json_encode(array('msg' => '部门已经添加')));
            }
        }

        $buf = $this->ug->create_group(0,'',$name,'',0);
        if($buf['status']>0)
        {
            die(json_encode(array('msg' => '部门添加成功')));
        }
        else
        {
            die(json_encode(array('msg' => $buf['data']['msg'])));
        }
    }
    public function imports_create_rank_level($rank)
    {
        $this->need_group_it();
        $name = $this->input->post('name');
        $_ranks_levels = $this->reim_show->rank_level($rank);
        $ranks_levels = array();
        if($_ranks_levels['status']>0)
        {
            $ranks_levels = $_ranks_levels['data'];
        }

        foreach($ranks_levels as $rl)
        {
            if($rl['name'] == $name)
            {
                die(array('msg' => '职位已经添加'));
            }
        }

        $buf = $this->groups->create_rank_level($rank,$name);
        log_message('debug','name:' . $name);
        if($buf['status'] > 0)
        {
            die(json_encode(array('msg' => '添加职位成功')));
        }
        else
        {
            die(json_encode(array('msg' => '添加职位失败')));
        }
    }
    public function update_rank_level($rank)
    {
        $this->need_group_it();	

        $name = $this->input->post('name');
        $id = $this->input->post('rank_level_id');

        $_rank_level = $this->groups->get_rank_level($rank);
        $rank_level = array();
        if($_rank_level['status'] > 0)
        {
            $rank_level=$_rank_level['data'];
        }
        foreach($rank_level as $rl)
        {
            if($name == $rl['name'])
            {
                $this->session->set_userdata('last_error','职称已经存在,修改失败');
                return redirect(base_url('members/rank'));
            }
        }
        log_message('debug','name:' . $name . ' ' . 'id:' .$id);
        $buf = $this->groups->update_rank_level($rank,$id,$name);
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','修改成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$buf['data']['msg']);
        }

        return redirect(base_url('members/rank'));
    }
    public function del_rank_level($rank,$id)
    {
        $this->need_group_it();

        $buf = $this->groups->del_rank_level($rank,$id);
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$buf['data']['msg']);
        }

        return redirect(base_url('members/rank'));
    }
    public function create_rank_level($rank)
    {
        $this->need_group_it();
        $name = $this->input->post('name');

        $_rank_level = $this->groups->get_rank_level($rank);
        $rank_level = array();
        if($_rank_level['status'] > 0)
        {
            $rank_level=$_rank_level['data'];
        }
        foreach($rank_level as $rl)
        {
            if($name == $rl['name'])
            {
                $this->session->set_userdata('last_error','职称已经存在,添加失败');
                return redirect(base_url('members/rank'));
            }
        }

        $buf = $this->groups->create_rank_level($rank,$name);
        log_message('debug','name:' . $name);
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','添加成功');
            return redirect(base_url('members/rank'));
        }
        else
        {
            $this->session->set_userdata('last_error','添加失败');
            return redirect(base_url('members/rank'));
        }
    }

    public function rank()
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $_ranks = $this->groups->get_rank_level(1);
        $_levels = $this->groups->get_rank_level(0);
        $ranks = array();
        $levels = array();
        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }

        if($_levels > 0)
        {
            $levels = $_levels['data'];
        }
        $this->bsload('rank/index',
            array(
                'title' => '职位设置'
                ,'levels' => $levels
                ,'ranks' => $ranks
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/groups'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '职位设置', 'class' => '')
                ),
            )
        );
    }
    public function remove_from_group($gid,$uid)
    {
        $this->need_group_it();
        $group = json_decode($this->ug->get_single_group($gid),True);
        if($group['status'] > 0) {
            $data = $group['data'];		
        }
        else {
            $this->session->set_userdata('last_error','部门信息获取错误');
            return redirect(base_url('members/index'));
        }

        $members = array();
        $g_info = array();
        if(array_key_exists('member',$data)) {
            $members = $data['member'];	
        }	
        if(array_key_exists('group',$data)) {
            $g_info = $data['group'];
        }
        else {
            $this->session->set_userdata('last_error','部门信息获取错误');
            return redirect(base_url('members/index'));
        }
        $uids = array();
        foreach($members as $item) {
            if($item['id'] != $uid) {
                array_push($uids,$item['id']);
            }
        }

        $manager = $g_info['manager'];
        $name = $g_info['name'];
        $code = $g_info['code'];
        $pid = $g_info['pid'];

        if($uids) {
            $uids = implode(',',$uids);
        }
        else {
            $uids = '';
        }
        $buf = $this->ug->update_data($manager,$uids, $name,$code,$pid,$gid);

        if($buf['status']>0) {
            $this->session->set_userdata('last_error','移除成功');
            return redirect(base_url('members/index'));
        }
        else {
            $this->session->set_userdata('last_error','移除失败');
            return redirect(base_url('members/index'));
        }

    }

    public function search() {
        $key = $this->input->get('key');
        $error = $this->session->userdata('last_error');
        $profile = $this->session->userdata('profile');
        $groups = $profile['group'];
        if(array_key_exists('config', $groups) && $groups['config']) {
            $config = json_decode($groups['config'], True);
            if(array_key_exists('private_structure', $config)){
                //TODO 修改是否开放组织结构
                //$close = $config['close_directly'];
                $close = $config['private_structure'];
                log_message("debug", "Profile admin $close :" . $profile['admin']);
                if($close == 1 && $profile['admin'] < 1) {
                    return redirect(base_url('items/index'));
                } 
            }
        }
        //log_message('debug', 'Profile:' . json_encode($groups['config']));
        //$config = 
        //log_message('debug', 'Profile:' . json_encode($profile));
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        if($error == '') {
            $error = $this->session->userdata('login_error');
            $this->session->unset_userdata('login_error');
        }
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);
        $ranks = array();
        $levels = array();
        $ranks_dic = array();
        $levels_dic = array();

        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }

        foreach($ranks as $r)
        {
            $ranks_dic[$r['id']] = $r['name'];
        }
        if($_levels['status'] > 0)
        {
            $levels = $_levels['data'];
        }

        foreach($levels as $r)
        {
            $levels_dic[$r['id']] = $r['name'];
        }
        $group = $this->groups->get_my_list();
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
        log_message("debug","gmembers:".json_encode($gmember));
        $this->bsload('members/index',
            array(
                'title' => '组织结构'
                ,'group' => $ginfo
                ,'members' => $gmember
                ,'error' => $error
                ,'ranks' => $ranks_dic
                ,'levels' => $levels_dic
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => base_url('members/index'), 'name' => '组织结构', 'class' => '')
                    ,array('url'  => '', 'name' => '搜索结果', 'class' => '')
                ),'search' => $key
            )
        );
    }
    public function index(){
        $error = $this->session->userdata('last_error');
        $profile = $this->session->userdata('profile');
        $groups = $profile['group'];
        if(array_key_exists('config', $groups) && $groups['config']) {
            $config = json_decode($groups['config'], True);
            if(array_key_exists('private_structure', $config)){
                //TODO 修改是否开放组织结构
                //$close = $config['close_directly'];
                $close = $config['private_structure'];
                log_message("debug", "Profile admin $close :" . $profile['admin']);
                if($close == 1 && $profile['admin'] < 1) {
                    return redirect(base_url('items/index'));
                } 
            }
        }
        //log_message('debug', 'Profile:' . json_encode($groups['config']));
        //$config = 
        //log_message('debug', 'Profile:' . json_encode($profile));
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        if($error == '') {
            $error = $this->session->userdata('login_error');
            $this->session->unset_userdata('login_error');
        }
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);
        $ranks = array();
        $levels = array();
        $ranks_dic = array();
        $levels_dic = array();

        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }

        foreach($ranks as $r)
        {
            $ranks_dic[$r['id']] = $r['name'];
        }
        if($_levels['status'] > 0)
        {
            $levels = $_levels['data'];
        }

        foreach($levels as $r)
        {
            $levels_dic[$r['id']] = $r['name'];
        }
        $group = $this->groups->get_my_list();
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
        $member_matrix = array();
        foreach($gmember as $g){
            $member_matrix[$g['id']] = $g['nickname'];
            log_message("debug","alvayang:".json_encode($g));
        }
        foreach($gmember as &$g){
            $_gid = $g['manager_id'];
            $g['manager'] = '无上级';
            if(array_key_exists($_gid, $member_matrix)){
                $g['manager'] = $member_matrix[$_gid];
            }
        }
        $this->bsload('members/index',
            array(
                'title' => '组织结构'
                ,'group' => $ginfo
                ,'members' => $gmember
                ,'error' => $error
                ,'ranks' => $ranks_dic
                ,'levels' => $levels_dic
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '组织结构', 'class' => '')
                ), 'search' => ''
            )
        );
    }


    public function groups($search = ''){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $profile = $this->session->userdata('profile');
        $groups = $profile['group'];
        if(array_key_exists('config', $groups) && $groups['config']) {
            $config = json_decode($groups['config'], True);
            if(array_key_exists('private_structure', $config)){
                $close = $config['private_structure'];
                log_message("debug", "Profile admin $close :" . $profile['admin']);
                if($close == 1 && $profile['admin'] < 1) {
                    return redirect(base_url('items/index'));
                } 
            }
        }
        $group = $this->groups->get_my_list();
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
        foreach($gmember as &$s){
            $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                . '<span class="ui-icon ui-icon-trash  tdel" data-id="' . $s['id'] . '"></span></div>';
        }
        $this->bsload('groups/index',
            array(
                'title' => '公司部门'
                ,'group' => $ginfo
                ,'members' => $gmember
                ,'search' => urldecode($search)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/groups'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '公司部门', 'class' => '')
                ),
            )
        );
    }

    public function save(){
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $credit_card = $this->input->post('credit_card');
        $admin = $this->input->post('admin');
        $id = $this->input->post('id');
        $oper = $this->input->post('oper');

        if($oper == "edit"){
            die($this->groups->update_profile($nickname, $email, $phone, $credit_card, $admin, $id));
        }



    }

    public function listdata(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->groups->get_my_list();
        log_message("debug", "Group:" . json_encode($group));
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
        foreach($gmember as &$g){
            if($g['admin'] == 0){
                $g['admin'] = '员工';
            }
            elseif($g['admin'] == 1){
                $g['admin'] = '管理员';
            }
            elseif($g['admin'] == 2){
                $g['admin'] = '会计';
            }
        }
        die(json_encode($gmember));
    }

    public function invite() {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $name = $this->input->post('username');
        $info = $this->groups->set_invite($name);
        if($info && $info['status']) {
            $this->session->set_userdata('last_error', '邀请发送成功');
        } else {
            $this->session->set_userdata('last_error', '邀请发送失败');
        }
        redirect(base_url('groups'));
    }

    public function setadmin($uid = 0, $type = 0){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        //$ids = $this->input->post('data');

        if($type == 0){
            $type = 2; 
        } else {
            $type = 1; 
        }
        $_ids = implode(',', array($uid));
        //$_type = $this->input->post('type');
        $info = $this->groups->setadmin($_ids, $type);
        die($info);
    }

    public function create(){
        $name = $this->input->post('groupname');
        $info = $this->groups->create_group($name);
        if($info && $info['status']) {
            $this->session->set_userdata('last_error', '创建成功');
        } else {
            $this->session->set_userdata('last_error', '创建失败');
        }
        redirect(base_url('members'));
    }

    public function show_exports(){
        $this->load->model('items_model', 'items');
        $obj = $this->items->get_exports(2, 'tianyu.an@rushucloud.com');
        if($obj && $obj['status']){
            $data = $obj['data'];
        }
    }

    public function show() {
        $this->bsload('groups/show',
            array(
                'title' => '添加部门' 
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '添加部门', 'class' => '')
                ),
            )
        );
    }
    public function add() {
        $this->need_group_it();
        $group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = array();
        if($_gnames['status'] > 0 && array_key_exists('group',$_gnames['data']))
        {
            $gnames = $_gnames['data']['group'];
        }

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
        $this->bsload('groups/new',
            array(
                'title' => '添加部门',
                'member' => $gmember
                ,'group' => $gnames
                ,'ginfo' => $_gnames
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '添加部门', 'class' => '')
                ),
            )
        );
    }



    public function listtreegroup(){
        $group = $this->ug->get_my_list();
        /// 结构好奇怪啊
        //
        if($group['status']){
            $_data = array();
            //die(json_encode(array('data' => $group['data'])));
            foreach($group['data']['group'] as &$s){
                $s['type'] = 'item';
            }
            array_push($group['data']['group'], array('option' => '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="-1">' . '<span class="ui-icon ui-icon-pencil tedit" data-id="-1"></span>' . '<span class="ui-icon ui-icon-trash tdel" data-id="-1"></span></div>', 'name' => '已邀请', 'id' => "-1", 'type' => 'item'));
            //$group['data']['group'] = array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder');
            array_unshift($group['data']['group'], array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder'));
            $groups = $group['data']['group'];

            die(json_encode($groups));

            // die(json_encode($re));
        }
    }

    public function getgroups()
    {
        $group = $this->ug->get_my_list();
        /// 结构好奇怪啊
        //
        log_message("debug", "Get Groups:" . $group['status']);
        if($group['status']){
            $_data = array();
            foreach($group['data']['group'] as &$s){
                $s['type'] = 'item';
            }
            $groups = $group['data']['group'];
            $re = array();
            foreach($groups as &$g)
            {
                $temp = array();
                array_push($re, array('id' => $g['id'],'pid' => $g['pid'],'name'=>$g['name']));
            }
            log_message("debug", "Get Groups:" . json_encode($re));
            die(json_encode($re));
        }
    }

    public function listgroup(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->ug->get_my_list();
        /// 结构好奇怪啊
        //
        if($group['status']){
            $_data = array();
            //die(json_encode(array('data' => $group['data'])));
            foreach($group['data']['group'] as &$s){
                $s['type'] = 'item';
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ui-icon-trash tdel" data-id="' . $s['id'] . '"></span></div>';
            }
            /*
            array_push($group['data']['group'], array('option' => '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="-1">' . '<span class="ui-icon ui-icon-pencil tedit" data-id="-1"></span>' . '<span class="ui-icon ui-icon-trash tdel" data-id="-1"></span></div>', 'name' => '已邀请', 'id' => "-1"));
            //$group['data']['group'] = array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder');
            array_push($group['data']['group'], array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder'));
             */
            log_message('debug','groupscount:'.json_encode($group['data']['group']));
            die(json_encode($group['data']['group']));
        }
    }


    public function newmember(){
        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $_group = $this->groups->get_my_list();
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);

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
        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->bsload('members/new',
            array(
                'title' => '添加员工'
                ,'groups' => $group['data']
                ,'gmember' => $gmember
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '添加员工', 'class' => '')
                ),
            )
        );
    }

    public function docreate(){

        $renew = $this->input->post('renew');

        $email = $this->input->post('email');
        $nickname = $this->input->post('nickname');
        $phone = $this->input->post('mobile');
        $groups = $this->input->post('groups');
        $_manager = $this->input->post('manager');
        $manager = array();
        if($_manager) {
            $manager = explode(',',$_manager);
        }

        // 银行信息
        $cardloc = $this->input->post('cardloc');
        $cardno = $this->input->post('cardno');
        $cardbank = $this->input->post('cardbank');
        $account = $this->input->post('account');

        $rank = $this->input->post('rank');
        //       $rank_name = $this->input->post('rank_name');
        $level = $this->input->post('level');
        //        $level_name = $this->input->post('level_name');

        $admin = $this->input->post('admin');
        $renew = $this->input->post('renew');
        $locid = $this->input->post('locid');
        if($phone == $email && $email == ""){
            die(json_encode(array('status' => false, 'id' => $id, 'msg' => '邮箱手机必须有一个')));
        }
        $data = array();
        $_groups = '';
        if($groups)
        {
            $_groups = $groups;
        }
        $gids = array();
        array_push($gids,$_groups);
        $data['gids'] = '';
        if($gids)
        {
            $data['gids'] = implode(',',$gids);
        }
        $data['id'] = $locid;
        $data['nickname'] = $nickname;
        $data['email'] = trim($email);
        $data['phone'] = $phone;
        $data['account'] = $account;
        $data['cardno'] = $cardno;
        $data['bank'] = $cardbank;
        $data['rank'] = $rank;
        $data['level'] = $level;
        $data['manager'] = '';
        $data['manager_id'] = 0;
        $data['display_manager_id'] = 0;
        if(count($manager) == 2)
        {
            $data['manager_id'] = $manager[0];
            $data['manager'] = $manager[1]; 
        }
        $data['cardloc'] = $cardloc;
        $input = array();
        array_push($input,base64_encode(json_encode($data)));

        $info = $this->groups->reim_imports(array('members'=>json_encode($input)));
        //$info = $this->groups->doimports($email, $nickname, $phone, $admin, $groups, $account, $cardno, $cardbank, $cardloc , $manager, $rank, $level);
        if($info['status']) {
            $key = $email . "|" . $phone;
            if (array_key_exists($key, $info["data"])) {
                $this->session->set_userdata("last_error", $info["data"][$key]["status_text"]);
            } else {
                $this->session->set_userdata('last_error', '添加成功');
            }
        } else {
            $this->session->set_userdata('last_error', '添加失败');
            return redirect(base_url('members/newmember'));
        }
        
        if($renew == 0)
        {
            return redirect(base_url('members/index'));
        }
        return redirect(base_url('members/newmember'));

        //print_r($info);
        //$this->groups->set_invite($email, $nickname, $phone, $credit, $groups);
        //die(json_encode(array('status' => true, 'id' => $id)));
    }

    public function batch_del(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $this->bsload('members/batch_del',
            array(
                'title' => '批量删除员工',
                'error' => $error,
                'groups' => $group['data']
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '批量删除员工', 'class' => '')
                ),
            )
        );
    }
    public function export(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $this->bsload('members/exports',
            array(
                'title' => '导入/导出员工',
                'error' => $error,
                'groups' => $group['data']
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '导入/导出员工', 'class' => '')
                ),
            )
        );
    }

    public function exports(){
        $this->need_group_it();
        $group = $this->groups->get_my_list();
        $ranks = array();
        $levels = array();
        $ranks_dic = array();
        $levels_dic = array();
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);
        $ginfo = array();
        $gmember = array();
        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }
        if($_levels['status'] > 0)
        {
            $levels = $_levels['data'];
        }

        foreach($ranks as $r)
        {
            $ranks_dic[$r['id']] = $r['name'];
        }
        foreach($levels as $l)
        {
            $levels_dic[$l['id']] = $l['name'];
        }

        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();

        }
        $data = array();
        log_message("debug","######".json_encode($gmember));
        foreach($gmember as $m){
            $obj = array();
            if(array_key_exists('client_id',$m))
            {
                $obj['ID'] = $m['client_id'];
            }
            if(array_key_exists('nickname',$m))
            {
                $obj['姓名'] = $m['nickname'];
            }
            if(array_key_exists('email',$m))
            {
                $obj['邮箱'] = $m['email'];
            }
            if(array_key_exists('phone',$m))
            {
                $obj['手机号'] = $m['phone'];
            }
            if(array_key_exists('cardno',$m))
            {
                $obj['银行卡号'] = $m['cardno'];
            }
            if(array_key_exists('bankname',$m))
            {
                $obj['开户行'] = $m['bankname'];
            }
            if(array_key_exists('d',$m))
            {
                $obj['部门'] = $m['d'];
            }
            if(array_key_exists('manager',$m))
            {
                $obj['上级姓名'] = '';
                if('没有上级' != $m['manager'])
                {
                    $obj['上级姓名'] = $m['manager'];
                }
            }
            if(array_key_exists('rank_id',$m) && $m['rank_id'] > 0 && array_key_exists($m['rank_id'],$ranks_dic))
            {
                $obj['职级'] = $ranks_dic[$m['rank_id']];
            }
            else
            {
                $obj['职级'] = '';
            }

            if(array_key_exists('level_id',$m) && $m['level_id'] > 0 && array_key_exists($m['level_id'],$levels_dic))
            {
                $obj['职位'] = $levels_dic[$m['level_id']];
            }
            else
            {
                $obj['职位'] = '';
            }
            array_push($data, $obj);
        }
        $this->render_to_download('人员', $data, 'members.xls');
    }


    public function batch_delete_members(){
        if(!array_key_exists('del_members', $_FILES)){
            redirect(base_url('members'));
        }
        $tmp_file = $_FILES['del_members']['tmp_name'];

        try {
            $reader = IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($tmp_file);
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        } catch(Exception $e) {
            $this->session->set_userdata('last_error', '暂不支持当前的文件类型');
            return redirect(base_url('members/batch_del'));
        }

        $data = Array();
        /** 循环读取每个单元格的数据 */
        for ($row = 4; $row <= $highestRow; $row++){//行数是以第1行开始
            $obj = array();
            $obj['id'] = trim($sheet->getCellByColumnAndRow(0, $row)->getValue());
            $obj['nickname'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $obj['email'] = trim($sheet->getCellByColumnAndRow(2, $row)->getValue());
            $obj['phone'] = trim($sheet->getCellByColumnAndRow(3, $row)->getValue());

            if($obj['email'] != '' || $obj['phone'] != '')
                array_push($data,$obj);
        }

        log_message('debug','data:' . json_encode($data));
        log_message('debug','highestRow:' . $highestRow);
        $this->bsload('members/batch_delete_members',
            array(
                'title' => '确认导入',
                'members' => $data
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => base_url('members/export'), 'name' => '导入/导出员工', 'class' => '')
                    ,array('url'  => '', 'name' => '确认导入', 'class' => '')
                ),
            )
        );
    }

    public function imports(){
        if(!array_key_exists('members', $_FILES)){
            redirect(base_url('members'));
        }
        $tmp_file = $_FILES['members']['tmp_name'];

        try {
            $reader = IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($tmp_file);
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        } catch(Exception $e) {
            $this->session->set_userdata('last_error', '暂不支持当前的文件类型');
            return redirect(base_url('members/export'));
        }
        //$highestColumm= PHPExcel_Cell::columnIndexFromString(); //字母列转换为数字列 如:AA变为27
        $group = $this->groups->get_my_list();
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
        $_emails = array();
        $_phones = array();
        $_names = array();
        $names = array();
        $email_id_matrix = array();
        foreach($gmember as $g){

            $__email = $g['email']; 
            $__phone = $g['phone']; 
            $__name = $g['nickname'];
            if(!in_array($__name,$_names))
            {
                $names[$__name]['count'] = 1;		
                $names[$__name]['ids']=array();
                array_push($names[$__name]['ids'],$g['id']);	
            }
            else
            {
                $names[$__name]['count'] += 1;
                array_push($names[$__name]['ids'],$g['id']);
            }
            if($__email) {
                array_push($_emails, $__email);
                $email_id_matrix[$g['email']] = $g['id'];
            }
            if($__phone)
                array_push($_phones, $__phone);
            if($__name)
                array_push($_names,$__name);
        }

        $data = array();
        /** 循环读取每个单元格的数据 */
        for ($row = 4; $row <= $highestRow; $row++){//行数是以第1行开始
            $obj = Array();
            $obj['id'] = trim($sheet->getCellByColumnAndRow(0, $row)->getValue());
            $obj['name'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $obj['nickname'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $obj['email'] = trim($sheet->getCellByColumnAndRow(2, $row)->getValue());
            $obj['phone'] = trim($sheet->getCellByColumnAndRow(3, $row)->getValue());
            $obj['accounts'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue()); ;
            $obj['account'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue()); ;
            $obj['cardno'] = trim($sheet->getCellByColumnAndRow(4, $row)->getValue());
            $obj['cardbank'] = trim($sheet->getCellByColumnAndRow(5, $row)->getValue());
            $obj['bank'] = trim($sheet->getCellByColumnAndRow(5, $row)->getValue());
            log_message('debug','alvayang cardno XXX:' . $sheet->getCellByColumnAndRow(4, $row)->getValue());
            if(strlen($obj['cardno']) >= 128) {
                $obj['cardno'] = substr($obj['cardno'],0,128);
                log_message('debug','len:' . strlen($obj['cardno']));
            }
            if(is_numeric($obj['cardno']) && substr($obj['cardno'],0,1)!=0) {
                if(preg_match("/^([0-9]+(\.[0-9]+)?[e,E]\+[0-9]+)$/",$obj['cardno'])) {
                    $obj['cardno'] = number_format((double)$obj['cardno'],0,'','');
                    log_message('debug' , 'sc_num:' . $obj['cardno']);
                }
            }
            else if(!$obj['cardno']) {
                $obj['cardno'] = '';
                $obj['accounts'] = '';
                $obj['account'] = '';
                $obj['cardbank'] = '';
                $obj['bank'] = '';	
            }
            $obj['cardloc'] = '';
            $obj['group_name'] = trim($sheet->getCellByColumnAndRow(6, $row)->getValue());
            $obj['gids'] = trim($sheet->getCellByColumnAndRow(6, $row)->getValue());
            $obj['display_manager'] = trim($sheet->getCellByColumnAndRow(7, $row)->getValue());
            $obj['manager'] = trim($sheet->getCellByColumnAndRow(7, $row)->getValue());
            $obj['rank'] = trim($sheet->getCellByColumnAndRow(10, $row)->getValue());
            $obj['level'] = trim($sheet->getCellByColumnAndRow(11, $row)->getValue());
            $obj['manager_id'] = "";/*trim($sheet->getCellByColumnAndRow(8, $row)->getValue());*/
            $obj['manager_email'] = trim($sheet->getCellByColumnAndRow(12, $row)->getValue());
            $obj['display_manager_email'] = trim($sheet->getCellByColumnAndRow(9, $row)->getValue());
            $obj['second'] = trim($sheet->getCellByColumnAndRow(13, $row)->getValue());
            $obj['third'] = trim($sheet->getCellByColumnAndRow(14, $row)->getValue());
            $obj['fourth'] = trim($sheet->getCellByColumnAndRow(15, $row)->getValue());
            $obj['fifth'] = trim($sheet->getCellByColumnAndRow(16, $row)->getValue());
            $obj['display_manager_id'] = "";
            if($obj['email']) {
                $email_id_matrix[$obj['email']] = $obj['id'];
            }
            /*
            $obj['level'] = trim($sheet->getCellByColumnAndRow(8, $row)->getValue());
            $obj['rank'] = trim($sheet->getCellByColumnAndRow(9, $row)->getValue());
             */
            if("" == $obj['email'] && "" == $obj['phone'] && "" == $obj['name']) continue;
            $obj['status'] = 0;
            if(in_array($obj['email'], $_emails)){
                $obj['status'] = 1;
            }
            if (in_array($obj['phone'], $_phones)) {
                $obj['status'] = 1;
            }
            log_message('debug','obj_name' . $obj['name']);
            array_push($data, $obj);
            log_message('debug','objXXXXXXXXXXXXXX:' . json_encode($obj));
        }
        $_ranks = $this->reim_show->rank_level(1);
        $ranks = array();
        $_levels = $this->reim_show->rank_level(0);
        $levels = array();
        if($_ranks['status']>0)
        {
            $ranks = $_ranks['data'];
        }
        if($_levels['status']>0)
        {
            $levels = $_levels['data'];
        }

        $ranks_dic = array();
        foreach($ranks as $r)
        {
            $ranks_dic[$r['name']] = $r['id'];
        }


        $levels_dic = array();
        foreach($levels as $l)
        {
            $levels_dic[$l['name']] = $l['id'];
        }
        $ug = array();
        $_ug = $this->ug->get_my_list();
        if($_ug['status'] > 0)
        {
            $ug = $_ug['data']['group'];
        }

        $ug_dic = array();

        foreach($ug as $u) {
            if(array_key_exists($u['name'],$ug_dic))
            {
                array_push($ug_dic[$u['name']],$u['id']);
            }
            else
            {
                $ug_dic[$u['name']] = [$u['id']];
            }
        }


        log_message('debug','name:' . json_encode($names));
        $no_ranks = array();
        $no_levels = array();
        $no_groups = array();
        log_message("debug", "Matrix:" . json_encode($email_id_matrix));
        foreach($data as &$d)
        {
            $_e = $d['manager_email'];
            $_de = $d['display_manager_email'];
            $_i = $d['manager_id'];
            log_message("debug", "Check Exists:" . json_encode($_e));
            log_message("debug", "Check Exists:" . json_encode($_de));
            log_message("debug", "Check Exists:" . json_encode($d));
            
            if(array_key_exists($_de,$email_id_matrix))
            {
                $d['display_manager_id'] = $email_id_matrix[$_de];
            }
            else
            {
                $d['status'] += 4;
            }

            if(array_key_exists($_e, $email_id_matrix)){
                $d['status'] += 0;	
                $d['manager_id'] = $email_id_matrix[$_e];
            } else {
                $d['status'] += 4;	
            }
            //log_message('debug','isEq:' . in_array($d['name'],$_names));

            $d['rank_id'] = 0;
            if($d['rank'])
            {
                if(array_key_exists($d['rank'],$ranks_dic))
                {
                    $d['rank_id'] = $ranks_dic[$d['rank']];
                }
                else
                {
                    if(!in_array($d['rank'],$no_ranks))
                        array_push($no_ranks,$d['rank']);
                }
            }
            $d['level_id'] = 0;
            if($d['level'])
            {
                if(array_key_exists($d['level'],$levels_dic))
                {
                    $d['level_id'] = $levels_dic[$d['level']];
                }
                else
                {
                    if(!in_array($d['level'],$no_levels))
                        array_push($no_levels,$d['level']);
                }
            }
            $groups = array();
            $d['gid'] = 0;
            if($d['group_name'])
            {
                if(array_key_exists($d['group_name'],$ug_dic))
                {
                    $d['gid'] = $ug_dic[$d['group_name']][0];
                }
                else
                {
                    if(!in_array($d['group_name'],$no_groups))
                        array_push($no_groups,$d['group_name']);
                }
            }
        }

        log_message('debug','alvayang data:' . json_encode($data));
        log_message('debug','rank_dic:' . json_encode($ranks_dic));
        log_message('debug','level_dic:' . json_encode($levels_dic));
        log_message('debug','ug_dic:' . json_encode($ug_dic));
        log_message('debug','no_ranks:' . json_encode($no_ranks));
        log_message('debug','no_levels:' . json_encode($no_levels));
        log_message('debug','no_groups:' . json_encode($no_groups));

        $this->bsload('members/imports',
            array(
                'title' => '确认导入',
                'members' => $data
                ,'no_ranks' => $no_ranks
                ,'no_levels' => $no_levels
                ,'no_groups' => $no_groups
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => base_url('members/export'), 'name' => '导入/导出员工', 'class' => '')
                    ,array('url'  => '', 'name' => '确认导入', 'class' => '')
                ),
            )
        );
    }

    public function import_single(){
        $member = $this->input->post('member');
        $id = $this->input->post('id');
        if(!$member) die(json_encode(array('status' => false, 'id' => $id, 'msg' => '参数错误')));
        $obj = json_decode(base64_decode($member), True);
        log_message('debug','obj:' . json_encode($obj));

        $data = array();
        $data['email'] = $obj['email'];
        $data['display_manager_id'] = $obj['display_manager_id'];
        $data['nickname'] = $obj['name'];
        $data['phone'] = $obj['phone'];
        $data['account'] = $obj['accounts'];
        $data['cardloc'] = $obj['cardloc'];
        $data['cardbank'] = $obj['cardbank'];
        $data['cardno'] = $obj['cardno'];
        $data['localid'] = $obj['id'];
        $group_name = $obj['group_name'];
        $data['manager_id'] = $obj['manager_id'];
        $data['rank'] = $obj['rank_id'];
        $data['level'] = $obj['level_id'];

        if(!$data['localid'])
        {
            $data['localid'] = 0;
        }
        if($data['phone'] == $data['email'] && $data['email'] == ""){
            die(json_encode(array('status' => false, 'id' => $id, 'msg' => '邮箱手机必须有一个')));
        }
        log_message('debug','data:' . json_encode($data));
        $info = $this->groups->reim_imports($data);
        die(json_encode(array('status' => true, 'id' => $id)));
    /*
    if($info['status']>0)
    {
        die(json_encode(array('msg' => '导入成功')));
    }
    else
    {
        die(json_encode(array('msg' => '导入失败')));
    }
        $info = $this->groups->doimports($email, $nickname, $phone, 0, '', $account, $cardno, $cardbank, $cardloc);
        die(json_encode(array('status' => true, 'id' => $id)));
     */
    }

    public function delgroup($id = 0){
        if($id == 0) redirect(base_url('members/groups'));
        $this->ug->delete_group($id);
        //        redirect(base_url('members/groups'));
        redirect(base_url('members/groups'));

    }

    public function singlegroup($gid = 0) {
        if(0 == $gid) {
            die(json_encode(array('status' => false, 'msg' => '参数错误')));
        }
        if(-2 == $gid){
            $group = $this->groups->get_my_list();
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
            die(json_encode(array('status' => 1, 'data' => $gmember)));
        }
        $info = $this->ug->get_single_group($gid);
        die($info);
    }

    public function editgroup($id = 0){
        if($id == 0) redirect(base_url('members/groups'));
        $group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = $_gnames['data']['group'];
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
        $info = json_decode($this->ug->get_single_group($id), True);
        if($info['status'] > 0){
            $info = $info['data'];
            $group = $info['group'];
            $member = $info['member'];
            $mid = array();
            foreach($member as $m){
                array_push($mid, $m['id']);
            }
            $this->bsload('members/edit_group',
                array(
                    'title' => '修改部门'
                    ,'gnames' => $gnames
                    ,'smember' => $mid
                    ,'group' => $group
                    ,'member' => $gmember
                    ,'pid' => $group['pid']
                    ,'manager' => $group['manager']
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('members/groups'), 'name' => '公司部门', 'class' => '')
                        ,array('url'  => '', 'name' => '修改部门', 'class' => '')
                    ),
                )
            );
        }
        /*
        $this->groups->delete_group($id);
        redirect(base_url('members/groups'));
         */
    }


    public function updategroup(){
        $manager = $this->input->post('manager');
        $name = $this->input->post('gname');
        $code = $this->input->post('gcode');
        $uids = $this->input->post('uids');
        $pid = $this->input->post('pgroup');
        $gid = $this->input->post('gid');
        $images = '';
        $_images = $this->input->post('images');
        if($_images)
        {
            $images = $_images;
        }
        if($uids)
        {
            $uids = implode(",", $uids);
        }
        else
        {
            $uids='';
        }
        $info = $this->ug->update_data($manager,$uids, $name,$code,$pid,$gid,$images);
        log_message("debug","@@@@@@@@@".json_encode($info));
        if($info['status'] > 0){
            redirect(base_url('members/groups'));
            //redirect(base_url('members/index'));
        }
    }


    public function editmember($id = 0){
        if($id == 0) {
            redirect(base_url('members/index'));
            exit();
        }
        //$profile = $this->user->reim_get_user($id);
        $last_error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $error = $this->session->userdata('login_error');
        $this->session->unset_userdata('login_error');

        $_ranks = $this->groups->get_rank_level(1);
        $_levels = $this->groups->get_rank_level(0);
        $ranks = array();
        $levels = array();

        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }

        if($_levels['status'])
        {
            $levels = $_levels['data'];
        }

        $info = json_decode($this->users->reim_get_info($id), True);
        if(!$info['status']) return redirect('members/index');
        $info =  $info['data'];
        $manager_id = $info['manager_id'];
        $m_info = json_decode($this->users->reim_get_info($manager_id),True);
        $pro = $info;
        $ug = $this->reim_show->usergroups();
        //log_message('debug','m_info:' . json_encode($m_info['data']));

        $group = $this->groups->get_my_list();

        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        log_message('debug','@@@@manger_id:'.$manager_id);

        //print_r($info);
        $this->bsload('user/profile',
            array(
                'title' => '修改资料'
                ,'member' => $info
                ,'self' => 0
                ,'error' => $error 
                ,'last_error' => $last_error
                ,'isOther' => 1
                ,'avatar_path' => $path
                ,'gmember' => $gmember
                ,'manager_id' => $manager_id
                ,'pid' => $id
                ,'pro' => $pro
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'ug' => $ug
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '修改资料', 'class' => '')
                ),
            )
        );
    }

    public function remove_member($id = 0){
        if($id == 0) return redirect(base_url('members/index'));
        $this->groups->remove_user($id);
        return redirect(base_url('members/index'));

    }

    public function batch_load(){
        $member = $this->input->post('member');
        $quiet = $this->input->post('quiet');
        log_message("debug", "Member:" . json_encode($member));
        $info = $this->groups->reim_imports(array('quiet' => $quiet,'members' => json_encode($member)));
        /*
        $data = array();
        if($info['status'] > 0)
        {
            $data = $info['data'];	
        }
        log_message('debug','batch_load:' . json_encode($info));
        //        die(json_encode(array('msg'=>"it works")));
        //        */
        die(json_encode(array('data' => $info)));
    }

    public function excute_batch_del()
    {
        $member = $this->input->post('members');
        $info = $this->groups->batch_del($member);

        $data = array();
        if($info && $info['status'] > 0)
        {
            $data = $info['data'];
        }

        die(json_encode($data));
    }
}


