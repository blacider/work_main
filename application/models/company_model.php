<?php

class Company_Model extends Reim_Model {
   // const MIN_UID = 100000;
    public function __construct(){
        parent::__construct();
    }

    public function deny_report_finance($rid)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_finance_flow/deny/' . $rid );

        $buf = $this->do_Post($url,array(),$jwt);
        log_message("debug", 'report_finance_deny: ' . $buf);
        log_message("debug", 'url: ' . $url);

        $obj = json_decode($buf, true);
        return $obj;
    }
    public function pass_report_finance($rid)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_finance_flow/pass/' . $rid );

        $buf = $this->do_Post($url,array(),$jwt);
        log_message("debug", 'report_finance_pass: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_report_finance_permission($rid)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_finance_flow/check_permission/' . $rid);

        $buf = $this->do_Get($url,$jwt);
        log_message("debug", 'report_finance_permission: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    
    public function report_property_delete($id)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_property/' . $id);

        $buf = $this->do_Delete($url,$data,$jwt);
        log_message("debug", 'report_property_delete: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function report_property_update($name,$config,$id)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_property/' . $id);

        $data = array('name' => $name, 
              'config' => $config);
        $buf = $this->do_Put($url,$data,$jwt);
        log_message("debug", 'report_property_update: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function report_property_create($name,$config)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_property');

        $data = array('name' => $name, 
              'config' => $config);
        $buf = $this->do_Post($url,$data,$jwt);
        log_message("debug", 'report_property_create: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    
    public function get_single_reports_settings($id)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_property/' . $id);
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", 'report_property_single: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_reports_settings_list()
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('report_property/0');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", 'report_property_list: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
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
    	public function create_approve($name,$members,$amount,$allow_all_category,$policies,$pid=-1,$ranks,$levels,$groups)
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
				,'allow_all_category'=>$allow_all_category
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
				,'allow_all_category'=>$allow_all_category
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

	public function update_rule($rid,$name,$category,$count,$period,$all_company,$groups,$members,$ranks,$levels)
	{
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('commit_policy');
		if($all_company==1)
		{
			$data=array(
				'pid' => $rid,
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

	public function create_update_rules($name,$ugids,$mems,$level,$rank,$policies,$all_company,$pid=0)
	{
		log_message('debug','pid:' . $pid);
		$jwt = $this->session->userdata('jwt');
		if(!$jwt) return false;
		$url = $this->get_url('commit_policy');
		
		$data = array(
			'name'=>$name,
			'groups'=>$ugids,
			'members'=>$mems,
			'levels'=>$level,
			'ranks'=>$rank,
			'policies'=>$policies,
			'all_company'=>$all_company
		);

		if($pid == 0)
		{
			log_message('debug','create_rules_data:' . json_encode($data));
			$buf = $this->do_Post($url,$data,$jwt);	
		}
		else
		{
			$data['pid'] = $pid;
			log_message('debug','update_rules_data:' . json_encode($data));
			$buf = $this->do_Post($url,$data,$jwt);
		}

		log_message('debug','create_update_rules:' . $buf);
		return json_decode($buf,True);
	}

	public function create_rule($name,$category,$count,$period,$all_company,$groups,$members,$ranks,$levels)
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
        log_message("debug", 'company_common ' . $buf);
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


    public function create_finance_policy($name) {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('finance_policy');
        $buf = $this->do_Post($url, array('name' => $name), $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }


    public function get_finance_policy(){
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('finance_policy');
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function get_single_finance_policy($id)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('finance_policy/' . $id);
        log_message('debug' , 'url: ' . $url);
        $buf = $this->do_Get($url, $jwt);
        log_message("debug", 'finace_policy_single: ' . $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }
    public function drop_finance_policy($id) {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $url = $this->get_url('finance_policy/' . $id);
        $buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
        $obj = json_decode($buf, true);
        return $obj;
    }

    public function update_finance_policy($fid,$name,$policies,$gids)
    {
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . json_encode($jwt));
        if(!$jwt) return false;
        $data = array('name' => $name,
                      'step' => $policies,
                      'gid' => $gids
                );
        $url = $this->get_url('finance_policy/' . $fid);
        $buf = $this->do_Put($url,$data,$jwt);
        log_message("debug", 'finace_policy_update: ' . $buf);
        log_message("debug", 'data: ' . json_encode($data));
        $obj = json_decode($buf, true);
        return $obj;
    }

}
