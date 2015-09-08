<?php

class Reim_Show_Model extends Reim_Model {
	public function usergroups()
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;

		$url = $this->get_url('user_group/list');
		$buf = $this->do_Get($url, $jwt);
		$obj = json_decode($buf, true);
		$usergroups = array();
		if($obj['status']>0)
		{
			$data = $obj['data']['group'];
			foreach($data as $g)
			{
				array_push($usergroups,array('id' => $g['id'],'name' => $g['name']));
				}
		}
		log_message('debug','usergroup:' . json_encode($usergroups));
        return $usergroups;
    	}
	public function rank_level($rank = 1)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;

		$url = $this->get_url('rank/' . $rank);
		$buf = $this->do_Get($url,$jwt);

		log_message('debug','rank:' . json_encode($buf));
		return json_decode($buf,True);
	}

	/*
	public function company_members()
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;

		$url = $this->get_url('groups/0');
		$buf = $this->do_Get($url, $jwt);
        	log_message("debug", "model:" . $buf);

		$obj = json_decode($buf,True);
		$members = array();
		if($obj['status']>0)
		{
			$members = $obj['data']['gmember'];	
		}
		return $members;
	}
	*/

}
