<?php

class UserGroup_Model extends Reim_Model {
    public function get_my_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('user_group/list');
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function create_group($manager,$uids,$name,$code,$pid,$images)
    {
           $jwt = $this->session->userdata('jwt');
           if(!$jwt) return false;
                $data = array(
                    'name' => $name
                    ,'uids' => $uids
                    ,'pid' => $pid
		            ,'manager' => $manager
                    ,'code' => $code
                    ,'images' => $images
            );
            $url = $this->get_url('user_group');
            $buf = $this->do_Post($url,$data,$jwt);
            $obj = json_decode($buf,true);
            return $obj;
    }

    public function update_data($manager,$uids, $name,$code,$pid,$gid = 0,$images){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'manager' => $manager
            ,'name' => $name
	        ,'code' => $code
            ,'uids' => $uids
	        ,'pid' => $pid
            ,'id' => $gid
            ,'images' => $images
        );
        log_message("debug", json_encode($data));
		$url = $this->get_url('user_group');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "#####".$buf."####");
		$obj = json_decode($buf, true);
        return $obj;
    }
    public function delete_group($id) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array();
		$url = $this->get_url('user_group/' . $id);
		$buf = $this->do_Delete($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }


    public function get_single_group($id) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array();
		$url = $this->get_url('user_group/single/' . $id);
        log_message("debug", "URL: $url");
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }
}
