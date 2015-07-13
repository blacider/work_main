<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
       $this->load->model('group_model', 'groups');
       $this->load->model('usergroup_model','ug');
       $this->load->model('account_set_model','account_set');
       $this->load->model('category_model','category');
    }
    public function update_approve()
    {
    	
    }
    public function delete_approve($pid)
    {
    	$error = $this->session->userdata('last_error');
	$buf = $this->company->delete_approve($pid);
	log_message("debug","###delte:".json_encode($buf));
	return redirect(base_url('company/show_approve'));
    	
    }

    public function approve_update($pid)
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$buf = $this->company->show_approve();
	$info=json_decode($buf,true);
	$_info=$info['data'];
	$own_rule = $_info[$pid];
	
    	$category = $this->category->get_list();
	$categories = $category['data']['categories'];
	$sobs = $this->account_set->get_account_set_list();
	$_sobs = $sobs['data'];
	$s_id ='';
	$s_name = '';
	$c_name = '';
	$c_id = '';
	log_message('debug','%%%%%%%%%%'.json_encode($own_rule['categories']));

        $_group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = $_gnames['data']['group'];

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
	$this->bsload('company/update_approve',
		array(
			'title'=>'修改审批'
			,'error'=>$error
			,'rule'=>$own_rule
			,'member'=>$gmember
			,'group'=>$gnames
			,'c_id' => $c_id
			,'c_name'=>$c_name
			,'s_id' => $s_id
			,'s_name'=>$s_name
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'修改审批','class'=>'')
			),
		)
	);
	
    }

    public function show_approve()
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$buf = $this->company->show_approve();

	$rules = json_decode($buf,true);
	$this->bsload('company/show_approve',
		array(
			'title'=>'审批规则'
			,'error'=>$error
			,'rules'=>$rules['data']
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'审批规则','class'=>'')
			),
		)
	);
    	
    }

    public function create_approve()
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	
	$rname = $this->input->post('rule_name');
	$sob_id = $this->input->post('sobs');
	$category_id = $this->input->post('category');
	$amount = $this->input->post('category_amount');
	$total_amount = $this->input->post('total_amount');
	$members = $this->input->post('uids');
	$all_members = $this->input->post('all_members');
    	
//	$info = array('category'=>$category_id,'amount'=>$amount);
	$policy =array(array('category'=>$category_id,'amount'=>$amount));
//	array_push($policy,$info);
	$buf = $this->company->create_approve($rname,implode(',',$members),$total_amount,json_encode($policy),$pid=-1);
	return redirect(base_url('company/show_approve'));

    }

    public function approve()
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = $_gnames['data']['group'];

        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
	$this->bsload('company/approve',
		array(
			'title'=>'新建审批'
			,'error'=>$error
			,'member'=>$gmember
			,'group'=>$gnames
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'新建审批','class'=>'')
			),
		)
	);

    }

    public function update($id)
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$buf = $this->company->show_rules();
	$info=json_decode($buf,true);
	$_info=$info['data'];
	$own_rule = array();
	
    	$category = $this->category->get_list();
	$categories = $category['data']['categories'];
	$sobs = $this->account_set->get_account_set_list();
	$_sobs = $sobs['data'];
	foreach($_info as $item)
	{
		if($item['id']==$id)
		{
			$own_rule = $item;
		}
	}
	foreach($categories as $c)
	{
		if($c['id'] == $own_rule['category'])
		{
			$c_name = $c['category_name'];
			$s_id = $c['sob_id'];
		}
	}
	foreach($_sobs as $s)
	{
		if($s['sob_id'] == $s_id)
		{
			$s_name = $s['sob_name'];
		}
	}

        $_group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = $_gnames['data']['group'];

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
	$this->bsload('company/update',
		array(
			'title'=>'修改规则'
			,'error'=>$error
			,'rule'=>$own_rule
			,'member'=>$gmember
			,'group'=>$gnames
			,'c_id' => $own_rule['category']
			,'c_name'=>$c_name
			,'s_id' => $s_id
			,'s_name'=>$s_name
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'修改规则','class'=>'')
			),
		)
	);
    	
    }

    public function update_rule()
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$id = $this->input->post('rid');
	$rname = $this->input->post('rule_name');
	$sob_id = $this->input->post('sobs');
	$category_id = $this->input->post('category');
	
	$amount = $this->input->post('rule_amount');
	$amount_unlimit = $this->input->post('amount_unlimit');
	$amount_time = $this->input->post('amount_time');
	
	$frequency = $this->input->post('frequency');
	$frequency_unlimit = $this->input->post('frequency_unlimit');
//	$frequency_time = $this->input->post('frequency_time');
	$frequency_time = 1;

	$groups = $this->input->post('gids');
	$members = $this->input->post('uids');
	$all_members = $this->input->post('all_members');

	if($frequency == '')
	{
		$frequency = 0;
	}
	 if($frequency_unlimit == '')
	{
		$frequency_unlimit = 0;
	}
	 if($all_members == '')
	{
		$all_members = 0;
	}
	if($frequency_unlimit == 1)
	{
		$frequency = -1;
	}
	if($all_members == 1)
	{
		$groups = array();
		$members = array();
	}
	log_message('debug',"####:".json_encode($groups));
	
	$start_time = $this->input->post('sdt');
	$end_time = $this->input->post('edt');
	$buf=$this->company->update_rule($id,$rname,$category_id,$frequency,$frequency_time,$all_members,implode(',',$groups),implode(',',$members));	
	log_message("debug","####CREATE:".json_encode($buf));
	    	return redirect(base_url('company/show'));
    }
    public function delete_rule($pid)
    {
    	$error = $this->session->userdata('last_error');
	$buf = $this->company->delete_rule($pid);
	log_message("debug","###delte:".json_encode($buf));
	return redirect(base_url('company/show'));
    }

    public function create_rule()
    {
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	
	$rname = $this->input->post('rule_name');
	$sob_id = $this->input->post('sobs');
	$category_id = $this->input->post('category');
	
	$amount = $this->input->post('rule_amount');
	$amount_unlimit = $this->input->post('amount_unlimit');
	$amount_time = $this->input->post('amount_time');
	
	$frequency = $this->input->post('frequency');
	$frequency_unlimit = $this->input->post('frequency_unlimit');
//	$frequency_time = $this->input->post('frequency_time');
	$frequency_time = 1;

	$groups = $this->input->post('gids');
	$members = $this->input->post('uids');
	$all_members = $this->input->post('all_members');

	if($frequency == '')
	{
		$frequency = 0;
	}
	 if($frequency_unlimit == '')
	{
		$frequency_unlimit = 0;
	}
	 if($all_members == '')
	{
		$all_members = 0;
	}
	if($frequency_unlimit == 1)
	{
		$frequency = -1;
	}
	if($all_members == 1)
	{
		$groups = array();
		$members = array();
	}
	log_message('debug',"####:".json_encode($groups));
	
	$start_time = $this->input->post('sdt');
	$end_time = $this->input->post('edt');
	$buf=$this->company->create_rule($rname,$category_id,$frequency,$frequency_time,$all_members,implode(',',$groups),implode(',',$members));	
	log_message("debug","####CREATE:".json_encode($buf));
	    	return redirect(base_url('company/show'));
    }

    public function show(){
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$buf = $this->company->show_rules();
	$rules = json_decode($buf,true);
	$this->bsload('company/show',
		array(
			'title'=>'新建规则'
			,'error'=>$error
			,'rules'=>$rules['data']
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'新建规则','class'=>'')
			),
		)
	);
    }

    public function create(){
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $_gnames = $this->ug->get_my_list();
        $gnames = $_gnames['data']['group'];

        $gmember = array();
        if($group) {
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }
	$this->bsload('company/create',
		array(
			'title'=>'新建规则'
			,'error'=>$error
			,'member'=>$gmember
			,'group'=>$gnames
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'提交规则','class'=>'')
			),
		)
	);
    }

    public function common(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/common',
            array(
                'title' => '公司设置'
                ,'company' => $company['data']['config']
                ,'error' => $error

                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
                        ,array('url'  => '', 'name' => '通用规则', 'class' => '')
                    ),
            )
        );
    }
    public function getsetting()
    {
        $company = $this->company->get();
        $config = $company['data']['config'];
        die($config);
    }
/*
public function common(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $_group = $this->groups->get_my_list();
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/common',
            array(
                'title' => '公司设置'
                ,'company' => $company
                ,'error' => $error
                ,'groups' => json_encode($_group)
                    ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
			,array('url' => '','name' => '通用规则','class' => '')
                    ),	
            )
        );
    }
*/
    public function review(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/review',
            array(
                'title' => '审核规则'
                ,'company' => $company
                ,'error' => $error
                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
                        ,array('url'  => '', 'name' => '审核规则', 'class' => '')
                    ),
            )
        );
    }


    public function setting(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/setting',
            array(
                'title' => '公司通用设置'
                ,'company' => $company
                ,'error' => $error
                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
                        ,array('url'  => '', 'name' => '公司通用设置', 'class' => '')
                    ),
            )
        );
    }
   public function profile()
   {
   	$pids = 0;
	$remark_id = 0;
   	$ischecked = $this->input->post('ischecked');
	$isremark = $this->input->post('isremark');
	$template = $this->input->post('template');
	$user_confirm = $this->input->post('limit');
	$reports_limit = $this->input->post('reports_limit');
	if($ischecked == "true")
	{
		$pids = 1;
	}
	if($isremark == "true")
	{
		$remark_id = 1;
	}
	$data = $this->company->get();
//	$config = $data['data']['config'];
//	if(array_key_exists('same_category',$confarr))
//	{
//		$confarr['same_category'] = $pid;
//	}
//	if(array_key_exists('template',$confarr))
//	{
//		$confarr['template'] = $template;
//	}
	log_message("debug","@@@@@@@@@@@@:$ischecked++++$pids");
	$in=array();
	$in['same_category'] = $pids;
	$in['export_no_note'] = $remark_id;
	$in['template'] = $template;
	$in['user_confirm'] = $user_confirm;
	$in['report_quota'] = $reports_limit;
	$this->company->profile($in);
	$re = array('name' => $ischecked,'remark'=>$isremark,'template' => $template,'obj' => $data['data']['config']);
	die(json_encode($re));
   }
}
