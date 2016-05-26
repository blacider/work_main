<?php

class User_Model extends Reim_Model {


    public function __construct(){
        parent::__construct();
    }

    public function oauth2_auth_pwd($username, $password) {
        return $this->oauth2_auth([
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ]);
    }

    public function oauth2_auth_weixin($wx_openid, $wx_access_token) {
        return $this->oauth2_auth([
            'grant_type' => 'weixin',
            'openid' => $wx_openid,
            'access_token' => $wx_access_token,
        ]);
    }

    private function oauth2_auth($parms) {
        $client_id = 'w2Dl7oc0CimMq1yFtLDcdFVBKWEeIjwTr1wRLngd';
        $client_secret = 'nWx8llO9LmZdxek2g8K7nc6mnWC9rmW1dOEoQ5An';
        $parms = array_merge($parms, [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ]);
        $ret = $this->api_post('/oauth2', $parms);
        log_message('debug', 'oauth2 ret: ' . $ret);
        $ret = json_decode($ret, true);
        if ($ret['status'] <= 0) {
            return $ret['data']['msg'];
        }
        $d = $ret['data'];
        $this->session->set_userdata("oauth2_ak", $d['access_token']);
        $this->session->set_userdata("jwt", ['X-REIM-JWT: placebo']);
        //$this->session->set_userdata("oauth2_expires_in", $d['expires_in']);
        return true;
    }

    public function logout() {
        $this->session->sess_destroy();
        $ret = $this->api_get('/logout');
    }

    public function refresh_session() {
        $user = $this->reim_get_user();
        $data = $user['data']['profile'];
        $uid = $data['id'];
        $this->session->set_userdata("uid", $uid);
    }

    public function reset_password($data = array()){
        $url = $this->get_url('resetpwd');
        log_message("debug","url:" . $url);
        log_message("debug","data:" . json_encode($data));
        $buf = $this->do_Put($url,$data,'');

        log_message("debug","reset_password_back:" . $buf);
        return json_decode($buf,true);
    }

    public function check_user($addr = 'email', $user_addr = '')
    {
        if($addr == 'weixin') {
            $data = $user_addr;
        }
        else {
            $data = array(
                $addr => $user_addr
            );
        }
        $url = $this->get_url('register/user',$data);
        log_message("debug","data:" . json_encode($data));
        $buf = $this->do_Get($url,'');
        log_message("debug","check_user_back:" . $buf);
        return json_decode($buf,true);
    }

    public function check_company($name = '')
    {
        $url = $this->get_url("register/user/" . $name);
        $buf = $this->do_Get($url, '');
        log_message("debug","check_company:" . $buf);
        return json_decode($buf,true);
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

    public function reim_get_user(){
        log_message("debug", "Reim Get User");
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('common/0');
        $buf = $this->do_Get($url, $jwt);
        log_message('debug', 'common ret: ' . $buf);
        $obj = json_decode($buf, true);
        $profile = array();
        if($obj['status']){
            $profile = &$obj['data']['profile'];
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }

    public function reim_get_info($uid){
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('users/' . $uid);
        $buf = $this->do_Get($url, $jwt);
        $obj = json_decode($buf, true);
        log_message("debug", "Get:" . $buf . ",JWT: " . json_encode($jwt));
        return json_encode($obj);
    }

    public function reim_update_password($old_password, $new_password, $pid){
        $data = array('new_password' => $new_password, 'old_password' => $old_password, 'uid' => $pid);
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('users');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function reim_update_profile($email, $phone, $nickname, $credit_card,$usergroups, $uid = 0, $admin = 0, $manager_id = 0, $max_report = 0, $rank = 0, $level = 0, $client_id = '', $avatar = 0, $admin_groups_granted = ''){
        if($uid) {
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
        if($admin >=0 )
        {
            $data['admin'] = $admin;
        }
        $data['groups'] = $usergroups;
        $data['max_report'] = $max_report;
        $data['rank'] = $rank;
        $data['level'] = $level;
        $data['client_id'] = $client_id;
        $data['avatar'] = $avatar;
        $url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        if(!$jwt)  return false;
        log_message("debug",'profile_data:' . json_encode($data));
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", 'profile:' . $buf);
        return $buf;
    }

    public function getvcode($phone){
        $url = $this->get_url('vcode');
        $data = array(
            'phone' => $phone,
            'reset' => 0,
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        return $buf;
    }

    public function bind_phone($phone, $vcode, $uid){
        $url = $this->get_url('users');
        $data = array(
            'phone' => $phone,
            'vcode' => $vcode,
            'uid' => $uid
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        return $buf;
    }

    public function update_credit($id, $account, $cardno, $cardbank, $cardloc , $uid, $subbranch, $default) {
        $url = $this->get_url('bank/' . $id);
        $data = array(
            'bank_name' => $cardbank,
            'bank_location' => $cardloc,
            'cardno' => $cardno,
            'account' => $account,
            'uid' => $uid,
            'subbranch' => $subbranch,
            'default' => $default,
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
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
        return $buf;
    }

    public function del_credit($id,$uid){
        $url = $this->get_url('bank/' . $id . '/' . $uid);
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Delete($url, array(), $jwt);
        return $buf;
    }

    public function exchange_weixin_token($code) {
        $appid = 'wxa718c52caef08633';
        $appsec = '02c3df9637d1210a84447524f3606dc1';
        $qs = http_build_query([
            'appid' => $appid,
            'secret' => $appsec,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);
        $auth_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . $qs;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $auth_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $buf = curl_exec($ch);
        log_message('debug', "weixin oauth2 ret: $buf");
        return json_decode($buf, True);
    }

}
