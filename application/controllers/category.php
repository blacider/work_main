<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model', 'category');
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('usergroup_model','ug');
        $this->load->model('account_set_model','account_set');
    }

    public function remove_sob($sid)
    {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $sobs = $this->account_set->delete_account_set($sid);
        log_message("debug","#######delete:$sobs");
        return redirect(base_url('category/account_set'));
    }

    public function sob_update($gid)
    {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $sobs = $this->account_set->get_account_set_list();
        $_sobs = $sobs['data'];
        $data = array();
        foreach($_sobs as $sob)
        {
            if(array_key_exists($sob['sob_id'],$data))
            {
                $group=$data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
            else
            {
                $data[$sob['sob_id']]=array();
                $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                $data[$sob['sob_id']]['groups'] = array();
                $groups = $data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
        }

        $ugroups = $this->ug->get_my_list();
        $this->bsload('account_set/update',
            array(
                'title' => '新建帐套'
                //  ,'acc_sets' => $acc_sets
                //  ,'acc_sets' => $acc_sets
                ,'ugroups' => $ugroups['data']['group']
                ,'sob_data' => $data[$gid]['groups']
                ,'sob_id' => $gid
                ,'breadcrumbs' => array(
                    array('url' => base_url(),'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url' => base_url('category/index'),'name' => '标签和分类','class' => '')
                    ,array('url' => '','name' => '更新帐套','class' => '')
                ),
            )   
        );


    }
    public function new_sob()
    {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        // $acc_sets = $this->account_set->get_account_set_list();
        $ugroups = $this->ug->get_my_list();
        $_ug = json_encode($ugroups['data']['group']);
        //  $_acc = json_encode($acc_sets);
        // log_message("debug","sob#############$_acc");
        $this->bsload('account_set/new',
            array(
                'title' => '新建帐套'
                //  ,'acc_sets' => $acc_sets
                //  ,'acc_sets' => $acc_sets
                ,'ugroups' => $ugroups['data']['group']
                ,'breadcrumbs' => array(
                    array('url' => base_url(),'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url' => base_url('category/index'),'name' => '标签和分类','class' => '')
                    ,array('url' => '','name' => '新建帐套','class' => '')
                ),
            )   
        );
    }

    public function create_sob()
    {
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $sob_name = $this->input->post('sob_name');
        $groups = $this->input->post('groups');
        //$save = $this->input->post('renew');
        //log_message("debug","-----------------$groups");
        $ret = $this->account_set->create_account_set($sob_name, implode(',', $groups));
        $re = json_encode($ret);
        log_message("debug", "***&&*&*&*:$re");
        $arr = array('helo' => 'jack');
        die(json_encode($arr));
        //return redirect(base_url('category/account_set'));
    }

    public function update_sob()
    {
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $sid = $this->input->post('sid');
        $sob_name = $this->input->post('sob_name');
        $groups = $this->input->post('groups');
        //$save = $this->input->post('renew');
        log_message("debug","-----------------$sid");
        $ret = $this->account_set->update_account_set($sid,$sob_name, implode(',', $groups));
        $re = json_encode($ret);
        log_message("debug", "***&&*&*&*:$re");
        $arr = array('helo' => 'jack');
        die(json_encode($arr));
        //return redirect(base_url('category/account_set'));
    }

    public function getsobs()
    {
        $sobs = $this->account_set->get_account_set_list();
        $_sobs = $sobs['data'];
        $data = array();
        foreach($_sobs as $sob)
        {
            if(array_key_exists($sob['sob_id'],$data))
            {
                $group=$data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
            else
            {
                $data[$sob['sob_id']]=array();
                $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                $data[$sob['sob_id']]['groups'] = array();
                $groups = $data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
        }
        die(json_encode($data));
    }
    public function account_set(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $acc_sets = $this->account_set->get_account_set_list();
	$sobs = $acc_sets['data'];
	$keys = array();

	$acc_set = array();
	foreach($sobs as $item)
	{
		if(!in_array($item['sob_id'],$keys))
		{
			array_push($keys,$item['sob_id']);
			array_push($acc_set,array('name'=>$item['sob_name'],'id'=>$item['sob_id'],'lastdt'=>$item['createdt']));
		}

	}
        //$ugroups = $this->ug->get_my_list();
//        $_ug = json_encode($ugroups['data']['group']);
        $_acc = json_encode($acc_sets);
        log_message("debug","sob#############".json_encode($acc_set));

        $this->bsload('account_set/index',
            array(
                'title' => '帐套管理'
                //	,'acc_sets' => $acc_sets
                ,'acc_sets' => $acc_set
                //,'ugroups' => $ugroups['data']['group']
                ,'breadcrumbs' => array(
                    array('url' => base_url(),'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url' => base_url('category/index'),'name' => '标签和分类','class' => '')
                    ,array('url' => '','name' => '帐套管理','class' => '')
                ),
            )	
        );
    }
    public function index(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
    	$sobs = $this->account_set->get_account_set_list();
        $category = $this->category->get_list();


        //TODO: 重新审核此段代码 Start
        $ugroups = $this->ug->get_my_list();
        $_ug = json_encode($ugroups['data']['group']);
        $_category = json_encode($category);
        log_message("debug", "CATEGORY#########: $_category");

        $_sobs = $sobs['data'];
        $sob_data = array();
        $_sob_data_keys = array();
        foreach($_sobs as $item)
        {
            $_sob_id = $item['sob_id'];
            if(!in_array($_sob_id,$_sob_data_keys))
            {
                array_push($_sob_data_keys, $_sob_id);
                array_push($sob_data, $item);
            }
        }
        log_message("debug", "UG#########: $_ug");
        //TODO: 重新审核此段代码  END  庆义，长远

        if($category){
            $_group = $category['data']['categories'];
        }
        $category_group = array();
        foreach ($_group as $item) {
            log_message("debug", "Item:" . json_encode($item));
            if($item['sob_id'] == 0 || $item['sob_id'] == '0') {   
                $item['sob_name'] = "没有帐套";
                $category_group[] = $item;
                continue;
            } else {
                foreach ($_sobs as $sob) {
                    if ($item['sob_id'] == $sob['sob_id']) {
                        $item['sob_name'] = $sob['sob_name'];
                        $category_group[] = $item;
                        break;
                    }
                }
            }
        }

        $this->bsload('category/index',
            array(
                'title' => '分类管理'
                ,'category' => $category_group
                //,'sobs' => $sobs['data']
                ,'error' => $error
                ,'ugroups' => $ugroups['data']['group']
		,'sobs' => $sob_data
		,'ugroups' => $ugroups['data']['group']
                //,'category' => json_encode($_group)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/index'), 'name' => '标签和分类', 'class' => '')
                    ,array('url'  => '', 'name' => '分类管理', 'class' => '')
                ),
            )
        );
    }

    public function tags(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $tags = $this->tags->get_list();
        if($tags){
            $tags = $tags['data']['tags'];
        }
        $this->bsload('tags/index',
            array(
                'title' => '标签管理'
                ,'category' => $tags
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url'  => base_url('tags/index'), 'name' => '标签管理', 'class' => '')
                ),
            )
        );
    }

    public function newcategory(){
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $category = $this->category->get_list();
        if($category){
            $_group = $category['data']['categories'];
        }
        $this->bsload('category/newcategory',
            array(
                'title' => '分类管理'
                ,'category' => $_group
                ,'error' => $error
                //,'category' => json_encode($_group)
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/index'), 'name' => '标签和分类', 'class' => '')
                    ,array('url'  => '', 'name' => '分类管理', 'class' => '')
                ),
            )
        );
    }


    public function create(){
        $name = $this->input->post('category_name');
        $sob_code = $this->input->post('sob_code');
        $pid = $this->input->post('pid');
        $sob_id = $this->input->post('sob_id');
        $note = $this->input->post('note');
        $prove_ahead= $this->input->post('prove_ahead');
        $max_limit = $this->input->post('max_limit');
        $cid = $this->input->post('category_id');
        $gid = $this->input->post('gid');
        log_message("debug","\n#############GID:$gid");
        $sob_id = $this->input->post('sob_id');
	
	log_message("debug","\n#############GID:$gid");
        $msg = '添加分类失败';
        $obj = null;
        if($cid > 0){
            $obj = $this->category->update($cid, $name, $pid, $sob_id, $prove_ahead, $max_limit, $note, $sob_code);
        } else {
            $obj = $this->category->create($name, $pid, $sob_id, $prove_ahead, $max_limit, $note, $sob_code);
        }
        if($obj && $obj['status']){
            $msg = '添加分类成功' . $note;
        } else {
            $msg = $obj['data']['msg'];
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('category'));
    }

    public function drop($id){
        if(!$id) {
            log_message("debug", "DROP: $id");
            $this->session->set_userdata('last_error', '参数错误');
            return redirect(base_url('category'));
        }
        $obj = $this->category->remove($id);
        if($obj && $obj['status']){
            log_message("debug", "删除成功 S");
            $msg = '删除分类成功';
        } else {
            $msg = $obj['data']['msg'];
            log_message("debug", "删除失败 F");
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('category'));
    }
    public function gettreelist(){
        $category = $this->category->get_list();
        //$data = $category['data'];
        // $group = $data['categories'];

        //$category['data']['categroies'];
        //$hello = array('a' => 1,'b' => 2);
        $group = $category['data']['categories'];
        $tree = array();
        foreach ($group as $item) {  
            # code...
            array_push($tree,array($item['category_name'] => array('name' => $item['category_name'] ,'type' => 'folder','icon-class' => 'red')));
        };
        die(json_encode($tree));
    }
    public function get_sob_category()
    {
        $sobs = $this->account_set->get_account_set_list();
        $_sobs = $sobs['data'];
        $data = array();
        foreach($_sobs as $sob)
        {
            if(array_key_exists($sob['sob_id'],$data))
            {
                $group=$data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
            else
            {
                $data[$sob['sob_id']]=array();
                $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                $data[$sob['sob_id']]['groups'] = array();
                $data[$sob['sob_id']]['category'] = array();
                $groups = $data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
        }
        $category = $this->category->get_list();
        $categories = $category['data']['categories'];
        foreach($categories as $item)
        {

            if(array_key_exists($item['sob_id'],$data))
            {
                array_push($data[$item['sob_id']]['category'],array('category_id'=>$item['id'],'category_name'=>$item['category_name']));
            }
            log_message("debug","@@@@@@@@@@@@".$item['sob_id']."+++".$item['category_name']);
        }

        die(json_encode($data));
    }
    public function get_my_sob_category()
    {
        $profile = $this->session->userdata('profile');
        $sobs = $profile['sob'];
        $_sob_id = array();
        //$_my_sobs = array();
        foreach($sobs as $i) {
            log_message('debug', "alvayang:" . json_encode($i));
            array_push($_sob_id, $i['sob_id']);
            //array_push($_sobs, $i);
        }

        $sobs = $this->account_set->get_account_set_list();
        $_sobs = $sobs['data'];
        $data = array();
        foreach($_sobs as $sob)
        {
            if(!in_array($sob['sob_id'], $_sob_id)) continue;
            if(array_key_exists($sob['sob_id'],$data))
            {
                $group=$data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
            else
            {
                $data[$sob['sob_id']]=array();
                $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                $data[$sob['sob_id']]['groups'] = array();
                $data[$sob['sob_id']]['category'] = array();
                $groups = $data[$sob['sob_id']]['groups'];
                array_push($data[$sob['sob_id']]['groups'],array('group_id'=>$sob['group_id'],'group_name'=>$sob['group_name']));
            }
        }
        $category = $this->category->get_list();
        $categories = $category['data']['categories'];
        foreach($categories as $item)
        {

            if(array_key_exists($item['sob_id'],$data))
            {
                array_push($data[$item['sob_id']]['category'],array('category_id'=>$item['id'],'category_name'=>$item['category_name']));
            }
        }

        die(json_encode($data));
    }
}
