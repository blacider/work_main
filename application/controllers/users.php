<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('group_model', 'groups');
        //$this->load->model('users/customer_model', 'cmodel');  
    }

    public function update_nickname(){
        $uid = $this->input->post('uid');
        $nickname = $this->input->post('nickname');
        log_message("debug", "update nickname: " . $nickname);
        log_message("debug", "update uid: " . $uid);
        if($uid == 0){
            $info = $this->groups->change_group_name($nickname);
        }else {
            $info = $this->user->update_nickname($uid, $nickname);
        }
        die($info);
    }

    public function update_manager(){
        $uid = $this->input->post('uid');
        $manager = $this->input->post('manager_id');
        log_message("debug", "update manager: " . $manager);
        log_message("debug", "update uid: " . $uid);
        return $this->user->reim_update_manager($uid, $manager);
    }

    public function logout(){
        $this->session->unset_userdata('jwt');
        redirect(base_url('login'));

    }

    public function profile(){
        // 重新获取
        $profile = $this->user->reim_get_user();
        //print_r($profile);
        //$profile = $this->session->userdata('prOfile');
        if($profile){
            //print_r($profile);
            $profile = $profile['data']['profile'];
            $uid = $profile['id'];
            $profile = json_decode($this->user->reim_get_info($uid), True);
            $profile =  $profile['data'];
            $path = base_url($this->user->reim_get_hg_avatar());
            //print_r($profile);
        } else  {
            $user = $this->session->userdata('user');
            //log_message("debug", json_encode($user));
            $profile['nickname'] = $user->nickname;
            $profile['email'] = $user->email;
            $profile['phone'] = '不管';
            $profile['group'] = array('group_name' => '如数管理员');
            $profile['admin'] = array();
            $profile['wx_token'] = '不管';
            $profile['lastdt'] = $user->create_time;

            $path = '';//base_url();
        }
        $error = $this->session->userdata('last_error');
        $this->session->set_userdata('last_error', '');

        //print_r($profile);
        $this->bsload('user/profile',
            array(
                'title' => '个人管理'
                ,'member' => $profile
                ,'self' => 1
                ,'error' => $error
                ,'avatar_path' => $path
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '修改资料', 'class' => '')
                ),
            )
        );
    }

    public function validate_pwd(){
        $pwd = $this->input->post('password');
        log_message("debug", "password:" . $pwd);
        $profile = $this->session->userdata('profile');
        log_message("debug", "profile:" . json_encode($profile));
        if(!$profile){
            $user = $this->session->userdata('user');
        } else {
            $user = $this->user->get_user($profile['email'], $pwd);
        }

        die(json_encode($user));
    }


    public function update_profile(){
        $nickname = $this->input->post('nickname');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $credit_card = $this->input->post('credit_card');
        if(!($nickname || $email || $phone || $credit_card)){
            redirect(base_url('users/profile'));
        }
        $info = json_decode($this->user->reim_update_profile($email, $phone, $nickname, $credit_card), true);
        if($info['status'] > 0){
            $this->session->set_userdata('login_error', '信息修改成功');
        } else {
            $this->session->set_userdata('login_error', '信息修改失败');
            redirect(base_url('login'));
        }
        redirect(base_url('users/profile'));
    }


    public function password(){
        $profile = $this->session->userdata('profile');
        $this->eload('user/password',
            array(
                'title' => '修改密码'
                ,'profile' => $profile
            ));
    }

    public function update_password(){
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('password');
        $re_password = $this->input->post('repassword');
        if(!($old_password && $new_password && $re_password)){
            $this->session->set_userdata('login_error', '参数错误');
            return redirect('users/profile');
        }
        if($re_password != $new_password) {
            $this->session->set_userdata('login_error', '新密码不相同');
            return redirect('users/profile');
        }
        $info = json_decode($this->user->reim_update_password($old_password, $new_password), true);
        if($info['status'] > 0){
            $this->session->unset_userdata('jwt');
            $this->session->unset_userdata('profile');
            $this->session->set_userdata('login_error', '密码修改成功');
            redirect(base_url('login'));
        } else {
            $this->session->unset_userdata('jwt');
            $this->session->unset_userdata('profile');
            $this->session->set_userdata('login_error', '信息修改失败');
            redirect(base_url('login'));
        }
    }

    public function avatar(){
        $profile = $this->session->userdata('profile');
        $this->eload('user/avatar',
            array(
                'title' => '修改头像'
                ,'profile' => $profile
            ));
    }


    public function update_avatar(){
        $result = array();
        $successNum = 0;
        $i = 0;
        while (list($key, $val) = each($_FILES)) {
            if ( $_FILES[$key]['error'] > 0)
            {
                $this->session->set_userdata('avatar_error', array('status'=>False, 'msg' => '头像获取失败'));
                $result['msg'] = '头像上传出错,请检查网络后重试';
            }
            else
            {
                $fileName = date("YmdHis").'_'.floor(microtime() * 1000).'_'.$this->createRandomCode(8);
                //头像图片(file 域的名称：__avatar1,2,3...)。
                if (strpos($key, '__avatar1') === 0)
                {
                    $relate_file = 'static/users_data/avatar/' . date('Y/m') . "/" . $fileName . ".jpg";
                    $virtualPath = BASEPATH . '../static/users_data/avatar/' . date('Y/m');
                    if(!file_exists($virtualPath)){
                        $mkres = mkdir($virtualPath, 0777, true);
                        if(!$mkres){
                            die('Can NOT mkdir');
                        }
                    }
                    $virtualPath = $virtualPath . "/" .  $fileName . ".jpg";
                    $result['avatarUrls'][$i] = base_url($virtualPath);
                    move_uploaded_file($_FILES[$key]["tmp_name"], $virtualPath);
                    $successNum++;
                    $i++;
                    $obj = $this->user->update_avatar($virtualPath);
                    if($obj['status'] < 1){
                        //// iid
                        //$iid = $obj['data']['id'];
                        //$profile = $this->session->userdata('profile');
                        //$profile['avatar'] = $obj['data']['path'];
                        //$this->session->set_userdata('profile', $profile);
                    } else {
                        $this->session->set_userdata('last_error', '更新失败');
                    }
                    die(json_encode(array(
                        'success' => true
                    )));
                    //return redirect(base_url('users/profile'));
                }
            }
        }
    }


    private function createRandomCode($length)
    {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++)
        {
            $randomCode .= $randomChars { mt_rand(0, 35) };
        }
        return $randomCode;
    }

    public function info($uid = 0){
        if(!$uid) return die(json_encode(array('code' => -1)));
        die($this->user->reim_get_info($uid));
    }


    public function detail($id = 0){
        if($id == 0) {
            die(json_encode(array('status' => false)));
        }

        $obj = $this->user->reim_get_info($id);
        die(json_encode(array('status' => true, 'data' => $obj)));


    }

    public function forget(){
        $type = $this->input->post('type');
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        die($this->user->forget($type, $name, $code));
    }

    public function reset(){
        $pass = $this->input->post('pass');
        $code= $this->input->post('code');
        die($this->user->reset_pwd($pass, $code));

    }


    public function getvcode(){
        $phone = $this->input->post('phone');
        if(!$phone) {
            die(json_encode(array('status' => false, 'msg' => '参数错误')));
        } else {
            die($this->user->getvcode($phone));
        }
    }


    public function update_phone(){
        $phone = $this->input->post('phone');
        $vcode = $this->input->post('vcode');
        if(!$phone || !$vcode) {
            die(json_encode(array('status' => false, 'data' => array('msg' => '参数错误'))));
        } else {
            $buf = $this->user->bind_phone($phone, $vcode);
            $obj = json_decode($buf, True);
            if($obj['status']) {
                redirect(base_url('users/logout'));
            } else {
                $this->session->set_userdata('last_error', $obj['data']['msg']);
                redirect(base_url('users/profile'));
            }
        }
    }


    public function new_credit() {
        $account = $this->input->post('account');
        $cardbank = $this->input->post('cardbank');
        $cardno = $this->input->post('cardno');
        $cardloc = $this->input->post('cardloc');
        $id = $this->input->post('id');

        if($id) {
        $buf = $this->user->update_credit($id, $account, $cardno, $cardbank, $cardloc);
        } else {
        $buf = $this->user->new_credit($account, $cardno, $cardbank, $cardloc);
        }
        //$obj = json_decode($buf, True);
        die($buf);
    }


    public function del_credit($id = 0){
        $buf = $this->user->del_credit($id);
        die($buf);
    }
}

