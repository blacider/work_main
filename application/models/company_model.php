<?php

class Company_Model extends Reim_Model {
   // const MIN_UID = 100000;
    public function __construct(){
        parent::__construct();
    }

	public function delete_approve($pid)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('audit_policy/'.$pid);
		$buf = $this->do_Delete($url, array(), $jwt);
		log_message("debug","####DeleteAPP:".json_encode($buf));
		return $buf;
	}
	public function show_approve()
	{
		$jwt=$this->session->userdata('jwt');		
		if(!$jwt) return false;
		$url = $this->get_url('audit_policy');
		$data = array();
		$buf = $this->do_Get($url,$jwt);
		log_message('debug',"@@@@:APPRSHOW:".json_encode($buf));
		return $buf;
	}
    	public function create_approve($name,$members,$amount,$policies,$pid=-1)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('audit_policy');
		if($pid == -1)
		{
			$data = array(
				'name'=>$name
				,'members'=>$members
				,'amount'=>$amount
				,'policies'=>$policies
			);
		}
		else
		{
			$data = array(
				'pid'=>$pid
				,'name'=>$name
				,'members'=>$members
				,'amount'=>$amount
				,'policies'=>$policies
			);
		}
		$buf = $this->do_Post($url,$data,$jwt);
		log_message("debug","@@@@APPR:".json_encode($buf));
		return $buf;
	}

	public function delete_rule($pid)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url=$this->get_url('commit_policy/'.$pid);
		$data = array();
		$buf = $this->do_Delete($url,$data,$jwt);
		log_message("debug","######DEL:".json_encode($buf));
	}

	public function show_rules()
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('commit_policy');
		$data = array();
		$buf = $this->do_Get($url,$jwt);
		log_message('debug',"######RULES:".$buf);
		return $buf;
	}

	public function update_rule($rid,$name,$category,$count,$period,$all_company,$groups,$members)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('commit_policy');
		if($all_company==1)
		{
			$data=array(
				'id' => $rid,
				'name'=>$name,
				'category'=>$category,
				'count'=>$count,
				'period'=>$period,
				'all_company'=>$all_company,
			);
		}
		else
		{
			$data=array(
				'pid'=>$rid,
				'name'=>$name,
				'category'=>$category,
				'count'=>$count,
				'period'=>$period,
				'all_company'=>$all_company,
				'groups'=>$groups,
				'members'=>$members,
			);
		}
		$buf = $this->do_Post($url,$data,$jwt);
		log_message("debug","@@@@@:".$buf);
		return $buf;
	}

	public function create_rule($name,$category,$count,$period,$all_company,$groups,$members)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('commit_policy');
		if($all_company==1)
		{
			$data=array(
				'name'=>$name,
				'category'=>$category,
				'count'=>$count,
				'period'=>$period,
				'all_company'=>$all_company,
			);
		}
		else
		{
			$data=array(
				'name'=>$name,
				'category'=>$category,
				'count'=>$count,
				'period'=>$period,
				'all_company'=>$all_company,
				'groups'=>$groups,
				'members'=>$members,
			);
		}
		$buf = $this->do_Post($url,$data,$jwt);
		log_message("debug","@@@@@:".$buf);
		return $buf;
	}
        public function get(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $url = $this->get_url('company_admin');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    /*public function profile($same_category, $template, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'config' => $config
            ,
        );
        $url = $this->get_url('company_admin');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }*/

     public function profile($config, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'config' => json_encode($config)
            ,
        );

        $url = $this->get_url('company_admin');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function update($cid, $name, $pid, $prove_ahead = 0, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
        );
        $url = $this->get_url('category/' . $cid);
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($cid){
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . $jwt);
        if(!$jwt) return false;
        $url = $this->get_url('category/' . $cid);
        $buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

}
