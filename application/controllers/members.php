<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('user_model', 'users');
        $this->load->model('group_model', 'groups');
        $this->load->model('reim_show_model','reim_show');
    }

    public function remove_from_group($gid,$uid)
    {
        $group = json_decode($this->ug->get_single_group($gid),True);
        if($group['status'] > 0)
        {
            $data = $group['data'];		
        }
        else
        {
            $this->session->set_userdata('last_error','部门信息获取错误');
            return redirect(base_url('members/index'));
        }

        $members = array();
        $g_info = array();
        if(array_key_exists('member',$data))
        {
            $members = $data['member'];	
        }	
        if(array_key_exists('group',$data))
        {
            $g_info = $data['group'];
        }
        else
        {
            $this->session->set_userdata('last_error','部门信息获取错误');
            return redirect(base_url('members/index'));
        }
        $uids = array();
        foreach($members as $item)
        {
            if($item['id'] != $uid)
            {
                array_push($uids,$item['id']);
            }
        }

        $manager = $g_info['manager'];
        $name = $g_info['name'];
        $code = $g_info['code'];
        $pid = $g_info['pid'];

        if($uids)
        {
            $uids = implode(',',$uids);
        }
        else
        {
            $uids = '';
        }
        $buf = $this->ug->update_data($manager,$uids, $name,$code,$pid,$gid);

        if($buf['status']>0)
        {
            $this->session->set_userdata('last_error','移除成功');
            return redirect(base_url('members/index'));
        }
        else
        {
            $this->session->set_userdata('last_error','移除失败');
            return redirect(base_url('members/index'));
        }

    }

    public function search() {
        $key = $this->input->get('key');
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
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
        $this->bsload('members/index',
            array(
                'title' => '组织结构'
                ,'group' => $ginfo
                ,'members' => $gmember
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
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        if($error == '')
        {
            $error = $this->session->userdata('login_error');
            $this->session->unset_userdata('login_error');
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
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
                    ,array('url'  => '', 'name' => '组织结构', 'class' => '')
                ), 'search' => ''
            )
        );
    }


    public function groups(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
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
        $single = $this->ug->get_single_group(18);
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
        $this->bsload('groups/new',
            array(
                'title' => '添加部门',
                'member' => $gmember
                ,'group' => $gnames
                ,'ginfo' => $_gnames
                ,'info' => $single
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
            array_push($group['data']['group'], array('option' => '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="-1">' . '<span class="ui-icon ui-icon-pencil tedit" data-id="-1"></span>' . '<span class="ui-icon ui-icon-trash tdel" data-id="-1"></span></div>', 'name' => '已邀请', 'id' => "-1"));
            //$group['data']['group'] = array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder');
            array_push($group['data']['group'], array('name' => '全体员工', 'id' => "-2", "additionalParameters" => array('children' => $group['data']['group']), 'type' => 'folder'));
            die(json_encode($group['data']['group']));
        }
    }


    public function newmember(){
        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $_group = $this->groups->get_my_list();
        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->bsload('members/new',
            array(
                'title' => '添加员工',
                'groups' => $group['data'],
                'gmember' => $gmember
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
        $manager = $this->input->post('manager');

        // 银行信息
        $cardloc = $this->input->post('cardloc');
        $cardno = $this->input->post('cardno');
        $cardbank = $this->input->post('cardbank');
        $account = $this->input->post('account');


        $admin = $this->input->post('admin');
        $renew = $this->input->post('renew');
        if($phone == $email && $email == ""){
            die(json_encode(array('status' => false, 'id' => $id, 'msg' => '邮箱手机必须有一个')));
        }
        $info = $this->groups->doimports($email, $nickname, $phone, $admin, $groups, $account, $cardno, $cardbank, $cardloc , $manager);
        log_message("debug","manager".$manager);
        if($info['status']) {
            $this->session->set_userdata('last_error', '添加成功');
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

    public function export(){
        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $this->bsload('members/exports',
            array(
                'title' => '导入/导出员工',
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
        $data = array();
        log_message("debug","######".json_encode($gmember));
        foreach($gmember as $m){
            $obj = array();
            if(array_key_exists('nickname',$m))
            {
                $obj['昵称'] = $m['nickname'];
            }
            if(array_key_exists('email',$m))
            {
                $obj['邮箱'] = $m['email'];
            }
            if(array_key_exists('phone',$m))
            {
                $obj['手机号'] = $m['phone'];
            }
            if(array_key_exists('credit_card',$m))
            {
                $obj['银行卡号'] = $m['credit_card'];
            }
            array_push($data, $obj);
        }
        $this->render_to_download('人员', $data, '员工信息.xls');
    }


    public function imports(){
        if(!array_key_exists('members', $_FILES)){
            redirect(base_url('members'));
        }
        $tmp_file = $_FILES['members']['tmp_name'];

        $reader = IOFactory::createReader('Excel5');
        $PHPExcel = $reader->load($tmp_file);
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
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
        foreach($gmember as $g){
            $__email = $g['email']; 
            $__phone = $g['phone']; 
            $__name = $g['nickname'];
            if(!array_key_exists($__name,$_names))
            {
                $names[$__name]['count'] = 1;		
                $names[$__name]['ids']=[$g['id']];
            }
            else
            {
                $names[$__name]['count'] += 1;
                array_push($names[$__name]['ids'],$g['id']);
            }
            if($__email)
                array_push($_emails, $__email);
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
            $obj['accounts'] = trim($sheet->getCellByColumnAndRow(4, $row)->getValue());
            $obj['account'] = trim($sheet->getCellByColumnAndRow(4, $row)->getValue());
            $obj['cardno'] = trim($sheet->getCellByColumnAndRow(5, $row)->getValue());
            $obj['cardbank'] = trim($sheet->getCellByColumnAndRow(6, $row)->getValue());
            $obj['bank'] = trim($sheet->getCellByColumnAndRow(6, $row)->getValue());
            $obj['cardloc'] = trim($sheet->getCellByColumnAndRow(7, $row)->getValue());
            $obj['group_name'] = trim($sheet->getCellByColumnAndRow(8, $row)->getValue());
            $obj['gids'] = trim($sheet->getCellByColumnAndRow(8, $row)->getValue());
            $obj['manager'] = trim($sheet->getCellByColumnAndRow(9, $row)->getValue());
            $obj['rank'] = trim($sheet->getCellByColumnAndRow(10, $row)->getValue());
            $obj['level'] = trim($sheet->getCellByColumnAndRow(11, $row)->getValue());
            if("" == $obj['email'] && "" == $obj['phone']) continue;
            $obj['status'] = 0;
            if(in_array($obj['email'], $_emails) || in_array($obj['phone'], $_phones)){
                $obj['status'] = 1;
            }
            log_message('debug','obj_name' . $obj['name']);
            if(!in_array($obj['name'],$_names))
            {
                $names[$obj['name']]['count'] = 1;
            }
            else
            {
                $names[$obj['name']]['count'] += 1;
            }
            array_push($_names,$obj['name']);
            array_push($data, $obj);
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

        foreach($ug as $u)
        {
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
        foreach($data as &$d)
        {
            log_message('debug','isEq:' . in_array($d['name'],$_names));
            if(in_array($d['manager'],$_names))
            {
                if($names[$d['manager']]['count'] > 1)
                {
                    $d['status'] += 4;	
                    $d['manager_id'] = 0;
                }
            }
            else
            {
                if($d['manager'])
                {
                    $d['status'] += 4;
                }
                $d['manager_id'] = 0;
            }

            if($names[$d['name']]['count'] > 1)
            {
                log_message('debug','counts:' . $names[$d['name']]['count'] );
                $d['status'] += 2;
            }
            if($d['status']<4)
            {
                foreach($gmember as $m)
                {
                    if($m['nickname'] == $d['manager'])
                    {
                        $d['manager_id'] = $m['id'];
                    }
                    else
                    {
                        $d['manager_id'] = 0;
                    }
                }
            }

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

        log_message('debug','data:' . json_encode($data));
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
        redirect(base_url('members/index'));

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
                        ,array('url'  => base_url('members/index'), 'name' => '员工&部门', 'class' => '')
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
        if($uids)
        {
            $uids = implode(",", $uids);
        }
        else
        {
            $uids='';
        }
        $info = $this->ug->update_data($manager,$uids, $name,$code,$pid,$gid);
        log_message("debug","@@@@@@@@@".json_encode($info));
        if($info['status'] > 0){
            //           redirect(base_url('members/groups'));
            redirect(base_url('members/index'));
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
        log_message('debug','m_info:' . json_encode($m_info['data']));

        $group = $this->groups->get_my_list();

        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        log_message('debug','@@@@manger_id:'.$manager_id);
        $path = base_url($this->users->reim_get_hg_avatar($info['avatar']));

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
        log_message("debug", "Member:" . json_encode($member));
        $info = $this->groups->reim_imports(array('members' => json_encode($member)));
        die(json_encode(array('msg'=>"it works")));
    }
}


