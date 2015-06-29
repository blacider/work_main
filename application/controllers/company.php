<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
    }

    public function submit(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $this->bsload('company/submit',
            array(
                'title' => '公司设置'
                ,'company' => $company
                ,'error' => $error
                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
                        ,array('url'  => '', 'name' => '提交规则', 'class' => '')
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
                ,'company' => $company
                ,'error' => $error
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
   	$ischecked = $this->input->post('isadmin');
	if($ischecked == 'on')
	{
		$pid = 1;
	}
	else
	{
		$ischecked = 'off';
	}
	$data = $this->company->profile($pid);
        $this->bsload('company/common',
            array(
	    	'id' => $pid 
	    	,'ischecked' => $ischecked
		,'backdata' => $data
		,'title' => '公司设置'
                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                        array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                        ,array('url'  => base_url('company/submit'), 'name' => '公司设置', 'class' => '')
                        ,array('url'  => '', 'name' => '提交规则', 'class' => '')
                    ),
            )
	);
   }
}
