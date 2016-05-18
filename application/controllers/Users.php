<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends REIM_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('group_model', 'groups');
        $this->load->model('reim_show_model', 'reim_show');
    }

    public function update_nickname() {
        $uid = $this->input->post('uid');
        $nickname = $this->input->post('nickname');
        log_message("debug", "update nickname: " . $nickname);
        log_message("debug", "update uid: " . $uid);
        if ($uid == 0) {
            $info = $this->groups->change_group_name($nickname);
        }
        else {
            $info = $this->user->update_nickname($uid, $nickname);
        }
        die($info);
    }

    public function update_manager() {
        $uid = $this->input->post('uid');
        $manager = $this->input->post('manager_id');
        log_message("debug", "update manager: " . $manager);
        log_message("debug", "update uid: " . $uid);
        return $this->user->reim_update_manager($uid, $manager);
    }

    public function get_profile_data_with_property()
    {
        $property = $this->input->get('property');
        $profile = $this->session->userdata('profile');
        if($property) {
            $pro_arr = explode('.', $property);
        }

        $len =  count($pro_arr);
        $i = 0;
        $data = $profile;
        while($i<$len) {
            $data = $data[$pro_arr[$i]];
            $i++;
        }

        die(json_encode($data));
    }

    public function profile() {

        // 重新获取
        $profile = $this->user->reim_get_user();
        if (empty($profile) or empty($profile['data']['profile'])) {
            $this->user->logout();
            return redirect(base_url('login'));
        }

        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $ug = $this->reim_show->usergroups();
        $_ranks = $this->groups->get_rank_level(1);
        $_levels = $this->groups->get_rank_level(0);
        $ranks = array();
        $levels = array();

        if ($_ranks['status'] > 0) {
            $ranks = $_ranks['data'];
        }

        if ($_levels['status']) {
            $levels = $_levels['data'];
        }

        $pro = $profile['data']['profile'];
        $config = $profile['data']['profile'];
        if (array_key_exists('group', $config)) {
            if (array_key_exists('config', $profile['data']['profile']['group'])) {
                $config = $profile['data']['profile']['group']['config'];
            }
        }
        else {
            $config = array();
        }
        $profile = $profile['data']['profile'];
        $sobs = array();
        $usergroups = array();
        $audits = array();
        $commits = array();

        if (array_key_exists('commits', $profile)) {
            $sobs = $profile['commits'];
        }

        if (array_key_exists('sob', $profile)) {
            $sobs = $profile['sob'];
        }
        if (array_key_exists('usergroups', $profile)) {
            $usergroups = $profile['usergroups'];
        }

        $uid = $profile['id'];
        $profile = json_decode($this->user->reim_get_info($uid), True);
        $profile = $profile['data'];
        $manager_id = $profile['manager_id'];

        $group = $this->groups->get_my_list();

        $gmember = array();
        if ($group) {
            if (array_key_exists('gmember', $group['data'])) {
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
        $this->bsload('user/profile', array('title' => '个人管理', 'member' => $profile, 'self' => 1, 'error' => $error, 'isOther' => 0, 'manager_id' => $manager_id, 'gmember' => $gmember, 'pid' => $uid, 'pro' => $pro, 'ug' => $ug, 'ranks' => $ranks, 'levels' => $levels, 'breadcrumbs' => array(array('url' => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon'), array('url' => '', 'name' => '修改资料', 'class' => '')),));
    }

    public function validate_pwd() {
        $pwd = $this->input->post('password');
        log_message("debug", "password:" . $pwd);
        $profile = $this->session->userdata('profile');
        log_message("debug", "profile:" . json_encode($profile));
        if (!$profile) {
            $user = $this->session->userdata('user');
        }
        else {
            $user = $this->user->get_user($profile['email'], $pwd);
        }

        die(json_encode($user));
    }

    public function update_profile($isOther) {
        $profile = $this->session->userdata('profile');
        $client_id = $this->input->post('client_id');
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $uid = $this->input->post('uid');
        $avatar = $this->input->post('avatar');
        $credit_card = $this->input->post('credit_card');
        $manager_id = $this->input->post('manager');
        $admin = $this->input->post('admin_new');
        $_usergroups = $this->input->post('usergroups');
        $max_report = $this->input->post('max_report');
        $rank = $this->input->post('rank');
        $level = $this->input->post('level');
        $admin_groups_granted = '';
        $_admin_groups_granted = $this->input->post('admin_groups_granted');

        if ($admin == '') {
            $admin = - 1;
        }
        if (in_array($admin, [2, 4])) {
            $admin_groups_granted = $_admin_groups_granted;
        }
        if ($admin_groups_granted) {
            $admin_groups_granted = implode(',', $admin_groups_granted);
        }
        else {
            $admin_groups_granted = '-1';
        }

        $usergroups = '';
        log_message('debug', 'admin:' . $admin);
        if ($_usergroups) {
            $usergroups = implode(',', $_usergroups);
        }
        if (!($uid || $nickname || $email || $phone || $credit_card)) {
            redirect(base_url('users/profile'));
        }
        if (array_key_exists('admin', $profile)) {
            if (!in_array($profile['admin'], [1, 3, 4])) {
                $client_id = '';
            }
        }


        $data = $this->user->reim_update_profile($email, $phone, $nickname, $credit_card, $usergroups, $uid, $admin, $manager_id, $max_report, $rank, $level, $client_id, $avatar, $admin_groups_granted);
        $info = json_decode($data, true);
        if ($info['status'] > 0) {
            $this->session->set_userdata('last_error', '信息修改成功');
        } else {
            $this->session->set_userdata('last_error', $info['data']['msg']);
        }
        if ($isOther == 1) {
            redirect('/members/index');
        } else {
            redirect('/users/profile');
        }
    }

    public function force_update_password() {
        $profile = $this->user->reim_get_user();
        $profile_id = $profile['data']['profile']['id'];
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $re_password = $this->input->post('repassword');
        $pid = $this->input->post('pid');

        if ($re_password != $new_password) {
            $this->session->set_userdata('last_error', '新密码不相同');
        }
        $info = json_decode($this->user->reim_update_password($old_password, $new_password, $pid), true);
        log_message('debug', 'info:' . json_encode($info));
        if ($info['status'] > 0) {
            die(json_encode(array('status' => 1, 'msg' => '密码修改成功')));
        }
        else {

            // if()
            // redirect(base_url(''));
            if ($info['code'] == - 75) {
                die(json_encode(array('status' => 0, 'msg' => '新密码不能包含用户名或手机号')));
            }
            else {
                die(json_encode(array('status' => 0, 'msg' => $info['data']['msg'])));
            }
        }
    }



    public function get_members()
    {
        $profile = $this->user->reim_get_user();

        $members = $profile['data']['members'];

        $_ranks = $this->reim_show->rank_level(1);
        $ranks =array();
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

        $data = array(
            'status'=>$profile['status'],
            'data' =>array(
                'members'=>$members,
                'levels'=>$levels,
                'ranks'=>$ranks
            )
        );
        die(json_encode($data));
    }

    public function update_password() {
        $profile = $this->user->reim_get_user();
        $profile_id = $profile['data']['profile']['id'];
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $re_password = $this->input->post('repassword');
        $pid = $this->input->post('pid');
        log_message("debug", "######" . $pid . " " . $profile_id);
        if (!($old_password && $new_password && $re_password)) {
            $this->session->set_userdata('last_error', '参数错误');
            if ($pid == $profile_id) {
                return redirect('users/profile');
            }
            else {
                redirect(base_url('members/editmember/' . $pid));
            }
        }
        if ($re_password != $new_password) {
            $this->session->set_userdata('last_error', '新密码不相同');
            if ($pid == $profile_id) {
                return redirect('users/profile');
            }
            else {
                redirect(base_url('members/editmember/' . $pid));
            }
        }
        $info = json_decode($this->user->reim_update_password($old_password, $new_password, $pid), true);
        if ($info['status'] > 0) {
            if ($pid == $profile_id) {
                $this->session->unset_userdata('jwt');
                $this->session->unset_userdata('profile');
                $this->session->set_userdata('last_error', '密码修改成功');
                redirect(base_url('login'));
            }
            else {
                $this->session->set_userdata('last_error', '密码修改成功');
                redirect(base_url('members/editmember/' . $pid));
            }
        }
        else {
            $this->session->set_userdata('last_error', '信息修改失败');
            if ($pid == $profile_id) {
                redirect(base_url('users/profile'));
            }
            else {
                redirect(base_url('members/editmember/' . $pid));
            }

            // if()
            // redirect(base_url(''));


        }
    }

    private function createRandomCode($length) {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $randomCode.= $randomChars{mt_rand(0, 35) };
        }
        return $randomCode;
    }

    public function info($uid = 0) {
        if (!$uid) return die(json_encode(array('code' => - 1)));
        die($this->user->reim_get_info($uid));
    }

    public function detail($id = 0) {
        if ($id == 0) {
            die(json_encode(array('status' => false)));
        }

        $obj = $this->user->reim_get_info($id);
        die(json_encode(array('status' => true, 'data' => $obj)));
    }

    public function forget() {
        $type = $this->input->post('type');
        $name = $this->input->post('name');
        $code = $this->input->post('code');

        //if(!$code) die(json_encode(array('status' => 0, 'data' => array('msg' => '请输入验证码'))));
        die($this->user->forget($type, $name, $code));
    }

    public function reset() {
        $pass = $this->input->post('pass');
        $code = $this->input->post('code');
        if (!$code) die(json_encode(array('status' => 0, 'data' => array('msg' => '请输入验证码'))));
        die($this->user->reset_pwd($pass, $code));
    }

    public function getvcode() {
        $phone = $this->input->post('phone');
        if (!$phone) {
            die(json_encode(array('status' => false, 'msg' => '参数错误')));
        }
        else {
            die($this->user->getvcode($phone));
        }
    }

    public function update_phone() {
        $phone = $this->input->post('phone');
        $vcode = $this->input->post('vcode');
        $uid = $this->input->post('uid');
        // 如果是自己就不用传递UID
        $profile = $this->session->userdata('profile');
        if($profile['id'] == $uid) {
            $uid = '';
        }
        if (!$phone) {
            die(json_encode(array('status' => false, 'data' => array('msg' => '参数错误'))));
        }
        else {
            $buf = $this->user->bind_phone($phone, $vcode, $uid);
            die($buf);
        }
    }

    public function get_user_profile($uid) {
        $profile = $this->user->reim_get_info($uid);
        die($profile);
    }

    public function new_credit() {
        $profile = $this->session->userdata('profile');
        $uid = $profile['id'];
        $account = $this->input->post('account');
        $cardbank = $this->input->post('cardbank');
        $cardno = $this->input->post('cardno');
        $cardloc = $this->input->post('cardloc');
        $id = $this->input->post('id');
        $_uid = $this->input->post('uid');
        $subbranch = $this->input->post('subbranch');
        $default = $this->input->post('default');

        if ($_uid) {
            $uid = $_uid;
        }
        if ($id) {
            $buf = $this->user->update_credit($id, $account, $cardno, $cardbank, $cardloc, $uid, $subbranch, $default);
        }
        else {
            $buf = $this->user->new_credit($account, $cardno, $cardbank, $cardloc, $uid, $subbranch, $default);
        }
        log_message('debug', 'uid:' . $uid);
        die($buf);
    }

    public function del_credit($id = 0, $uid) {
        $buf = $this->user->del_credit($id, $uid);
        die($buf);
    }

    public function dumps() {
    }
}

