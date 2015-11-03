<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('company_model', 'company');
        $this->load->model('group_model', 'groups');
        $this->load->model('usergroup_model','ug');
        $this->load->model('account_set_model','account_set');
        $this->load->model('category_model','category');
    	$this->load->model('reim_show_model','reim_show');
    	$this->load->model('report_model','reports');
    }
    
    public function dodelete_report_template($id)
    {
        $buf = $this->reports->delete_report_template($id); 
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除成功');
        }
        else if($buf['status'] <= 0)
        {
            $this->session->set_userdata('last_error',$buf['data']['msg']);
        }
        else
        {
            $this->session->set_userdata('last_error','删除失败');
        }

        return redirect('company/report_template_list');
    }

    public function doupdate_report_template()
    {
        $temp_info = $this->input->post('temp_info');
        
        log_message('debug','temp_info:' . json_encode($temp_info));
        $status = 0;
        $msg = '更新失败';
        if(!array_key_exists('id',$temp_info))
        {
            log_message('debug','has no id');
            $msg = '没有模板信息,更新失败';
            $this->session->set_userdata('debug','没有模板信息,更新失败');
        }
        $id = $temp_info['id'];
        $template_name = '';
        if(array_key_exists('name',$temp_info))
        {
            $template_name = $temp_info['name'];
        }
        $type = '';
        if(array_key_exists('type',$temp_info))
        {
            $type = implode(',',$temp_info['type']);
        }
        $_config = array();
        if(array_key_exists('config',$temp_info))
        {
            $_config = $temp_info['config'];
        }

        $config = array();
        log_message('debug','_config:' . json_encode($_config));
        if($_config)
        {
            foreach($_config as $conf)
            {
                /* 设置每个字段组的默认值*/
                $temp_group = array('name' => '','type' => 0,'printable' => 0, 'children' => array());
                if(array_key_exists('name',$conf))
                {
                    $temp_group['name'] = $conf['name'];
                }
                if(array_key_exists('type',$conf))
                {
                    $temp_group['type'] = $conf['type'];
                }
                if(array_key_exists('printable',$conf))
                {
                    $temp_group['printable'] = $conf['printable'];
                }
                if(array_key_exists('children',$conf))
                {
                    /*取出每个字段的数据*/
                    foreach($conf['children'] as $child)
                    {
                        $temp_child = array();
                        foreach($child as $key => $value) 
                        {
                            if($key == 'nid') continue; 
                            $temp_child[$key] = $value;
                        }
                        array_push($temp_group['children'],$temp_child);
                    }
                }

                array_push($config,$temp_group);
            }
        }
        
        log_message('debug','config:' . json_encode($config));
        $buf = $this->reports->update_report_template($id,$template_name,$config,$type);
        if($buf['status'] > 0)
        {
            $status = 1;
            $msg = '更新成功';
            $this->session->set_userdata('debug','更新成功');
        }
        else
        {
            $msg = $buf['data']['msg'];
        }

        die(json_encode(array('status' => $status,'msg' => $msg)));
    }

    public function docreate_report_template()
    {
        $template_name = $this->input->post('template_name');
//        $config = $this->input->post('config');
        $config = json_encode(array());
        $buf = $this->reports->create_report_template($template_name,$config);
        $msg = '';
        $id = -1 ;
        if($buf['status'] > 0)
        {
            $id = $buf['data']['id'];
            $this->session->userdata('last_error','创建成功');
        }
        else
        {
            $this->session->userdata('last_error',$buf['data']['msg']);
        }

//        return redirect(base_url('company/report_template_list'));
        die(json_encode(array('id'=>$id)));
    }

    public function update_report_template($id)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $report_template = array();
        $_report_template = $this->reports->get_report_template($id);
        if($_report_template['status'] > 0) 
        {
            $report_template = $_report_template['data'];
        }
//        $item_type_dic = $this->reim_show->
        $this->bsload('reports/update_report_template',
            array(
                    'title'=>'修改报告模板',
                    'report_template' => $report_template
                    ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'修改报告模板','class'=>'')
                ),
            )
        );
    }

    public function create_report_template()
    {
        $this->bsload('reports/create_report_template',
            array(
                    'title'=>'新建报告模板',
                    'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'修改报告模板','class'=>'')
                ),
            )
        );
    }

    public function report_template_list()
    {
        $report_template_list = array();
        $_report_template_list = $this->reports->get_report_template();
        if($_report_template_list['status'] > 0)
        {
            $report_template_list = $_report_template_list['data'];
        }

        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $this->bsload('reports/report_template_list',
            array(
                'template_list' => $report_template_list
                ,'error' => $error
                ,'title'=>'报告模板'
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'报告模板','class'=>'')
                ),
            )
        );
    }

    public function report_settings_update($id)
    {
        $buf = $this->company->get_single_reports_settings($id); 
        $setting = array();
        if($buf['status'] > 0)
        {
            $setting = $buf['data'];
        }
        $_config = $setting['config'];
        $config = json_decode($_config,true);
        log_message('debug','logo:' . $config['logo']);
        $this->bsload('company/report_settings_update',
            array(
                'images'=>$config['logo']
                ,'title'=>'修改报告模板'
                ,'setting'=>$setting
                ,'id'=>$id
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'修改报告模板','class'=>'')
                ),
            )
        );
    }

    public function report_property_delete($id)
    {
        $buf = $this->company->report_property_delete($id); 

        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除成功');
        }
        else
        {
            $this->session->set_userdata('last_error','删除失败');
        }

        return redirect('company/report_settings_list');
    }
    public function report_property_new($id=0)
    {
        $name = $this->input->post('report_property_name');
        $borrowing = $this->input->post('borrowing');
        $location = $this->input->post('location');
        $period = $this->input->post('period');
        $account = $this->input->post('account');
        $payment = $this->input->post('payment');
        $contract = $this->input->post('contract');
        $note = $this->input->post('note');
        $images = $this->input->post('images');

        $config = array();
        $config['borrowing'] = $borrowing;
        $config['location'] = $location;
        $config['period'] = $period;
        $config['account'] = $account;
        $config['payment'] = $payment;
        $config['contract'] = $contract;
        $config['note'] = $note;
        $config['logo'] = $images;
        log_message('debug', 'config : ' . json_encode($config));
        foreach($config as $key => $value)
        {
            if($value == '')
            {
                $config[$key] = "0";
            }
        }
        log_message('debug', 'config : ' . json_encode($config));
        if($id == 0)
        {
            $buf = $this->company->report_property_create($name,json_encode($config));
                if($buf['status'] > 0)
                {
                    $this->session->set_userdata('last_error','添加成功');
                }
                else
                {
                    $this->session->set_userdata('last_error','添加失败');
                }
        }
        else
        {
            $buf = $this->company->report_property_update($name,json_encode($config),$id);
                if($buf['status'] > 0)
                {
                    $this->session->set_userdata('last_error','修改成功');
                }
                else
                {
                    $this->session->set_userdata('last_error','修改失败');
                }
        }

        return redirect('company/report_settings_list');
    }
    public function report_settings_new()
    {
        $this->bsload('company/report_settings_new',
            array(
                'title'=>'新建报告模板'
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'新建报告模板','class'=>'')
                ),
            )
        );
    }

    public function report_settings_list()
    {
        $settings = array();
        $_settings = $this->company->get_reports_settings_list();
        if($_settings['status'] > 0)
        {
            $settings = $_settings['data'];
        }

        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->bsload('company/report_settings',
            array(
                'title'=>'报告设置'
                ,'report_settings'=>$settings
                ,'error'=>$error
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'报告设置','class'=>'')
                ),
            )
        );
    }

    public function flow_finance_update($fid)
    {
        $this->need_group_it();
        $gids = $this->input->post('gids');
        $name = $this->input->post('name');
        if(!$fid)
        {
            return redirect('/company/approval_flow');
        }
        $_steps = $this->input->post('steps');
        log_message('debug','steps:' . $_steps);
        $policy = array();
        $policies = array();

        $steps = json_decode($_steps,True);
        $count = 1;
        foreach($steps as $s)
        {
            $policy = array('uids' => $s['uids'] , 'quota' => $s['quota'] , 'step' => $count);
            array_push($policies,$policy); 
            $count++;
        }
        
        log_message('debug','update_policy:' . json_encode($policies));
        $buf = $this->company->update_finance_policy($fid,$name,json_encode($policies),$gids);

        if($buf['status'] > 0)
        {
            die(json_encode(array('status'=>1)));
        }
        else
        {
            die(json_encode(array('status'=>0)));
        }
            
        /*
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','更新成功');
        }
        else
        {
            $this->session->set_userdata('last_error','更新成功');
        }
        */
        
       // return redirect('/company/approval_flow');
    }
    public function flow_update($id = 0)
    {
        $_group = $this->groups->get_my_list();

        $gmember = array();
        if($_group) {
            if(array_key_exists('gmember', $_group['data'])){
                $gmember = $_group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }

        $members = array();
        $mem_dic = array();
        foreach($gmember as $gm)
        {
            $mem_dic[$gm['id']] = $gm['nickname'];
            if($gm['admin']==1 || $gm['admin']==2)
            {
                array_push($members,$gm); 
            }
        }
        
        $gnames = array();
        $_gnames = $this->ug->get_my_list();
        if($_gnames['status'] > 0)
        {
            $gnames = $_gnames['data']['group'];
        }

        $buf = $this->company->get_single_finance_policy($id);
        $policies = array();
        $step_dic = array(); //做一个步骤的字典
        if($buf['status'] > 0)
        {
           $policies = $buf['data']; 
        }
        log_message('debug','policies:' . json_encode($policies));
        if(array_key_exists('step',$policies))
        {
            foreach($policies['step'] as &$st)
            {
                if(!array_key_exists($st['step'],$step_dic)) 
                {
                    $step_dic[$st['step']] = array('step' => $st['step'] , 'quota' => $st['quota'] , 'uids' => array() , 'nicknames' => array());
                }

                $_uids = $st['uids']; 
                $_names = array();
                foreach($_uids as $u)
                {
                    if(array_key_exists($u,$mem_dic))
                    {
                         array_push($step_dic[$st['step']]['uids'],$u);
                         array_push($step_dic[$st['step']]['nicknames'],$mem_dic[$u]);
                    }
                }
            }

            $policies['step'] = array();
            foreach($step_dic as $k => &$v)
            {
                $v['nicknames'] = implode('|',$v['nicknames']); 
                array_push($policies['step'],$v);
            }
        }

            
        log_message('debug','policies:' . json_encode($policies));
        log_message('debug','step_dic:' . json_encode($step_dic));
        $this->bsload('company/flow_update',
            array(
                'title'=>'更新审批流'
                ,'gnames' => $gnames
                ,'policies' => $policies
                ,'members' => $members
                ,'fid' => $id
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>base_url('company/common'),'name'=>'公司设置','class'=> '')
                    ,array('url'=>base_url('company/approval_flow'),'name'=>'财务审批流','class'=>'')
                    ,array('url'=>'','name'=>'更新财务审批流','class'=>'')
                ),
            )
        );
    }

    public function update_approve()
    {

    }
    public function delete_approve($pid)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $buf = $this->company->delete_approve($pid);
        log_message("debug","###delte:".json_encode($buf));
        return redirect(base_url('company/show_approve'));

    }

    public function approve_update($pid)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $buf = $this->company->show_approve();
        $info=json_decode($buf,true);
        $_info = array();
        if($info['status']>0)
        {
            $_info = $info['data'];
        }
        if(!$_info) {
            die("没有数据");
        }
        log_message('debug','approve:' . json_encode($_info));
        $own_rule = $_info[$pid];

        $category = $this->category->get_list();
        $categories = $category['data']['categories'];
        $sobs = $this->account_set->get_account_set_list();
        $_sobs = $sobs['data'];
        log_message('debug',"approve:".json_encode($own_rule));
        log_message("debug","categories:".json_encode($categories));
        log_message("debug","sobs:".json_encode($_sobs));
        log_message("debug","#######buf".$buf);
        $approve_categories = $own_rule['categories'];
        $cate_arr = array();
        $flag = 1;
        foreach($approve_categories as $item)
        {
            if($item['category']!=0)
            {
                if($item['act'] == -1)
                {
                    $flag = -1;
                }
                $cate_arr[$item['category']]=array('category_id'=>$item['category'],'act'=>$item['act']);
                foreach($categories as $cate)
                {
                    if($cate['id'] == $item['category'])
                    {
                        $cate_arr[$item['category']]['category_name'] = $cate['category_name'];
                        $cate_arr[$item['category']]['sob_id'] = $cate['sob_id'];
                        $cate_arr[$item['category']]['amount'] = $item['amount'];
                    }
                }
                foreach($_sobs as $s)
                {
                    if(!array_key_exists('sob_id', $cate_arr[$item['category']])) {
                        $cate_arr[$item['category']]['sob_name'] = '默认帐套';
                    } else {
                        if($s['sob_id'] == $cate_arr[$item['category']]['sob_id'])
                        {
                            $cate_arr[$item['category']]['sob_name'] = $s['sob_name'];
                        }
                    }
                }
            }
        }
        log_message("debug","array:".json_encode($cate_arr));

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
                ,'pid'=>$pid
                ,'flag'=>$flag
                ,'cate_arr'=>$cate_arr
                ,'error'=>$error
                ,'rule'=>$own_rule
                ,'member'=>$gmember
                ,'group'=>$gnames
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'修改审批','class'=>'')
                ),
            )
        );
    }

    public function show_approve()
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $buf = $this->company->show_approve();
        log_message("debug","APPRO".$buf);

        $rules = json_decode($buf,true);
        $_rules = $rules['data'];
        if(!$rules['status']) {
            $_rules = array();
        }
        log_message("debug", "show approve:" . $buf);
        $this->bsload('company/show_approve',
            array(
                'title'=>'审批规则'
                ,'error'=>$error
                ,'rules'=>$_rules
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'审批规则','class'=>'')
                ),
            )
        );

    }

    public function create_approve($pid=-1)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $rname = $this->input->post('rule_name');
        $sob_id = $this->input->post('sobs');
        $category_id = $this->input->post('category');
        $amount = $this->input->post('category_amount');

        $total_amount_limit = $this->input->post('frequency_unlimit');
        $total_amount = $this->input->post('total_amount');
	$_ranks = $this->input->post('ranks');
	$ranks = '';
	$_levels = $this->input->post('levels');
	$levels = '';
	$_groups = $this->input->post('groups');
	$groups = '';

	if($_ranks)
	{
		$ranks = implode(',',$_ranks);
	}

	if($_levels)
	{
		$levels = implode(',',$_levels);
	}

	if($_groups)
	{
		$groups = implode(',',$_groups);
	}

        if($total_amount_limit == 1)
        {
            $total_amount = -1;	
        }

        $members = $this->input->post('uids');
        if($members)
        {
            $members = implode(',',$members);
        }
        $all_members = $this->input->post('all_members');
        if($all_members == 1)
        {
            $members = -1;
        }

        //	$all_able = $this->input->post('allow_all_category');
        $allow_all_category = $this->input->post('all_able');
        //	$all_able = json_decode($all_able);
        //	log_message("debug","@@@@@:all_able:".$choose);


        //	log_message("debug","######:".json_encode($all_able));
        //	$allow_all_category = $this->input->post('all_all_category');
        $allow_category_ids = $this->input->post('allow_category_ids');
        $allow_category_ids = json_decode($allow_category_ids);
        $allow_category_amounts = $this->input->post('allow_category_amounts');
        $allow_category_amounts = json_decode($allow_category_amounts);
        $defaults = $this->input->post('defaults');
        $defaults = json_decode($defaults);
        log_message("debug","%%%%".json_encode($defaults));

        $deny_category_ids = $this->input->post('deny_category_ids');
        log_message("debug","@@@@@".$deny_category_ids);
        $deny_category_ids = json_decode($deny_category_ids);
        $deny_category_amounts = $this->input->post('deny_category_amounts');
        $deny_category_amounts = json_decode($deny_category_amounts);

        $allow = array();
        $allow_length = count($allow_category_ids);
        for($i = 0 ; $i < $allow_length ; $i++)
        {
            if($allow_category_ids[$i])
            {
                $item = array('category'=>$allow_category_ids[$i],'default'=>$defaults[$i],'amount'=>0);
                array_push($allow,$item);
            }
        }
        $deny = array();
        $deny_length = count($deny_category_ids);
        for($i = 0; $i < $deny_length ; $i++)
        {
            if($deny_category_ids[$i])
            {
                $item = array('category'=>$deny_category_ids[$i],'default'=>'-1','amount'=>0);
                array_push($deny,$item);
            }
        }

        if($allow_all_category == 1)
        {
            $policies = array('allow'=>array(),'deny'=>array());
        }
        else if($allow_all_category == -1 )
        {
            $policies = array('allow'=>array(),'deny'=>array());
        }
        else if($allow_all_category == 2)
        {
            $policies = array('allow'=>$allow,'deny'=>array());
        }
        else
        {
            $policies = array('allow'=>array(),'deny'=>$deny);
        }

        log_message("debug","allow_all:".$allow_all_category);
        log_message("debug","allow_all:".$deny_length);

        if(($allow_all_category!=1)&&($allow_all_category!=-1))
        {
            $allow_all_category = 0;
        }


        log_message("debug","accepted:".json_encode($policies));
        //	log_message("debug","accepted:".$category_amounts[0]);
        //	$info = array('category'=>$category_id,'amount'=>$amount);
        // 	$policy =array(array('category'=>$category_id,'amount'=>$amount));
        //	array_push($policy,$info);
        $buf = $this->company->create_approve($rname,$members,$total_amount,$allow_all_category,json_encode($policies),$pid,$ranks,$levels,$groups);
        log_message('debug',"#######".json_encode($buf));
        return redirect(base_url('company/show_approve'));

    }

    public function approve()
    {
        $this->need_group_it();
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
	$_ranks = $this->reim_show->rank_level(1);
	$ranks =array();
	$_levels = $this->reim_show->rank_level(0);
	$levels = array();
	if($_ranks['status']>0)
	{
		$ranks = $_ranks['data'];
	}
	if($_levels['status']>0)
	{
		$levels = $_levels['data'];
	}
        $this->bsload('company/approve',
            array(
                'title'=>'新建审批规则'
                ,'error'=>$error
                ,'member'=>$gmember
                ,'group'=>$gnames
		,'ranks' => $ranks
		,'levels' => $levels
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>base_url('company'),'name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'新建审批规则','class'=>'')
                ),
            )
        );

    }

    public function update($id)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
	$_ranks = $this->groups->get_rank_level(1);
	$_levels = $this->groups->get_rank_level(0);
	
	$ranks = array();
	if($_ranks['status'] > 0)
	{
		$ranks = $_ranks['data'];
	}

	$levels = array();
	if($_levels['status'] > 0)
	{
		$levels = $_levels['data'];
	}
	
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
	foreach($categories as $cate)
	{
		foreach($own_rule['cates'] as &$p)
		{
			if($p['category'] == $cate['id'])
			{
				$p['sob_id'] = $cate['sob_id'];
			}
		}
	}
	log_message('debug','own_rule:' . json_encode($own_rule));
	log_message('debug','_sobs:' . json_encode($_sobs));
	log_message('debug','categories:' . json_encode($categories));
	/*
        $cate_arr = array();
        $s_id = '';
        foreach($categories as $c)
        {
            if($c['id'] == $own_rule['category'])
            {
                $c_name = $c['category_name'];
                $s_id = $c['sob_id'];
                $cate_arr[$own_rule['category']] = array('category_id' => $own_rule['category'],'category_name'=>$c['category_name'],'sob_id'=>$c['sob_id']);
            }
        }
        foreach($_sobs as $s)
        {
            if($s['sob_id'] == $s_id)
            {
                $cate_arr[$own_rule['category']]['sob_name'] = $s['sob_name'];
            }
        }
        log_message("debug","#####".json_encode($cate_arr));

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
	*/

        $this->bsload('company/update',
            array(
                'title'=>'修改规则'
                ,'error'=>$error
                ,'rule'=>$own_rule
                ,'member'=>$gmember
         //       ,'cate_arr'=>$cate_arr
                ,'group'=>$gnames
		,'ranks' => $ranks
		,'levels' => $levels
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'修改规则','class'=>'')
                ),
            )
        );
    }

    public function update_rule()
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $id = $this->input->post('rid');
        $rname = $this->input->post('rule_name');
        $sob_id = $this->input->post('sobs');
        $category_id = $this->input->post('category');

        $amount = $this->input->post('rule_amount');
        $amount_unlimit = $this->input->post('amount_unlimit');
        $amount_time = $this->input->post('amount_time');

        $frequency = $this->input->post('rule_frequency');
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
        $_categories_id = $this->input->post('categories');
        $category_ids = json_decode($_categories_id,True);

	$_freq_counts = $this->input->post('freq_counts');
	$freq_counts = json_decode($_freq_counts,True);
	$_freq_periods = $this->input->post('freq_periods');
	$freq_periods = json_decode($_freq_periods,True);
	$_freq_unlimits = $this->input->post('freq_unlimits');
	$freq_unlimits = json_decode($_freq_unlimits,True);
	
        $id = $this->input->post('rid');
	log_message('debug','data:' . json_encode(array('categories'=>$_categories_id,'freq_counts'=>$_freq_counts,'freq_periods'=>$_freq_periods,'freq_unlimits'=>$_freq_unlimits)));

	
        $amount = $this->input->post('rule_amount');
        $amount_unlimit = $this->input->post('amount_unlimit');
        $amount_time = $this->input->post('amount_time');

        $frequency = $this->input->post('rule_frequency');
        $frequency_unlimit = $this->input->post('frequency_unlimit');
        //	$frequency_time = $this->input->post('frequency_time');
        $frequency_time = 1;

        $_groups = $this->input->post('gids');
	$groups = '';
        $_members = $this->input->post('uids');
	$members = '';

        $all_members = $this->input->post('all_members');
	$_ranks = $this->input->post('ranks');
	$_levels = $this->input->post('levels');
	$ranks = '';
	$levels ='';

	if($_groups)
	{
		$groups = implode(',',$_groups);
	}
	if($_members)
	{
		$members = implode(',',$_members);
	}

	if($_ranks)
	{
		$ranks = implode(',',$_ranks);
	}

	if($_levels)
	{
		$levels = implode(',',$_levels);
	}

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
	    
	    $ranks = '';
	    $levels = '' ;
            $groups = '';
            $members = '';
        }
	log_message('debug','ranks:' . $ranks);
	log_message('debug','levels:' . $levels);

        $policies = array();
	$len = count($category_ids);
	for($i = 0 ; $i < $len ; $i++)
	{
		if($freq_unlimits[$i] == 1)
			$freq_counts[$i] = 0;
		array_push($policies,array('category'=>$category_ids[$i],'freq_count' => $freq_counts[$i] , 'freq_period' => $freq_periods[$i]));
	}

	log_message('debug','policies:' . json_encode($policies));
	log_message('debug','rule_id:' . $id);
	if($id)
	{
		$buf = $this->company->create_update_rules($rname,$groups,$members,$levels,$ranks,json_encode($policies),$all_members,$id);
	}
	else
	{
		$buf = $this->company->create_update_rules($rname,$groups,$members,$levels,$ranks,json_encode($policies),$all_members);
	}
//        $buf=$this->company->create_rule($rname,$category_ids,$frequency,$frequency_time,$all_members,$groups,$members,$ranks,$levels);	
        log_message("debug","####CREATE:".json_encode($buf));
        return redirect(base_url('company/show'));
    }

    public function show(){
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $buf = $this->company->show_rules();
        $rules = json_decode($buf,true);
        $_rules = array();
        if($rules['status'] > 0)
        {
            $_rules = $rules['data'];
        }
	log_message('debug','rules:' . json_encode($_rules));
        $this->bsload('company/show',
            array(
                'title'=>'新建规则'
                ,'error'=>$error
                ,'rules'=>$_rules
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'提交规则','class'=>'')
                ),
            )
        );
    }
    public function flow_create() {
        $error = $this->session->userdata('last_error');
        $this->bsload('company/flow_create',
            array(
                'title'=>'新建审批流'
                ,'error'=>$error
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'财务审批流','class'=>'')
                    ,array('url'=>'','name'=>'新建财务审批流','class'=>'')
                ),
            )
        );
    }


    public function create_finance_flow(){
        $name = $this->input->post('sob_name');
        $obj = $this->company->create_finance_policy($name);
        if($obj['status']) {
            die(json_encode(array('code' => $obj['data']['id'])));
        }
        die(json_encode(array('code' => 0)));
    }

    public function delete_finance_flow($id = 0) {
        if($id == 0) return redirect(base_url('company/approval_flow'));
        $rules = $this->company->drop_finance_policy($id);
        return redirect(base_url('company/approval_flow'));
    }
    public function approval_flow(){
        //$this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $rules = $this->company->get_finance_policy();
        $_rules = array();
        if($rules['status'] > 0)
        {
          $_rules = $rules['data'];
        }
        //log_message('debug','rules:' . json_encode($_rules));
        $this->bsload('company/approval_flow',
            array(
                'title'=>'财务审批流'
                ,'error'=>$error
                ,'rules'=>$_rules
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'财务审批流','class'=>'')
                ),
            )
        );
    }
    public function create(){
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
    	$_ranks = $this->groups->get_rank_level(1);
    	$_levels = $this->groups->get_rank_level(0);
    	
    	$ranks = array();
    	if($_ranks['status'] > 0)
    	{
    		$ranks = $_ranks['data'];
    	}
    
    	$levels = array();
    	if($_levels['status'] > 0)
    	{
    		$levels = $_levels['data'];
    	}
	
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
		        ,'ranks' => $ranks
		        ,'levels' => $levels
                ,'breadcrumbs'=> array(
                    array('url'=>base_url(),'name'=>'首页','class'=>'ace-icon fa home-icon')
                    ,array('url'=>'','name'=>'公司设置','class'=> '')
                    ,array('url'=>'','name'=>'提交规则','class'=>'')
                ),
            )
        );
    }

    public function common(){
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $company = $this->company->get();
        $_config = array();
	log_message('debug','company:' . json_encode($company));
        if(array_key_exists('data', $company) && array_key_exists('config', $company['data'])){
            $_config = $company['data']['config'];
        }
        $this->bsload('company/common',
            array(
                'title' => '公司设置'
                ,'company' => $_config
                ,'error' => $error

                //,'company' => json_encode($_group)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
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
        $this->need_group_it();
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
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '审核规则', 'class' => '')
                ),
            )
        );
    }

    public function docreate_custom_item() {
        $this->need_group_it();
        $name = $this->input->post('name');
        $custom_item_id = $this->input->post('item_id');
        $gids = $this->input->post('gids');
        $type = $this->input->post('type');
        $this->load->model('custom_item_model');
        log_message("debug", "Custom Item ID:" . $custom_item_id);
        if($custom_item_id > 0) {
            $ret = $this->custom_item_model->update_item($custom_item_id, $name, $type, $gids);
        } else {
            $ret = $this->custom_item_model->create_custom_item($name, $type, $gids);
        }
        if($ret['status'] > 0) {
            die(json_encode(array('status' => true)));
        } else {
            die(json_encode($ret));
        }
    }

    public function deactive_custom_item($id = 0){
        $this->need_group_it();
        if(0 == $id) return redirect(base_url('company/custom_item'));
        $this->load->model('custom_item_model');
        $ret = $this->custom_item_model->set_active($id, 0);
        die(json_encode($ret));
    }

    public function active_custom_item($id = 0){
        $this->need_group_it();
        if(0 == $id) return redirect(base_url('company/custom_item'));
        $this->load->model('custom_item_model');
        $ret = $this->custom_item_model->set_active($id, 1);
        die(json_encode($ret));
    }

    public function delete_custom_item($id = 0) {
        $this->need_group_it();
        if(0 == $id) return redirect(base_url('company/custom_item'));
        $this->load->model('custom_item_model');
        $ret = $this->custom_item_model->drop_custom_item($id);
        if($ret['status']) {
            $this->session->set_userdata('last_error', '删除成功');
        } else {
            $this->session->set_userdata('last_error', '删除失败');
        }
        return redirect(base_url('company/custom_item'));
    }


    // 我要复用这个函数，啊，要懒死了
    public function custom_item_create($id = 0) {
        $this->need_group_it();
        $this->load->model('custom_item_model');
        $custom_item = array('name' => '', 'id' => 0);
        if(0 != $id) {
            $custom_item = $this->custom_item_model->get_by_id($id);
            if($custom_item['status']) {
                $custom_item = $custom_item['data'];
            }
        }
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->bsload('company/create_custom_item',
            array(
                'title' => '添加消费模板'
                ,'item' => $custom_item
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '添加消费模板', 'class' => '')
                ),
            )
        );
    }

    public function custom_item() {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->load->model('custom_item_model');
        $lists = $this->custom_item_model->list_all();
        $_list = array();
        if($lists['status'] > 0 ){
            foreach($lists['data'] as $l) {
                if($l['disabled'] == 0) {
                    array_push($_list, $l);
                }
            }
        }
        $this->bsload('company/custom_item',
            array(
                'title' => '消费模板'
                ,'error' => $error
                ,'rules' => $_list
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '消费模板', 'class' => '')
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
                    ,array('url'  => '', 'name' => '公司设置', 'class' => '')
                    ,array('url'  => '', 'name' => '公司通用设置', 'class' => '')
                ),
            )
        );
    }


    
    public function profile()
    {
        $pids = 1;
        $remark_id = 0;
        $company_id = 0;
        $need_bank_info = 0;
        $private_structure = 0;
        $mail_notify = 0;
        $low_amount_only = 0;
        $close_directly = 0;
        $note_compulsory = 0;
        $not_auto_time = 0;
	$disable_borrow = 0;
	$disable_budget = 0;
    $open_exchange = 0;
	
	$calendar_month = $this->input->post('calendar_month');
        $need_bank = $this->input->post('need_bank_info');
        $isadmin = $this->input->post('isadmin');
	log_message("debug", "FROM FORM IS ADMIN" . $isadmin);
        $isremark = $this->input->post('isremark');
        $iscompany = $this->input->post('iscompany');
        $template = $this->input->post('template');
        $user_confirm = $this->input->post('limit');
        $reports_limit = $this->input->post('reports_limit');
        $max_allowed_months = $this->input->post('max_allowed_months');
        $_private_structure = $this->input->post('private_structure');
        $_mail_notify = $this->input->post('mail_notify');
        $_max_amount_allowd = $this->input->post('low_amount_only');
        $_close_directly = $this->input->post('close_directly');
        $_note_compulsory = $this->input->post('note_compulsory');
        $_not_auto_time = $this->input->post('not_auto_time');
	$_disable_borrow = $this->input->post('allow_borrow');
	$_disable_budget = $this->input->post('allow_budget');
        $_open_exchange = $this->input->post('open_exchange');

        if($_open_exchange == "true")
        {
            $open_exchange = 1;
        }
        if($_disable_borrow == "true")
        {
            $disable_borrow = 1;
        }
        if($_disable_budget == "true")
        {
            $disable_budget = 1;
        }
        if($isadmin == "true")
        {
            $pids = 0;
        }
        if($isremark == "true")
        {
            $remark_id = 1;
        }
        if($iscompany == "true")
        {
            $company_id = 1;
        }
        if($_not_auto_time == "true") {
            $not_auto_time = 1;
        }
        if($_note_compulsory == "true")
        {
            $note_compulsory = 1;
        }
        if($_mail_notify == "true")
        {
            $mail_notify = 1;
        }
        if($_private_structure == "true")
        {
            $private_structure = 1;
        }
        if($need_bank == "true")
        {
            $need_bank_info = 1;
        }
        if($_max_amount_allowd == "true")
        {
            $low_amount_only= 1;
        }
        if($_close_directly == "true")
        {
            $close_directly = 1;
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
	log_message('debug','same_category:' . $pids);
        $in=array();
        $in['export_no_company']=$company_id;
        $in['same_category'] = $pids;
        $in['close_directly'] = $close_directly;
        $in['note_compulsory'] = $note_compulsory;
        $in['not_auto_time'] = $not_auto_time;
        $in['export_no_note'] = $remark_id;
        $in['template'] = $template;
        $in['user_confirm'] = $user_confirm;
        $in['report_quota'] = $reports_limit;
        $in['private_structure'] = $private_structure;
        $in['need_bank_info'] = $need_bank_info;
        $in['max_allowed_months'] = $max_allowed_months;
        $in['mail_notify'] = $mail_notify;
        $in['low_amount_only'] = $low_amount_only;
	$in['disable_borrow'] = $disable_borrow;
	$in['disable_budget'] = $disable_budget;
	$in['calendar_month'] = $calendar_month;
    $in['open_exchange'] = $open_exchange;
	log_message('debug','company_in:' .json_encode($in));
        $this->company->profile($in);
        //die(json_encode($re));
	die(json_encode(array('msg'=>'保存成功')));
    }
}
