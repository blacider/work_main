<?php

class User_Model extends Reim_Model {

    private function _fetch_avatar($path, $type = 1){
        $new_file_path = "/static/users_data/". md5($path . $type) . ".jpg";
        if(file_exists(BASEPATH . "../" . $new_file_path)) return $new_file_path;
        
        $jwt = $this->session->userdata('jwt');
		$url = $this->get_url($path . "/" . $type);
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "Avatar:" . $new_file_path . ", with length:" . strlen($buf) . ", FromURL:" . $url);
        file_put_contents(BASEPATH . "../" . $new_file_path, $buf);
        return $new_file_path;
    }

    public function get_user($username, $password){
        $jwt = $this->get_jwt($username, $password);
        $this->session->set_userdata('jwt', $jwt);
		$url = $this->get_url('common/0');
        log_message("debug", "in get user : request [ $url ]");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "in get user :success ");
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        $profile = array();
        if($obj['status']){
            $profile = $obj['data']['profile'];
            // 下载头像
            $avatar = $profile['avatar'];
            $profile['src_avatar'] = $avatar;
            $avatar = $this->_fetch_avatar($avatar);
            $profile['avatar'] = base_url($avatar);
            log_message("debug", json_encode($profile));
            $this->session->set_userdata('profile', $profile);
        }
        return $obj;
    }


    public function register($email = '', $password = '', $phone = '', $code = ''){
        $data  = array('email' => $email, 'password' => $password, 'phone' => $phone, 'code' => $code);
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function update_nickname($id, $nickname) {
        $data = array('nickname' => $nickname, 'uid' => $id);
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function update_manager($id, $manager_id) {
        $data = array('manager_id' => $manager_id, 'uid' => $id);
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        //$obj = json_decode($buf, true);
        //return $obj;
        return $buf;
    }


    public function update_profile($email = '', $phone = '', $nickname = ''){
        $profile = $this->session->userdata('profile');
        $data = array('nickname' => $nickname
            ,'uid' => $profile['id']
            ,'email' => $email
            ,'phone' => $phone
        );
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        //$obj = json_decode($buf, true);
        //return $obj;
        return $buf;
    }

    public function update_password($old_password, $new_password){
        $profile = $this->session->userdata('profile');
        $data = array('new_password' => $new_password
            ,'old_password' => $old_password
        );
		$url = $this->get_url('users');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        //$obj = json_decode($buf, true);
        //return $obj;
        return $buf;
    }


    private function upload_avatar($file){
        log_message("debug", realpath($file));
        $sfile = realpath($file); //要上传的文件
        $data = array();
        $data['file'] = new CURLFile($sfile);//'@'.$sfile;
        $data['type'] = 0;
		$url = $this->get_url('images');
        $jwt = $this->session->userdata('jwt');
        log_message("debug", json_encode($jwt));
        log_message("debug", json_encode($data));
        log_message("debug", $url);
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        return json_decode($buf, true);
    }

    public function update_avatar($file) {
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


    public function get_hg_avatar(){
        $profile = $this->session->userdata('profile');
        // 下载头像
        $avatar = $profile['src_avatar'];
        log_message("debug", "avatar: $avatar");
        return $this->_fetch_avatar($avatar, 3);
    }

    public function joingroup($code) {
        $jwt = $this->get_jwt('', '');
        //$this->session->set_userdata('jwt', $jwt);
		$url = $this->get_url('invite/' . $code);
        log_message("debug", "in get user : request [ $url ]");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "in get user :success ");
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
}

