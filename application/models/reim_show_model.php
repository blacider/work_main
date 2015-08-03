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
}
