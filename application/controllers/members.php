<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model', 'ug');
        $this->load->model('group_model', 'groups');
    }

    public function index(){
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
                'title' => '公司成员'
                ,'group' => $ginfo
                ,'members' => $gmember
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                        ,array('url'  => '', 'name' => '成员管理', 'class' => '')
                    ),
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
                'title' => '成员组管理'
                ,'group' => $ginfo
                ,'members' => $gmember
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                    ,array('url'  => base_url('members/index'), 'name' => '成员管理', 'class' => '')
                    ,array('url'  => '', 'name' => '部门管理', 'class' => '')
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
        log_message("debug", json_encode($group));
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

    public function setadmin($uid = 0){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $ids = $this->input->post('data');
        if(count($ids) == 0){
            die("");
        }
        $_ids = implode(',', $ids);
        $_type = $this->input->post('type');
        $info = $this->groups->setadmin($_ids, $_type);
        redirect(base_url('groups'));
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
    public function add() {
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
        $this->bsload('groups/new',
            array(
                'title' => '成员组管理',
                'member' => $gmember
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                        ,array('url'  => base_url('members/index'), 'name' => '成员管理', 'class' => '')
                        ,array('url'  => '', 'name' => '新建部门', 'class' => '')
                    ),
            )
        );
    }

    public function listgroup(){
        $page = $this->input->get('page');
        $rows = $this->input->get('rows');
        $sort = $this->input->get('sord');
        $group = $this->ug->get_my_list();
        log_message("debug", "LISTDATA:" . json_encode($group));
        /// 结构好奇怪啊
        //
        if($group['status']){
            //die(json_encode(array('data' => $group['data'])));
            foreach($group['data'] as &$s){
                $s['options'] = '<div class="hidden-sm hidden-xs action-buttons ui-pg-div ui-inline-del" data-id="' . $s['id'] . '">'
                    . '<span class="ui-icon ui-icon-trash tdel" data-id="' . $s['id'] . '"></span></div>';
            }
            die(json_encode($group['data']));
        }
    }


    public function newmember(){
        $group = $this->ug->get_my_list();
        $this->bsload('members/new',
            array(
                'title' => '成员组管理',
                'groups' => $group['data']
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                        ,array('url'  => base_url('members/index'), 'name' => '成员管理', 'class' => '')
                        ,array('url'  => '', 'name' => '录入新员工资料', 'class' => '')
                    ),
            )
        );
    }

    public function docreate(){
        $nickname = $this->input->post('nickname');
        $phone = $this->input->post('mobile');
        $credit = $this->input->post('credit');
        $email = $this->input->post('email');
        $groups = $this->input->post('groups');
        $renew = $this->input->post('renew');
        if($email == "" && $phone == ""){
            // 出错
            $this->show_error('手机号或者邮箱必须填写一项');
        }
        $name = $email;
        if(!$name) {
            $name = $phone;
            $phone = '';
        }
        // 等逻辑
        $this->groups->set_invite($email, $nickname, $phone, $credit, $groups);
        if($renew) {
            redirect(base_url('members/newmember'));
        } else {
            redirect(base_url('members/index'));
        }
    }

    public function export(){
        $group = $this->ug->get_my_list();
        $this->bsload('members/exports',
            array(
                'title' => '导出员工',
                'groups' => $group['data']
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                        ,array('url'  => base_url('members/index'), 'name' => '成员管理', 'class' => '')
                        ,array('url'  => '', 'name' => '导入导出', 'class' => '')
                    ),
            )
        );
    }

    public function exports(){
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
        foreach($gmember as $m){
            $obj = array();
            $obj['昵称'] = $m['nickname'];
            $obj['邮箱'] = $m['email'];
            $obj['手机号'] = $m['phone'];
            $obj['银行卡号'] = $m['credit_card'];
            array_push($data, $obj);
        }
        $this->render_to_download('人员', $data, '员工信息.xlsx');
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
        foreach($gmember as $g){
            $__email = $g['email']; 
            $__phone = $g['phone']; 
            if($__email)
                array_push($_emails, $__email);
            if($__phone)
                array_push($_phones, $__phone);
        }

        $data = array();
        /** 循环读取每个单元格的数据 */
        for ($row = 4; $row <= $highestRow; $row++){//行数是以第1行开始
            $obj = Array();
            $obj['name'] = trim($sheet->getCellByColumnAndRow(0, $row)->getValue());
            $obj['email'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $obj['phone'] = trim($sheet->getCellByColumnAndRow(2, $row)->getValue());
            $obj['credit_card'] = trim($sheet->getCellByColumnAndRow(3, $row)->getValue());
            if("" == $obj['email'] && "" == $obj['phone']) continue;
            $obj['status'] = 0;
            if(in_array($obj['email'], $_emails) || in_array($obj['phone'], $_phones)){
                $obj['status'] = 1;
            }
            array_push($data, $obj);
        }

        $this->bsload('members/imports',
            array(
                'title' => '导入员工',
                'members' => $data
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa fa-home home-icon')
                        ,array('url'  => base_url('members/index'), 'name' => '成员管理', 'class' => '')
                        ,array('url'  => base_url('members/export'), 'name' => '导入/导出', 'class' => '')
                        ,array('url'  => '', 'name' => '确认导入', 'class' => '')
                    ),
            )
        );
    }

    public function import_single(){
        $member = $this->input->post('member');
        $id = $this->input->post('id');
        if(!$member) die(json_encodE(array('status' => false, 'id' => $id, 'msg' => '参数错误')));
        $obj = json_decode(base64_decode($member), True);

        $email = $obj['email'];
        $nickname = $obj['name'];
        $phone = $obj['phone'];
        $credit = $obj['credit_card'];
        $groups = '';
        if($phone == $email && $email == ""){
            die(json_encodE(array('status' => false, 'id' => $id, 'msg' => '邮箱手机必须有一个')));
        }
        $this->groups->set_invite($email, $nickname, $phone, $credit, $groups);
        die(json_encode(array('status' => true, 'id' => $id)));
    }

    public function delgroup($id = 0){
        if($id == 0) redirect(base_url('members/groups'));
        $this->groups->delete_group($id);
        redirect(base_url('members/groups'));

    }


}


