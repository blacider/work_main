<?php

class User_Model extends Reim_Model {

    public function get_user($username, $password){
        $jwt = $this->get_jwt($username, $password);
        $this->session->set_userdata('jwt', $jwt);
		$url = $this->get_url('common/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        $profile = array();
        if($obj['status']){
            $profile = $obj['data']['profile'];
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
        return $this->upload_avatar($file);
    }
}

