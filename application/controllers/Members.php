<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('user_model', 'users');
        $this->load->model('group_model', 'groups');
        $this->load->model('reim_show_model','reim_show');
        $this->load->model('company_model','com');
    }
    
    public function editcompany(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $profile = $this->session->userdata('profile');
        $groups = $profile['group'];
        $info = $this->com->get_data()['data'];
        $this->bsload('members/editcompany',
            array(
                'title' => '编辑公司'
                ,'error' => $error
                ,'name' => $info['group_name']
                ,'image' => $info['logo_id']
                ,'image_url' => $info['logo_url']
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '组织结构', 'class' => '')
                    ,array('url'  => '', 'name' => '编辑公司', 'class' => '')
                )
            )
        );
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
                'title' => '职位&级别设置'
                ,'levels' => $levels
                ,'ranks' => $ranks
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/groups'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '职位&级别设置', 'class' => '')
                ),
            )
        );
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
            $error = $this->session->userdata('last_error');
            $this->session->unset_userdata('last_error');
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
        $this->session->unset_userdata('last_error');
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
                ,'error' => $error
                ,'search' => urldecode($search)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/groups'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '公司部门', 'class' => '')
                ),
            )
        );
    }

    public function add() {
        $this->need_group_agent();
        $_gnames = $this->ug->get_my_list();
        $gnames = array();
        $gmember = array();
        if($_gnames['status'] > 0)
        {
            if(array_key_exists('group',$_gnames['data']))
            {
                $gnames = $_gnames['data']['group'];
            }
            if(array_key_exists('member',$_gnames['data']))
            {
                $gmember = $_gnames['data']['member'];
            }
        }

        $this->bsload('groups/new',
            array(
                'title' => '添加部门',
                'member' => $gmember,
                'group' => $gnames,
                'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon'),
                    array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => ''),
                    array('url'  => '', 'name' => '添加部门', 'class' => '')
                ),
            )
        );
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
        assert ($group['status']);
        $profile = $this->session->userdata('profile');
        $admin_groups_granted = array();
        if(array_key_exists('admin_groups_granted_all',$profile) && $profile['admin_groups_granted_all'])
        {
            $admin_groups_granted = $profile['admin_groups_granted_all'];
        }
        $_data = array();
        foreach($group['data']['group'] as &$s){
            $editable = 0;
            if(in_array($profile['admin'],[1,3]))
            {
                $editable = 1;
            }
            if(!$editable && in_array($s['id'],$admin_groups_granted))
            {
                $editable = 1;
            }
            $s['type'] = 'item';
            $s['options'] = '';
            if($editable)
            {
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon-pencil tedit" data-id="' . $s['id'] . '"></span>'
                    . '<span class="ui-icon ui-icon-trash tdel" data-id="' . $s['id'] . '"></span></div>';
            }
        }
        log_message('debug','groupscount:'.json_encode($group['data']['group']));
        log_message('debug','groups_granted:'.json_encode($admin_groups_granted));
        die(json_encode($group['data']['group']));
    }

    public function newmember($gid = '0'){
        $this->need_group_agent();
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
        $groupName = '';
        if ($gid != '0') {
            foreach ($group['data']['group'] as $g) {
                if ($g['id'] == $gid) {
                    $groupName = $g['name'];
                    break;
                }
            }
        }
        $this->bsload('members/new',
            array(
                'title' => '添加员工'
                ,'groupName' => $groupName
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
        log_message("info", "######".json_encode($gmember));
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
            
            if(array_key_exists('rank_id',$m) && $m['rank_id'] > 0 && array_key_exists($m['rank_id'],$ranks_dic))
            {
                $obj['职级'] = $ranks_dic[$m['rank_id']];
            } else {
                $obj['职级'] = '';
            }

            if(array_key_exists('level_id',$m) && $m['level_id'] > 0 && array_key_exists($m['level_id'],$levels_dic))
            {
                $obj['职位'] = $levels_dic[$m['level_id']];
            } else {
                $obj['职位'] = '';
            }

            if(array_key_exists('manager',$m))
            {
                $obj['默认审批人邮箱或手机'] = '';
                if('没有上级' != $m['manager'])
                {
                    $obj['默认审批人邮箱或手机'] = $m['manager'];
                }
            }

            $obj['二级审批人邮箱或手机'] = '';
            $obj['三级审批人邮箱或手机'] = '';

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
            $reader = PHPExcel_IOFactory::createReader('Excel5');
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

    public function imports()
    {
        if(!array_key_exists('members', $_FILES)){
            redirect(base_url('members'));
        }

        $tmp_file = $_FILES['members']['tmp_name'];

        try {
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($tmp_file);
            $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        } catch(Exception $e) {
            $this->session->set_userdata('last_error', '暂不支持当前的文件类型');
            return redirect(base_url('members/export'));
        }

        // 读取数据
        $data = array();
        $index = 0;
        $m = array(
            'id',
            'nickname',
            'email',
            'phone',
            'cardno',
            'bank',
            'gids',
            'level',
            'rank',
            'manager_id',
            'manager_id_2',
            'manager_id_3'
        );
        for ($row = 3; $row <= $highestRow; $row++) { //行数是以第1行开始
            $index++;
            $obj = Array();
            foreach ($m as $index => $value) {
                $obj[$value] =  trim($sheet->getCellByColumnAndRow($index, $row)->getValue()); 
            }
            array_push($data, $obj);
        }
        $ranks = $this->groups->get_rank_level(1);
        $ranks = $ranks['data'];

        $levels = $this->groups->get_rank_level(0);
        $levels = $levels['data'];

        $profile = $this->session->userdata('profile');
        $groups = $profile['usergroups'];

        $this->bsload('members/imports_stash',
            array(
                'title' => '确认导入',
                'locale_file_members'=>$data,
                'server_members' => $this->groups->get_my_list(),
                'ranks' => $ranks,
                'groups' => $groups,
                'levels' => $levels,
                // 'no_groups' => $no_groups,
                'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon'),
                    array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => ''),
                    array('url'  => base_url('members/export'), 'name' => '导入/导出员工', 'class' => ''),
                    array('url'  => '', 'name' => '确认导入', 'class' => '')
                ),
            )
        );
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
        die(json_encode($info));
    }

    public function editgroup($id = 0){
        if($id == 0) redirect(base_url('members/groups'));
        $_gnames = $this->ug->get_my_list();
        $gmembers = array();
        if($_gnames['status'] > 0)
        {
            if(array_key_exists('group',$_gnames['data']))
            {
                $gnames = $_gnames['data']['group'];
            }
            if(array_key_exists('member',$_gnames['data']))
            {
                $gmembers = $_gnames['data']['member'];
            }
        }

        $info = $this->ug->get_single_group($id);
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
                    ,'pid' => $group['pid']
                    ,'member' => $gmembers
                    ,'manager' => $group['manager']
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('members/groups'), 'name' => '公司部门', 'class' => '')
                        ,array('url'  => '', 'name' => '修改部门', 'class' => '')
                    ),
                )
            );
        }
    }


    public function updategroup(){
        $profile = $this->session->userdata('profile');
        $manager = $this->input->post('manager');
        $name = $this->input->post('gname');
        $code = $this->input->post('gcode');
        $uids = '';
        $_uids = $this->input->post('uids');
        $pid = '';
        $_pid = $this->input->post('pgroup');
        $gid = $this->input->post('gid');
        $images = '';
        $_images = $this->input->post('images');
        if($_images)
        {
            $images = $_images;
        }

        if($_uids)
        {
            $uids = implode(',',$_uids);
        }

        if($_pid)
        {
            $pid = $_pid;
        }
        $info = $this->ug->update_data($manager,$uids, $name,$code,$pid,$gid,$images);
        log_message("debug","@@@@@@@@@".json_encode($info));
        if($info['status'] > 0){
            $this->session->set_userdata('last_error','修改成功');
        }
        else
        {
            $this->session->set_userdata('last_error',$info['data']['msg']);
        }
        redirect(base_url('members/index'));
    }

    // 管理员修改密码，自己修改自己的密码需要验证码，否则不需要
    // 1. 如何判断是管理员 admin = 1
    // 2. 如何判断是自己 userid = edit_user_id
    public function editmember($id = 0){
        if($id == 0) {
            redirect(base_url('members/index'));
            exit();
        }

        $profile = $this->session->userdata('profile');

        $last_error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
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

        if($_levels['status'])
        {
            $levels = $_levels['data'];
        }

        $info = $this->users->reim_get_info($id);
        if(!$info['status']) return redirect('members/index');
        $info =  $info['data'];
        $manager_id = $info['manager_id'];
        $m_info = $this->users->reim_get_info($manager_id);
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

        $this->bsload('user/profile',
            array(
                'title' => '修改资料'
                ,'member' => $info
                ,'self' => 0
                , 'user_type' => $profile['admin']
                , 'uid' => $profile['id']
                , 'self'=> $profile['id'] == $id
                ,'error' => $error
                ,'last_error' => $last_error
                ,'isOther' => 1
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


