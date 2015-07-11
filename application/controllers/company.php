<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
       $this->load->model('group_model', 'groups');
       $this->load->model('usergroup_model','ug');
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
	$frequency_time = $this->input->post('frequency_time');

	$groups = $this->input->post('gids');
	$members = $this->input->post('uids');
	$all_members = $this->input->post('all_members');

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
	$this->bsload('company/show',
		array(
			'title'=>'test'
			,'sdt' => $start_time
			,'edt' => $end_time
			,'sob_id' => $sob_id
			,'unlimit' => $frequency_unlimit
			,'name' => $rname
			,'category_id' => $category_id
			,'count'=>$frequency
			,'peroid'=>$frequency_time
			,'groups'=>$groups
			,'members'=>$members
			,'all_mem'=>$all_members
			,'breadcrumbs' => array(
				
			),
		)	
	);
    }

    public function show(){
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_error');
	$this->bsload('company/show',
		array(
			'title'=>'新建规则'
			,'error'=>$error
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
	$this->company->profile($in);
	$re = array('name' => $ischecked,'remark'=>$isremark,'template' => $template,'obj' => $data['data']['config']);
	die(json_encode($re));
   }
}
