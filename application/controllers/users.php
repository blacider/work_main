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
        $profile = $this->session->userdata('profile');
        if($profile){
            $path = base_url($this->user->reim_get_hg_avatar());
        } else  {
            $user = $this->session->userdata('user');
            log_message("debug", json_encode($user));
            $profile['nickname'] = $user->nickname;
            $profile['email'] = $user->email;
            $profile['phone'] = '不管';
            $profile['group'] = array('group_name' => '如数管理员');
            $profile['admin'] = array();
            $profile['wx_token'] = '不管';
            $profile['lastdt'] = $user->create_time;

            $path = '';//base_url();
        }

        $this->eload('user/profile',
            array(
                'title' => '个人管理'
                ,'profile' => $profile
                ,'avatar_path' => $path
            ),
            'menu.profile.php'
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
        if(!($nickname || $email || $phone)){
            redirect(base_url('users/profile'));
        }
        $info = json_decode($this->user->reim_update_profile($email, $phone, $nickname), true);
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
}
