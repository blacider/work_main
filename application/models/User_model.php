<?php

class User_Model extends Reim_Model {

    public function __construct(){
        parent::__construct();
        $this->config->load('auth');
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
        $client_id = $this->config->item('api_client_id');
        $client_secret = $this->config->item('api_client_secret');
        $appsec = $this->config->item('weixin_appsec');
        $parms = array_merge($parms, [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ]);
        $ret = $this->api_post('/oauth2', $parms);
        log_message('debug', 'oauth2 ret: ' . json_encode($ret));
        if ($ret['status'] <= 0) {
            return $ret['data']['msg'];
        }
        $d = $ret['data'];
        $this->session->set_userdata("oauth2_ak", $d['access_token']);
        //$this->session->set_userdata("oauth2_expires_in", $d['expires_in']);
        return true;
    }

    public function logout() {
        $this->api_get('/logout');
        $this->session->sess_destroy();
    }

    public function get_common() {
        $data = $this->fetch_common();
        $this->refresh_session($data);
        return $data;
    }

    public function refresh_session($data=null) {
        if (empty($data)) {
            $data = $this->fetch_common();
        }
        $profile = $data['data']['profile'];
        $this->session->set_userdata('profile', $profile);
        $this->session->set_userdata("uid", $profile['id']);
        $this->session->set_userdata("groupname", $profile['group_name']);
    }

    private function fetch_common() {
        $obj = $this->api_get('common/0');
        //log_message('debug', 'common ret: ' . json_encode($obj));
        if (empty($obj['status']) or empty($obj['data'])) {
            throw new Exception('invalid common data');
        }
        return $obj;
    }

    public function reset_password($data = array()){
        return $this->api_put('resetpwd');
    }

    public function check_user($addr = 'email', $user_addr = '')
    {
        if($addr == 'weixin') {
            $data = $user_addr;
        } else {
            $data = array(
                $addr => $user_addr
            );
        }
        return $this->api_get('register/user', null, $data);
    }

    public function check_company($name='')
    {
        return $this->api_get("register/company/", null, ['name' => $name]);
    }

    public function reim_get_info($uid){
        $obj = $this->api_get('users/' . $uid);
        //log_message("debug", "Get: " . json_encode($obj));
        return $obj;
    }

    public function reim_update_password($old_password, $new_password, $pid){
        $data = array('new_password' => $new_password, 'old_password' => $old_password, 'uid' => $pid);
        return $this->api_put('users', $data);
    }

    public function reim_update_profile($email, $phone, $nickname, $credit_card,$usergroups, $uid = 0, $admin = 0, $manager_id = 0, $max_report = 0, $rank = 0, $level = 0, $client_id = '', $avatar = 0, $admin_groups_granted = '') {
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
        log_message("debug", 'profile_data: ' . json_encode($data));
        return $this->api_put('users', $data);
    }

    public function getvcode($phone){
        $data = array(
            'phone' => $phone,
            'reset' => 0,
        );
        return $this->api_post('vcode', $data);
    }

    public function bind_phone($phone, $vcode, $uid){
        $data = array(
            'phone' => $phone,
            'vcode' => $vcode,
            'uid' => $uid
        );
        return $this->api_put('users', $data);
    }

    public function update_credit($id, $account, $cardno, $cardbank, $cardloc , $uid, $subbranch, $default) {
        $data = array(
            'bank_name' => $cardbank,
            'bank_location' => $cardloc,
            'cardno' => $cardno,
            'account' => $account,
            'uid' => $uid,
            'subbranch' => $subbranch,
            'default' => $default,
        );
        return $this->api_put('bank/' . $id, $data);
    }


    public function new_credit($account, $cardno, $cardbank, $cardloc , $uid, $subbranch, $default) {
        $data = array(
            'bank_name' => $cardbank
            ,'bank_location' => $cardloc
            ,'cardno' => $cardno
            ,'account' => $account
            ,'uid' => $uid
            ,'subbranch' => $subbranch
            ,'default' => $default
        );
        return $this->api_post('bank', $data);
    }

    public function del_credit($id, $uid){
        return $this->api_delete('bank/' . $id);
    }

    public function exchange_weixin_token($code) {
        $appid = $this->config->item('weixin_appid');
        $appsec = $this->config->item('weixin_appsec');
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
