<?php

class Group_Model extends Reim_Model { 
   

    public function set_managers($persons)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('load');
    	$data = array();
    	//$data = $persons;
	foreach($persons as $p){
		array_push($data, $p);
	}
	
	$data = array('relations' => json_encode($data));

	//log_message('debug','xxx set_managers:' . json_encode($data));
	$buf = $this->do_Put($url,$data,$jwt);

	log_message('debug','set_managers:' . $buf);
	return json_decode($buf,True);
    }

    public function reim_imports($data)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('load');
        $buf = $this->do_Post($url,$data,$jwt);

        log_message('debug','imports_back:' . json_encode($buf));
        return json_decode($buf,True);
    }
    public function update_rank_level($rank,$id,$name)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        $url = $this->get_url('rank');
        $data = array
            (
                'name' => $name
                ,'rank' => $rank
                ,'id' => $id
            );
        $buf = $this->do_Put($url,$data,$jwt);
        log_message('debug','update_rank_level : ' . json_encode($buf));

        return json_decode($buf,True);

    }

    public function del_rank_level($rank,$id)
    {
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;

		$url = $this->get_url('rank/' . $id . '/'  . $rank);
		$buf = $this->do_Delete($url,array(),$jwt);

		log_message('debug','delete_rank:' . json_encode($buf));
		
		return json_decode($buf,True);
    }
    public function get_rank_level($rank)
    {
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;

		$url = $this->get_url('rank/' . $rank);
		$buf = $this->do_Get($url,$jwt);

		log_message('debug','rank:' . json_encode($buf));
		return json_decode($buf,True);
    }

    public function create_rank_level($rank,$name,$uids='')
    {
    	$jwt = $this->session->userdata('jwt');
	if(!$jwt) return false;

	$url = $this->get_url('rank');
	$data = array
		(
		  'name' => $name
		  ,'rank' => $rank
		);
	$buf = $this->do_Post($url,$data,$jwt);
	log_message('debug','create_rank_level : ' . json_encode($buf));

	return json_decode($buf,True);
    }

    public function get_my_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('groups/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function doimports($username, $nickname, $phone, $admin, $groups, $account, $cardno, $cardbank, $cardloc, $manager, $rank = 0,  $level = 0){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('users' => json_encode(
            array(
                array(
                    'email' => $username
                    ,'phone' => $phone
                    ,'name' => $nickname
                    ,'admin' => $admin
                    ,'groups' => $groups
                    ,'account' => $account
                    ,'cardno' => $cardno
                    ,'cardbank' => $cardbank
                    ,'cardloc' => $cardloc
                    ,'manager_id' => $manager
                    ,'rank' => $rank
                    ,'level' => $level
                )
            )
        ));
		$url = $this->get_url('imports');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    // type : -0 邮箱 1 手机
    public function set_invite($username, $nickname, $phone, $credit, $groups){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $username, 'phone' => $phone, 'nickname' => $nickname, 'credit_card' => $credit, 'groups' => $groups);
		$url = $this->get_url('invite');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function change_group_name($name){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $name);
		$url = $this->get_url('groups');
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		//$obj = json_decode($buf, true);
        return $buf;
    }

    public function setadmin($uid, $_type){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('admin' => $_type, 'uid' => $uid);
		$url = $this->get_url('set_admin');
        log_message("debug", "Admin Data:" . json_encode($data));
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }

    public function create_group($name){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('name' => $name);
		$url = $this->get_url('groups');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }


    public function update_profile($nickname, $email, $phone, $credit_card, $admin, $id){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array('admin' => $admin, 'uid' => $id, 'credit_card' => $credit_card, 'email' => $email, 'phone' => $phone);
		$url = $this->get_url('users');
		log_message("debug", "Admin Data:" . json_encode($data));
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
        return $buf;
    }

    public function get_by_id($gid){
        log_message("debug", "Reim Get Group by id");
        $jwt = $this->session->userdata('jwt');
		$url = $this->get_url('groups/' . $gid);
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }


    public function remove_user($uid = 0){
        log_message("debug", "Reim Get Group by id");
        $jwt = $this->session->userdata('jwt');
		$url = $this->get_url('staff/' . $uid);
		$buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

}

