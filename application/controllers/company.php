<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
       $this->load->model('group_model', 'groups');
    }

    public function show(){
    	$error = $this->session->userdata('last_error');
	$this->session->unset_userdata('last_erro');
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
	$this->session->unset_userdata('last_erro');
	$this->bsload('company/rule',
		array(
			'title'=>'提交规则'
			,'error'=>$error
			,'breadcrumbs'=> array(
				array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
				,array('url'=>base_url('company/submit'),'name'=>'公司设置','class'=> '')
				,array('url'=>'','name'=>'提交规则','class'=>'')
			),
		)
	);
    }

    public function submit(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/submit',
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
   	$pid = 0;
   	$ischecked = $this->input->post('ischecked');
	$template = $this->input->post('template');
	$user_confirm = $this->input->post('limit');
	if($ischecked == true)
	{
		$pid = 1;
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
	
	$in=array();
	$in['same_category'] = $pid;
	$in['template'] = $template;
	$in['user_confirm'] = $user_confirm;
	$this->company->profile($in);
	$re = array('name' => $ischecked,'template' => $template,'obj' => $data['data']['config']);
	die(json_encode($re));
   }
}
