<?php

class User_Model extends Reim_Model {
    const MIN_UID = 100000;
    public function __construct(){
        parent::__construct();
    }
   public function my_get_jwt($username,$password)
   {
            $jwt = $this->get_jwt($username, $password);
            return $jwt;
   }
    public function join_company($gid,$version=0)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return base_url();

        $url = $this->get_url('apply');
        $data = array(
            'gid' => $gid,
            'version' => $version
        );
        $buf = $this->do_Post($url,$data,$jwt);

        return json_decode($buf,True);
    }

    public function get_invites()
    {
            $jwt = $this->session->userdata('jwt'); 
            $url = $this->get_url('/messages/list');
            $buf = $this->do_Get($url,$jwt);

            log_message('debug','get_invites:' . $buf);
            return json_decode($buf,True);
    }

    public function raise_invites($groupname,$guests)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt)  return false;
    
        $url = $this->get_url('invites');
        $data = array(
            'name' => $groupname
            ,'invites' => $guests
        );
        $buf = $this->do_Post($url,$data,$jwt); 
        
        return json_decode($buf,True);
    }

    public function get_common()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt)  return false;
    
        $url = $this->get_url('common');
        $buf = $this->do_Get($url,$jwt);
    
        //log_message('debug','common:' . $buf);
    
        return json_decode($buf,True);
    }

    public function del_email($email)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt)  return false;
    
        $url = $this->get_url('staff');
        $data = array('emails' => $email);
    
        $buf = $this->do_Post($url,$data,$jwt);
        log_message('debug','del_email:' . $buf);
        return json_decode($buf,True);
    }



    private function reim_fetch_avatar($path, $type = 1){
        if($path == '' || $path == 0) return '';
        $path = "images/" . $path;
        $new_file_path = "/static/users_data/". md5($path . $type) . ".jpg";
        if(file_exists(BASEPATH . "../" . $new_file_path)) return $new_file_path;
        
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url($path . "/" . $type);
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", "Avatar:" . $new_file_path . ", with length:" . strlen($buf) . ", FromURL:" . $url);
        file_put_contents(BASEPATH . "../" . $new_file_path, $buf);
        return $new_file_path;
    }

    public function reim_oauth($unionid = '', $openid = '', $token = '', $check = 1){
        $jwt = $this->get_jwt($unionid, "");
        $this->session->set_userdata('jwt', $jwt);
        $url = $this->get_url('oauth');
        $data = array('openid' => $openid, 'unionid' => $unionid, 'token' => $token, 'check' => $check);
        $buf = $this->do_Post($url, $data, $jwt);

        $obj = json_decode($buf, true);
        $jwt = $this->get_jwt($unionid, "", $obj['server_token'], 'pc');
        $this->session->set_userdata('jwt', $jwt);
        log_message("debug", "Reim Oauth - save jwt:" . json_encode($jwt));
        $profile = array();
        if($obj['status']){
            $profile = $obj['data']['profile'];
            // 下载头像
            $avatar = $profile['avatar'];
            $abs_path = $profile['abs_path'];
            log_message("debug", json_encode($profile['abs_path']));
            if($avatar) {
                if($abs_path){
                    $profile['src_avatar'] = $avatar;
                    $avatar = $profile['apath'];//avatar;
                    $profile['avatar'] = $avatar;//base_url($avatar);
                } else {
                    $profile['src_avatar'] = $avatar;
                    $avatar = 'http://reim-avatar.oss-cn-beijing.aliyuncs.com/' . $avatar;
                    $profile['avatar'] = $avatar;//base_url($avatar);
                }
            } else {
            $profile['avatar'] = base_url('/static/default.png');
            }
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }

    public function reim_get_user($username = '', $password = ''){
        log_message("debug", "Reim Get User");
        if('' !== $username && '' !== $password) {
            $jwt = $this->get_jwt($username, $password);
            $this->session->set_userdata('jwt', $jwt);
            log_message("debug", "login set jwt:" . json_encode($jwt));
        } else {
            $jwt = $this->session->userdata('jwt');
        }
        $url = $this->get_url('common/0');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        $profile = array();
        if($obj['status']){
            $profile = &$obj['data']['profile'];
            log_message("debug", 'profile -> ' . json_encode($obj['data']['profile']));
            // 下载头像
            if(empty($profile['avatar'])) {
                log_message('debug', 'load default avatar -> ' . base_url('/static/default.png'));
                $profile['avatar_url'] = base_url('/static/default.png');
                log_message("debug", 'profile -> ' . json_encode($obj['data']['profile']));
            }
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }

    public function reim_update_avatar($file) {
        $obj = $this->upload_avatar($file);
        if($obj['status']){
            $profile = $this->session->userdata('profile');
            // 下载头像
            $avatar = $obj['data']['avatar'];
            $profile['src_avatar'] = $avatar;
            log_message("debug", "update avatar:" . $avatar);
            $avatar = $this->_fetch_avatar($avatar);
            $profile['avatar'] = base_url($avatar);
            log_message("debug", json_encode($profile));
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }

    public function reim_joingroup($code) {
        $jwt = $this->get_jwt('', '');
        //$this->session->set_userdata('jwt', $jwt);
        $url = $this->get_url('invite/' . $code);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function reim_active_user($code){
        $jwt = $this->get_jwt('', '');
        $url = $this->get_url('active/' . $code);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function reim_get_info($uid){
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('users/' . $uid);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        log_message("debug", "Get:" . $buf . ",JWT: " . json_encode($jwt));
        if (empty($obj['data']['avatar'])) {
            log_message('debug', 'load default avatar -> ' . base_url('/static/default.png'));
            $obj['data']['avatar_url'] = base_url('/static/default.png');
            log_message("debug", 'profile -> ' . json_encode($obj));
        }
        return json_encode($obj);
    }
    
    public function reim_update_manager($id, $manager_id) {
        $data = array('manager_id' => $manager_id, 'uid' => $id);
        $url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function reim_update_password($old_password, $new_password, $pid){
        $data = array('new_password' => $new_password, 'old_password' => $old_password, 'uid' => $pid);
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('users');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function reim_update_profile($email, $phone, $nickname, $credit_card,$usergroups, $uid = 0, $admin = 0,$manager_id=0,$max_report,$rank,$level,$client_id,$admin_groups_granted){
        if($uid > 0) {
            $data['uid'] = $uid;
        }
        if(!empty($nickname)) {
            $data['nickname'] = $nickname;
        }
        if(!empty($credit_card)) {
            $data['credit_card'] = $credit_card;
        }
        if(!empty($email)) {
            $data['email'] = $email;
        }
        if(!empty($phone)) {
            $data['phone'] = $phone;
        }
        $data['admin_groups_granted'] = $admin_groups_granted;
        $data['manager_id'] = $manager_id;
        $data['admin'] = $admin;
        $data['groups'] = $usergroups;
        $data['max_report'] = $max_report;
        $data['rank'] = $rank;
        $data['level'] = $level;
        $data['client_id'] = $client_id;
        $url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        if(!$jwt)  return false;
        log_message("debug",'profile_data:' . json_encode($data));
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", 'profile:' . $buf);
        return $buf;
    }


    public function register($email, $pass, $phone, $code){
        $url = $this->get_url('users');
        $data = array(
            'email' => $email,
            'password' => $pass,
            'phone' => $phone,
            'code' => $code);

        $jwt = $this->get_jwt($email, $pass, '', 'admin');
        //$jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }


    public function reset_pwd($pass, $code) {
        $url = $this->get_url('password');
        $data = array(
            'password' => $pass
            ,'code' => $code
            );
        $jwt = array();
        //$jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function forget($type, $name, $code = 0) {
        $url = $this->get_url('password');
        $data = array(
            'type' => $type,
            'name' => $name,
            'vcode' => $code
            );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }


    public function getvcode($phone){
        $url = $this->get_url('vcode');
        $data = array(
            'phone' => $phone
            ,'reset' => 1
            );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function bind_phone($phone, $vcode){
        $url = $this->get_url('users');
        $data = array(
            'phone' => $phone,
            'vcode' => $vcode
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function update_credit($id, $account, $cardno, $cardbank, $cardloc , $uid, $subbranch, $default) {
        $url = $this->get_url('bank/' . $id);
        $data = array(
            'bank_name' => $cardbank
            ,'bank_location' => $cardloc
            ,'cardno' => $cardno
            ,'account' => $account
            ,'uid' => $uid
            ,'subbranch' => $subbranch
            ,'default' => $default
        );
        log_message('debug','credit_data:' . json_encode($data));
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }


    public function new_credit($account, $cardno, $cardbank, $cardloc , $uid, $subbranch, $default) {
        $url = $this->get_url('bank');
        $data = array(
            'bank_name' => $cardbank
            ,'bank_location' => $cardloc
            ,'cardno' => $cardno
            ,'account' => $account
            ,'uid' => $uid
            ,'subbranch' => $subbranch
            ,'default' => $default
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function del_credit($id,$uid){
        $url = $this->get_url('bank/' . $id . '/' . $uid);
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
        return $buf;
    }
    public function doapply($gid){
        $url = $this->get_url('apply');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, array('gid' => $gid), $jwt);
        log_message("debug", $buf);
        return $buf;
    }
    
}
