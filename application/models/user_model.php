<?php

class User_Model extends Reim_Model {
    const MIN_UID = 100000;
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        return $this->db->get(self::USER_TABLE)->result();
    }

    public function update_avatar($path, $uid){
        $data = array('pic_url' => $path);
        $this->db->where('id', $uid);
        $this->db->update('tbl_user', $data);
    }

    public function get_user($username, $password){
        if(empty($username) || empty($password)){
            return array();
        }
        return $this->db->get_where(self::USER_TABLE, array('username' => $username, 'password' => md5($password)))->row();
    }




    public function get_by_id($id) {
        return $this->db->get_where(self::USER_TABLE, array('id' => $id))->row();
    }

    public function get_user_by_role_id($role_id){
        $query = $this->db->get_where(self::USER_TABLE, array('role_id' => $role_id));
        return $query->result();
    }

    public function remove_role_id($role_id){
        $data = array(
                'role_id' => 0
                );
        $this->db->where('role_id', $role_id);
        return $this->db->update(self::USER_TABLE, $data);
    }

    public function update($user_id, $nickname, $email, $role_id, $password = ''){
        $data = array(
                'nickname' => $nickname,
                'email' => $email,
                'role_id' => $role_id,
                );
        if(!empty($password)){
            $data['password'] = md5($password);
        }
        $this->db->where('id', $user_id);
        return $this->db->update(self::USER_TABLE, $data);
    }

    public function update_personal_info($user_id, $nickname, $email, $role_id, $password){
        $data = array();
        if(!empty($nickname)) {
            $data['nickname'] = $nickname;
        }
        if(!empty($email)) {
            $data['email'] = $email;
        }
        if(!empty($password)) {
            $data['password']=md5($password);
        }
        $this->db->where('id', $user_id);
        return $this->db->update(self::USER_TABLE, $data);
    }
    public function del($id){
        return $this->db->delete(self::USER_TABLE, array('id' => $id));
    }

    public function ban($id){
        $data = array(
                'status' => '-1',
                );
        $this->db->where('id', $id);
        return $this->db->update(self::USER_TABLE, $data);
    }

    public function create($username, $password, $nickname, $email, $role_id){
        if(empty($username) || empty($password) || empty($role_id)){
            return false;
        }
        $create_time = time();
        $data = array(
                'username' => $username,
                'password' => md5($password),
                'nickname' => $nickname,
                'email' => $email,
                'role_id' => $role_id,
                'create_time' => $create_time,
                );
        $insert_res = $this->db->insert(self::USER_TABLE, $data);
        if($insert_res){
            $_id = $this->db->insert_id();
            return $_id;
        }
        else{
            return false;
        }
    }

    public function get_by_username($username){
        if(empty($username)){
            return false;
        }
        return $this->db->get_where(self::USER_TABLE, array('username' => $username))->row();
    }
    public function by_username_array($username){
        if(empty($username)){
            return false;
        }
        return $this->db->get_where(self::USER_TABLE, array('username' => $username))->result_array();
    }

    public function get_by_email($email){
        if(empty($email)){
            return false;
        }
        return $this->db->get_where(self::USER_TABLE, array('email' => $email))->row();
    }

    public function get_by_nickname($username){
        if(empty($username)){
            return false;
        }
        return $this->db->get_where(self::USER_TABLE, array('username' => $username))->row();
    }

    public function get_menu($uid, $users = 0){
        if($users == 0) {
            $user = $this->session->userdata('user');
            if($user->role_id == 1){
                $this->db->select('tbl_module.id module_id, tbl_module.title module_title, tbl_module.path module_path, tbl_module_group.title module_group_title, tbl_module_group.id module_group_id');
                $this->db->from('tbl_module');
                $this->db->join('tbl_module_group', 'tbl_module.group_id = tbl_module_group.id', "LEFT");
            } else {
                $this->db->select('tbl_user.id, tbl_user.username, tbl_module.id module_id, tbl_module.title module_title, tbl_module.path module_path, tbl_module_group.title module_group_title, tbl_module_group.id module_group_id', false);
                $this->db->from(self::USER_TABLE);
                $this->db->join('tbl_role_module_r', self::USER_TABLE . '.role_id = tbl_role_module_r.role_id', "LEFT");
                $this->db->join('tbl_module', 'tbl_role_module_r.module_id = tbl_module.id', "LEFT");
                $this->db->join('tbl_module_group', 'tbl_module.group_id = tbl_module_group.id', "LEFT");
                $this->db->where('tbl_user.id', $uid);
            }
        } else {
                $this->db->select('tbl_module.id module_id, tbl_module.title module_title, tbl_module.path module_path, tbl_module_group.title module_group_title, tbl_module_group.id module_group_id', false);
                $this->db->from('tbl_role_module_r');
                $this->db->join('tbl_module', 'tbl_role_module_r.module_id = tbl_module.id', "LEFT");
                $this->db->join('tbl_module_group', 'tbl_module.group_id = tbl_module_group.id', "LEFT");
                $this->db->where('tbl_role_module_r.role_id', 2);
        }

        $this->db->order_by('module_group_id asc, module_id asc');
        $q_menu = $this->db->get()->result();
        $group_arr = array();
        $menu_arr = array();
        foreach($q_menu as $_m){
            $group_arr[$_m->module_group_id] = $_m->module_group_title;
        }
        foreach($group_arr as $_gid => $_group){
            $menu_arr[] = (object)array(
                    'title' => $_group,
                    'type' => 'group',
                    'path' => '',
                    'active' => false,
                    );
            foreach($q_menu as $_m){
                if($_m->module_group_id == $_gid){
                    $active = false;
                    if(uri_string() == $_m->module_path){
                        $active = true;
                    }
                    $menu_arr[] = (object)array(
                            'title' => $_m->module_title,
                            'type' => 'module',
                            'path' => $_m->module_path,
                            'active' => $active,
                            );
                }
            }
        }
        return $menu_arr;
    }
    public function update_password($id, $password){
        $this->db->set('password', md5($password));
        $this->db->where('id', $id);
        $res = $this->db->update($this->_table_name);
        return $res;
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

    public function reim_oauth($unionid = '', $openid = '', $token = ''){
        /*
        if('' !== $username && '' !== $password) {
            $jwt = $this->get_jwt($username, $password);
            $this->session->set_userdata('jwt', $jwt);
        } else {
            $jwt = $this->session->userdata('jwt');
        }
		$url = $this->get_url('common/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
         */
        $jwt = $this->get_jwt($unionid, "");
        $this->session->set_userdata('jwt', $jwt);
		$url = $this->get_url('oauth');
        $data = array('openid' => $openid, 'unionid' => $unionid, 'token' => $token);
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
            $profile = $obj['data']['profile'];
            log_message("debug", json_encode($profile));
            // 下载头像
            $avatar = $profile['avatar'];
            if($avatar) {
                $profile['src_avatar'] = $avatar;
                $avatar = 'http://reim-avatar.oss-cn-beijing.aliyuncs.com/' . $avatar;
                $profile['avatar'] = $avatar;//base_url($avatar);
            } else {
            $profile['avatar'] = base_url('/static/default.png');
            }
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }




    public function get_other_member($uid){
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

    public function reim_get_hg_avatar($avatar = 0){
        if($avatar == 0){
            $profile = $this->session->userdata('profile');
            if(array_key_exists('src_avatar', $profile)) {
            // 下载头像
                $avatar = $profile['src_avatar'];
            }
        }
        log_message("debug", "avatar: $avatar");
        return $this->reim_fetch_avatar($avatar, 0);
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

    public function reim_detail($uid){
        $jwt = $this->session->userdata('jwt');
		$url = $this->get_url('profile/' . $uid);
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        log_message("debug", "Get:" . $buf . ",JWT: " . json_encode($jwt));
        if($obj['status'] && $obj['data']['avatar']) {
            $avatar = $obj['data']['avatar'];
            $obj['avatar'] = $this->reim_get_hg_avatar($avatar);
        } else {
            $obj['avatar'] = "";
        }
        return json_encode($obj);
    }
    public function reim_get_info($uid){
        $jwt = $this->session->userdata('jwt');
		$url = $this->get_url('users/' . $uid);
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        log_message("debug", "Get:" . $buf . ",JWT: " . json_encode($jwt));
        if($obj['status'] && $obj['data']['avatar']) {
            $avatar = $obj['data']['avatar'];
            $obj['avatar'] = 'http://reim-avatar.oss-cn-beijing.aliyuncs.com/' . $obj['data']['apath']; //$this->reim_get_hg_avatar($avatar);
        } else {
            $obj['avatar'] = "";
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

    public function reim_update_password($old_password, $new_password){
        $data = array('new_password' => $new_password, 'old_password' => $old_password);
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('users');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function reim_update_profile($email, $phone, $nickname, $credit_card, $uid = 0){
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
        $url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
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

    public function update_credit($id, $account, $cardno, $cardbank, $cardloc) {
        $url = $this->get_url('bank/' . $id);
        $data = array(
            'bank_name' => $cardbank
            ,'bank_location' => $cardloc
            ,'cardno' => $cardno
            ,'account' => $account
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }


    public function new_credit($account, $cardno, $cardbank, $cardloc) {
        $url = $this->get_url('bank');
        $data = array(
            'bank_name' => $cardbank
            ,'bank_location' => $cardloc
            ,'cardno' => $cardno
            ,'account' => $account
        );
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return $buf;
    }

    public function del_credit($id){
        $url = $this->get_url('bank/' . $id);
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
