<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model', 'category');
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('usergroup_model','ug');
        $this->load->model('account_set_model','account_set');
        $this->load->model('reim_show_model','reim_show');
        $this->load->model('group_model','groups');
        $this->load->model('user_model','users');
    }
    

    public function get_ug_members($gid)
    {
        $info = json_decode($this->ug->get_single_group($gid), True);
        if($info['status'] > 0){
            $info = $info['data'];
            $group = $info['group'];
            $member = $info['member'];
            }
          foreach($member as &$m)
          {
               $m['d'] = $group['name'];
          }
         log_message('debug','members:' . json_encode($member));
         die(json_encode(array('member' => $member,'gid' => $gid)));
    }

    public function get_fee_afford($oid)
    {
        $this->need_group_it();
        $fee_afford = array();
        $buf = $this->category->get_fee_afford($oid);
        if($buf['status'] > 0)
        {
            $fee_afford = $buf['data'];
        }
        log_message('debug','fee_afford:' . json_encode($fee_afford));    
        
        die(json_encode($fee_afford));
    }

    public function delete_fee_afford($oid,$pid)
    {
        $this->need_group_it();
        $buf = $this->category->delete_fee_afford($oid); 
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除对象成功');
        }
        else
        {
            $this->session->set_userdata('last_error','删除对象失败');
        }

            return redirect(base_url('category/update_expense/' . $pid));
    }
    
    public function create_fee_afford()
    {
        $this->need_group_it();
        $__gid = $this->input->post('_gid');
        $__oid = $this->input->post('_oid');
        $__oid = json_decode($__oid,True);
        $fid = $this->input->post('fid');
        $pid = $this->input->post('pid');
       // $gid = $this->input->post('gid');
        $_oid = $this->input->post('oid');
 //       $oname = $this->input->post('oname');
        $standalone = 0;
        
        $uids = $this->input->post('uids');
        $gids = $this->input->post('gids');
        $ranks = $this->input->post('ranks');
        $levels = $this->input->post('levels');

        $all_member = $this->input->post('all_member');
        if(!$uids)
        {
            $uids = array();
        }
        if(!$gids)
        {
            $gids = array();
        }
        if(!$ranks)
        {
            $ranks = array();
        }
        if(!$levels)
        {
            $levels = array();
        }
        if($fid != -1)
        {
            $_oid = $__oid;
            $gid = $__gid;
        }

        if($all_member == 1)
        {
            $gids = [-1];
        }
        $oid = array();
        foreach($_oid as $o)
        {
            $temp = explode(',',$o);
            if(!array_key_exists($temp[0],$oid))
            {
                $oid[$temp[0]] = array(); 
            }
            array_push($oid[$temp[0]],array('id' => $temp[1],'name'=>$temp[2])); 
        }
        
  //      log_message('debug','oname:' . json_encode($oname));
        log_message('debug','pid:' . $pid);
        log_message('debug','_gid:' . $__gid);
        log_message('debug','_oid:' .json_encode($_oid));
        log_message('debug','_oid:' .json_encode($__oid));
        log_message('debug','fid:' . $fid);
//        log_message('debug','gid:' . json_encode($gid));
        log_message('debug','oid:' . json_encode($oid));
        log_message('debug','uids:' . json_encode($uids));
        log_message('debug','gids:' . json_encode($gids));
        log_message('debug','ranks:' . json_encode($ranks));
        log_message('debug','levels:' . json_encode($levels));
        if($fid == -1)
        {
            $buf = $this->category->create_fee_afford($pid,$oid,$standalone,$uids,$gids,$ranks,$levels);
                if($buf['status'] > 0)
                {
                    $this->session->set_userdata('last_error','对象添加成功');
                }
                else
                {
                    $this->session->set_userdata('last_error','对象添加失败');
                }
        }
        else
        {
            $buf = $this->category->update_fee_afford($pid,$oid,$standalone,$uids,$gids,$ranks,$levels); 
                if($buf['status'] > 0)
                {
                    $this->session->set_userdata('last_error','对象更新成功');
                }
                else
                {
                    $this->session->set_userdata('last_error','对象更新失败');
                }
        }
            return redirect(base_url('category/update_expense/' . $pid));
    }
    
    public function del_expense($id = -1)
    {
        $this->need_group_it();
        if($id == -1)  return redirect(base_url('category/show_expense'));
        $buf = $this->category->del_fee_afford_project($id);
        
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','删除成功');  
        }
        else
        {
            $this->session->set_userdata('last_error','删除失败');
        }

        return redirect(base_url('category/show_expense'));
    }

    public function update_fee_afford_project()
    {
        $this->need_group_it();
        $id = $this->input->post('pro_id');
        if($id == -1) 
            return redirect(base_url('category/show_expense'));
        $name = $this->input->post('pro_name');
        $buf = $this->category->update_fee_afford_project($id,$name);
        if($buf['status'] > 0)
        {
            $this->session->set_userdata('last_error','项目更新成功');
        }
        else
        {
            $this->session->set_userdata('last_error','项目更新失败');
        }

        return redirect(base_url('category/show_expense'));
    }
    public function create_expense()
    {
        $this->need_group_it();
        $name = $this->input->post('name');
        $buf = $this->category->expense_create($name);

        if($buf['status'] > 0)
        {
            return redirect(base_url('category/update_expense/' . $buf['data']['id']));
        }
        else
        {
            $this->session->set_userdata('last_error','对象添加失败');
            return redirect(base_url('category/show_expense'));
        }
    }

    public function update_expense($eid = -1)
    {
        $this->need_group_it();
        if(-1 == $eid) return redirect(base_url('category/show_expense'));

        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }

        $gnames = array();
        $_gnames = $this->ug->get_my_list();
        if($_gnames['status'] > 0)
        {
            $gnames = $_gnames['data']['group'];
        }

        $ranks = array();
        $levels = array();
        $_ranks = $this->reim_show->rank_level(1);
        if($_ranks['status'] > 0)
        {
            $ranks = $_ranks['data'];
        }
        $_levels = $this->reim_show->rank_level(0);
        if($_levels['status'] > 0)
        {
            $levels = $_levels['data'];
        }

        $_fee_afford = $this->category->get_afford_project($eid);
        $fee_afford = array();
        if($_fee_afford['status'] > 0) 
        {
            $fee_afford = $_fee_afford['data'];
        }
        $group_dic = array();
        foreach($gnames as $g)
        {
            $group_dic[$g['id']] = $g['name']; 
        }
        $fee_afford['gdetail'] = array();
        $oid_dic = array();
        if(array_key_exists('detail',$fee_afford))
        {
                foreach($fee_afford['detail'] as &$f)
                {
                    array_push($oid_dic,array('oid' => $f['oid'],'gid' => $f['gid']));
                    if(!array_key_exists($f['gid'],$fee_afford['gdetail']))
                    {
                        $fee_afford['gdetail'][$f['gid']] = array();
                    }

                    if(array_key_exists($f['gid'],$group_dic))
                    {
                        $f['gname'] = $group_dic[$f['gid']]; 
                        log_message('debug','gname:' . $f['gname']);
                    }
                    else
                    {
                        $f['gname'] = '';
                    }

                    array_push($fee_afford['gdetail'][$f['gid']],$f);
                }
        }
        $project_type = 0;
        if(array_key_exists('project_type',$fee_afford))
        {
            $project_type = $fee_afford['project_type'];
        }
        log_message('debug','members: ' . json_encode($gmember));
        log_message('debug','groups: ' . json_encode($gnames));
        log_message('debug','ranks: ' . json_encode($ranks));
        log_message('debug','levels: ' . json_encode($levels));
        log_message('debug','fee_afford: ' . json_encode($_fee_afford));
        log_message('debug','group_dic: ' . json_encode($group_dic));
        if($project_type == 0)
        {
                $this->bsload('category/update_expense',
                    array(
                        'title' => '修改对象'
                        ,'members' => $gmember
                        ,'groups' => $gnames
                        ,'ranks' => $ranks
                        ,'levels' => $levels
                        ,'pid' => $eid
                        ,'error' => $error
                        ,'fee_afford' => $fee_afford
                        ,'group_dic' => $group_dic
                        ,'oid_dic' => $oid_dic
                        ,'breadcrumbs' => array(
                            array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                            ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                            ,array('url'  => base_url('category/show_expense'), 'name' => '费用承担对象管理', 'class' => '')
                            ,array('url'  => '', 'name' => '修改对象', 'class' => '')
                        ),
                    )
                );
        }
        else if($project_type == 1)
        {
                $this->bsload('category/update_expense_group',
                    array(
                        'title' => '修改对象'
                        ,'members' => $gmember
                        ,'groups' => $gnames
                        ,'ranks' => $ranks
                        ,'levels' => $levels
                        ,'pid' => $eid
                        ,'error' => $error
                        ,'fee_afford' => $fee_afford
                        ,'group_dic' => $group_dic
                        ,'oid_dic' => $oid_dic
                        ,'breadcrumbs' => array(
                            array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                            ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                            ,array('url'  => base_url('category/show_expense'), 'name' => '费用承担对象管理', 'class' => '')
                            ,array('url'  => '', 'name' => '修改对象', 'class' => '')
                        ),
                    )
                );
        }
        else
        {
                $this->bsload('category/update_expense_other',
                    array(
                        'title' => '修改对象'
                        ,'members' => $gmember
                        ,'groups' => $gnames
                        ,'ranks' => $ranks
                        ,'levels' => $levels
                        ,'pid' => $eid
                        ,'error' => $error
                        ,'fee_afford' => $fee_afford
                        ,'group_dic' => $group_dic
                        ,'oid_dic' => $oid_dic
                        ,'breadcrumbs' => array(
                            array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                            ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                            ,array('url'  => base_url('category/show_expense'), 'name' => '费用承担对象管理', 'class' => '')
                            ,array('url'  => '', 'name' => '修改对象', 'class' => '')
                        ),
                    )
                );
        }
    }

    public function show_expense()
    {
        $this->need_group_it();
        $buf = $this->category->get_afford_project();
        $projects = array();
        if($buf['status'] > 0)
        {
            $projects = $buf['data']; 
        }
        log_message('debug','projects: ' . json_encode($projects));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->bsload('category/expense',
            array(
                'title' => '费用承担对象管理'
                ,'error' => $error
                ,'projects' => $projects
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                    ,array('url'  => '', 'name' => '费用承担对象管理', 'class' => '')
                ),
            )
        );
    }

    public function batch_create_category()
    {
        $this->need_group_it();
        $sid = $this->input->post('sid');
        $cate = $this->input->post('cate');
        log_message('debug','sid: ' . $sid);
        log_message('debug','cate: ' . json_encode($cate));
        $info = $this->category->create($cate['name'],0,$sid,0,$cate['limit']);
    }


    public function batch_update_account(){
        $sid = $this->input->post('id');
        $sobname = $this->input->post('sob');    
        $sobs = '';
        if($sobname) {
            $sobs = base64_decode($sobname);
        }
        if(!$sobs) die(json_encode(array('status' => false)));
        $data = $this->account_set->update_batch($sid, $sobs);
        die($data);
    }

    public function batch_create_account() {
        $sobname = $this->input->post('sob');    
        if($sobname) {
            $sobs = base64_decode($sobname);
            // 发送出去就行了
        }
        log_message("debug", "SOB:" . json_encode($sobs));
        if(!$sobs) die(json_encode(array('status' => false)));
        $data = $this->account_set->insert_batch($sobs);
        die($data);

    }

 public function exports(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $this->bsload('category/exports',
            array(
                'title' => '导入帐套'
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                    ,array('url'  => '', 'name' => '导入帐套', 'class' => '')
                ),
            )
        );
        //
    }
    public function imports(){

        if(!array_key_exists('members', $_FILES)){
            redirect(base_url('members'));
        }
        $tmp_file = $_FILES['members']['tmp_name'];

        try {
            $reader = IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($tmp_file);
            $sheet = $PHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); 
            $highestColumm = $sheet->getHighestColumn();
        } catch(Exception $e) {
            $this->session->set_userdata('last_error', '暂不支持当前的文件类型');
            return redirect(base_url('category/cexport'));
        }
        $highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
        log_message("debug", "Max Column:" . $highestColumm);
        
        // 读取到公司所有的帐套信息
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        if($group) {
            if(array_key_exists('ginfo', $group['data'])){
                $ginfo = $group['data']['ginfo'];
            }
            if(array_key_exists('gmember', $group['data'])){
                $gmember = $group['data']['gmember'];
            }
            $gmember = $gmember ? $gmember : array();
        }

        $members_dic = array();
        foreach($gmember as $m)
        {
            if(array_key_exists('email',$m))
            {
                $members_dic[$m['email']] = $m['id'];
            }
        }

        //好吧，为了一个展示，再来一组hash
        $_sobs_desc = $this->account_set->get_account_set_list();
        $_sob_db_hash = array(0 => '默认帐套');
        // 还要把现有帐套和人员的关系存一下，作为增量.
        if($_sobs_desc['status'] && $_sobs_desc['data']) {
            foreach($_sobs_desc['data'] as $s) {
                log_message("debug", "IN DB:" . json_encode($s));
                $_sob_db_hash[$s['sob_id']] = $s['sob_name'];
            }
        }

        $_sobs = $this->category->get_list();
        $_exist_sob_dict = array();
        $_sob_name = array();
        $_sob_hash_mix = array();
        if($_sobs['status'] && $_sobs['data']['categories']) {
            foreach($_sobs['data']['categories'] as $s){
                log_message("debug", "category:" . json_encode($s));
                if(!array_key_exists($s['sob_id'], $_exist_sob_dict)){
                    $_exist_sob_dict[$s['sob_id']] = array();
                } 
                if(array_key_exists($s['sob_id'], $_sob_db_hash)){
                    $_sob_name[$s['sob_id']] = $_sob_db_hash[$s['sob_id']];//$s['name'];
                    array_push($_exist_sob_dict[$s['sob_id']], trim($s['category_name']) . trim($s['sob_code']) . $s['max_limit'] . trim($s['note']));
                }

            }
        }
        log_message("debug", "XExistd SOB DICT:" . json_encode($_exist_sob_dict));
        log_message("debug", "XExistd SOB name:" . json_encode($_sob_name));
        $__sob_hash_dict = array();
        foreach($_exist_sob_dict as $sid => $cids){
            sort($cids);
            $cids = array_unique($cids);
            $_hash = md5(implode("_", $cids));
            log_message("debug", "xCIDS:" . json_encode($cids));
            log_message("debug", "ESOD:" . json_encode($__sob_hash_dict));
            log_message("debug", "xHash:" . $_hash);
            $__sob_hash_dict[$_hash] = $sid;
            log_message("debug", "xHashSid:" . $sid);
        }
        $sobs = array();
        $sob_hash = array();
        $exitst_sobs = array();
        $idx = 1;
        $create_count = 1;
        for ($row = 3; $row <= $highestRow; $row++){//行数是以第4行开始
            // 前三列为标准列，后面的为三个一组的类目
            $obj = Array();
            $obj['id'] = trim($sheet->getCellByColumnAndRow(0, $row)->getValue());
            $obj['name'] = trim($sheet->getCellByColumnAndRow(1, $row)->getValue());
            $obj['email'] = trim($sheet->getCellByColumnAndRow(2, $row)->getValue());
            $obj['phone'] = trim($sheet->getCellByColumnAndRow(3, $row)->getValue());
            if((!$obj['email']) && (!$obj['phone'])) continue;
            $obj['own_id'] = 0;
            $desc = array();
            $_ids = array();
            $obj['cates'] = array();
            for($col = 4; $col < $highestColumm; $col+=4){
                $s = array();
                $s['name'] = trim($sheet->getCellByColumnAndRow($col, $row)->getValue());
                $s['code'] = trim($sheet->getCellByColumnAndRow($col + 1, $row)->getValue());
                $s['limit'] = trim($sheet->getCellByColumnAndRow($col + 2, $row)->getValue());
                $s['note'] = trim($sheet->getCellByColumnAndRow($col + 3, $row)->getValue());
                //array_push($_ids, trim($s['name']) . trim($s['code']) . $s['limit'] . $s['note']);
                if(!$s['code']) continue;
                if(!trim($s['limit']))
                {
                    $s['limit'] = 0;
                }
                array_push($_ids, trim($s['name']) . trim($s['code']) . $s['limit'] . trim($s['note']));
                array_push($desc, $s['name'] . "(ID:" . $s['code'] . ", 限额:" . $s['limit'] . "说明:" .$s['note'] . ")");
                array_push($obj['cates'], $s);
            }
            log_message("debug", "IDS:" . json_encode($_ids));
            sort($_ids);
            $_hash = md5(implode("_", $_ids));
            log_message("debug", "Hash Dict:" . json_encode($__sob_hash_dict));
            log_message("debug", "Hash :" . $_hash);
            $obj['sob_id'] = -1;
            $obj['sob_name'] = '';
            $obj['sob_hash'] = $_hash;
            if(array_key_exists($_hash, $__sob_hash_dict)){
                $obj['sob_id'] = $__sob_hash_dict[$_hash];
                $__sob_name = '';
                $obj['sob_name'] = '';
                if(array_key_exists($obj['sob_id'], $_sob_name)){
                    $obj['sob_name'] = $_sob_name[$obj['sob_id']];
                    $__sob_name = $_sob_name[$obj['sob_id']];
                }
                log_message("debug", "SOB EXISTS:" . json_encode($_sob_name) . ", " . $obj['sob_id']);
                if(!array_key_exists($obj['sob_id'], $exitst_sobs)) {
                    $exitst_sobs[$obj['sob_id']] = array('name' => $__sob_name,'emails' => array(), 'cids' => array(), 'detail' => $obj['cates']);
                }
                if($obj['email'])
                {
                    array_push($exitst_sobs[$obj['sob_id']]['emails'], $obj['email']);
                }
                else
                {
                    array_push($exitst_sobs[$obj['sob_id']]['emails'], $obj['phone']);
                }
            } else {
                // 数据库中不存在，那么留下来，准备建设新的
                if(!array_key_exists($_hash, $sob_hash)) {
                    $sob_hash[$_hash] = array('name' => '自动帐套' . $create_count  . '(' . date('Y-m-d h:i:sa') . ')', 'emails' => array(), 'cids' => $_ids, 'detail' => $obj['cates']);
                    $idx += 1;
                    $create_count += 1;
                }
                //array_push($sob_hash[$_hash]['emails'], $obj['email']);
                if($obj['email'])
                {
                    array_push($sob_hash[$_hash]['emails'], $obj['email']);
                    //array_push($exitst_sobs[$obj['sob_id']]['emails'], $obj['email']);
                }
                else
                {
                    array_push($sob_hash[$_hash]['emails'], $obj['phone']);
                    //array_push($exitst_sobs[$obj['sob_id']]['emails'], $obj['email']);
                }
            }
            $obj['str_desc'] = implode("/", $desc);
            array_push($sobs, $obj);
        }
        $_exists_sob_b64 = array();
        $_sob_hash_b64 = array();
        foreach($sob_hash as $k => $v) {
            $_sob_hash_b64[$k] = base64_encode(json_encode($v));
        }
        foreach($exitst_sobs as $k => $v){
            $_exists_sob_b64[$k] = base64_encode(json_encode($v));
        }

        log_message("debug", "Man:" . json_encode($sobs));
        // 好了，这下就把那些新创建的给搞出来吧，至于那些旧的，hmm，暂时不支持在excel中修改吧，不然乱七八糟的。

        /*
        //获取不同的类目组合
        $obj_dic = array(); 
        foreach($sobs as $s) {
           if(!in_array($s['str_desc'],$obj_dic)) {
                array_push($obj_dic,$s['str_desc']); 
           }
        }
        log_message('debug' , 'obj_dic:' . json_encode($obj_dic));
        //获取不同类目组合的帐套名字
        $sob_dic = array();
        $sob_names = array();
        $count = 1;
        foreach($obj_dic as $o)
        {
            $sob_dic[$o] = '帐套' . $count;
            array_push($sob_names,'帐套' . $count);
            $count++;
        }

        $_sobs = array();
        foreach($sobs as &$s)
        {
            $s['sob_name'] = $sob_dic[$s['str_desc']];
            if(!array_key_exists($s['sob_name'],$_sobs))
            {
                $_sobs[$s['sob_name']] = array();
            }
                if(!array_key_exists('uids',$_sobs[$s['sob_name']]))
                {
                    $_sobs[$s['sob_name']]['uids'] = array();
                }
                array_push($_sobs[$s['sob_name']]['uids'],$s['own_id']);
                if(!array_key_exists('cates',$_sobs[$s['sob_name']]))
                {
                    $_sobs[$s['sob_name']]['cates'] = $s['cates'];
                }
        }
         */
        
        log_message("debug", "Man:" . json_encode($sobs));
        log_message('debug', '_sobs:' . json_encode($_sobs));
        $this->bsload('category/show_category',
            array(
                'title' => '导入帐套'
                ,'sobs' => $sobs
                ,'sob_info' => $_sob_hash_b64
                ,'sob_exists' => $_exists_sob_b64
                //,'sob_names' => $sob_names
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/index'), 'name' => '帐套和标签', 'class' => '')
                    ,array('url'  => '', 'name' => '导入帐套', 'class' => '')
                ),
            )
        );

    }

    public function cexport(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $this->need_group_it();
        $group = $this->ug->get_my_list();
        $this->bsload('category/exports',
            array(
                'title' => '导入帐套'
                ,'error' => $error
                ,'breadcrumbs' => array(
                    array('url'  => base_url(), 'name' => '首页', 'class' => 'ace-icon fa  home-icon')
                    ,array('url'  => base_url('category/account_set'), 'name' => '帐套和标签', 'class' => '')
                    ,array('url'  => '', 'name' => '导入/导出员工', 'class' => '')
                ),
            )
        );
    }
    public function copy_sob()
    {
        $this->need_group_it();
        $cp_name = $this->input->post('cp_name');
        $sob_id = $this->input->post('sob_id');

        $_buf = $this->account_set->copy_sob($cp_name,$sob_id);
        $buf = json_decode($_buf,True);

        log_message('debug','cp_name:' . $cp_name);
        log_message('debug','sob_id:' . $sob_id);
        log_message('debug','back:' . json_encode($buf));

        if($buf['status'] < 0)
        {
            $this->session->set_userdata('last_error',$buf['data']['msg']);
            return redirect(base_url('category/account_set'));
        }

        $this->session->set_userdata('last_error','帐套复制成功');
        return redirect(base_url('category/account_set'));
    }

    public function remove_sob($sid)
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $sobs = $this->account_set->delete_account_set($sid);
        log_message("debug","#######delete:$sobs");
        return redirect(base_url('category/account_set'));
    }

    public function sob_update($gid = -1)
    {
        if(-1 == $gid) return redirect(base_url('category/account_set'));
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $_ranks = $this->reim_show->rank_level(1);
        $_levels = $this->reim_show->rank_level(0);
//    $_extra = $this->category->get_custom_item();

        $ranks = array();
        $levels = array();
    
        if($_ranks['status']>0)
        {
            $ranks = $_ranks['data'];
        }
    
        if($_levels['status']>0)
        {
            $levels = $_levels['data'];
        }
        $_members = $this->groups->get_my_list();
        $members = array();
        if($_members['status'] > 0)
        {
            $members = $_members['data']['gmember'];
        }
            $_sobs = $this->account_set->get_account_set_list();
        $sobs = array();
        $sob_ranks = array();
        $sob_levels = array();
        $sob_ranks_dic = array();
        $sob_levels_dic =array();
        $sob_members_dic =array();
        $sob_groups = array();
        $sob_members = array();
        $range = '';
        if($_sobs['status'])
        {
            $sobs = $_sobs['data'];
        }
        foreach($sobs as $s)
        {
            if($s['sob_id'] == $gid)
            {
                $sob_ranks = $s['ranks'];
                $sob_levels = $s['levels'];
                $sob_groups = $s['groups']; 
                $sob_members = $s['users'];
                if($sob_groups)
                {
                    $range = 0;
                }
                if($sob_ranks)
                {
                    $range = 1;
                }
                if($sob_levels)
                {
                    $range = 2;
                }
                if($sob_members)
                {
                    $range = 3;
                }
            }
        }
        foreach($sob_ranks as $sr)
        {
            array_push($sob_ranks_dic,$sr['id']);
        }
        foreach($sob_levels as $sl)
        {
            array_push($sob_levels_dic,$sl['id']);
        }
        foreach($sob_members as $sm)
        {
            array_push($sob_members_dic,$sm['id']);
        }
    
        $_categories = $this->category->get_list();
        $categories = array();
        if($_categories['status'] > 0)
        {
            $categories = $_categories['data']['categories'];
        }
        log_message('debug','***category:' . json_encode($_categories));
        $sob_categories = array();
        $all_categories = array();
        $sob_keys =array();
        foreach($categories as $cate)
        {
            $all_categories[$cate['id']]=array();
            $path = "http://api.cloudbaoxiao.com/online/static/" . $cate['avatar'] .".png";
            if($cate['sob_id'] == $gid && $cate['pid'] <= 0 )
            {
                array_push($sob_keys,$cate['id']);
            }
            if(array_key_exists('extra_type',$cate))
            {
                $all_categories[$cate['id']]=array('child'=>array(),'avatar_'=>$cate['avatar'],'avatar'=>$path,'id'=>$cate['id'],'pid'=>$cate['pid'],'name'=>$cate['category_name'],'sob_code'=>$cate['sob_code'],'note'=>$cate['note'],'force_attach'=>$cate['force_attach'], 'max_limit'=>$cate['max_limit'],'extra_type'=>$cate['extra_type'], 'alias_type' => $cate['dest']);
            }
            else
            {
                $all_categories[$cate['id']]=array('child'=>array(),'avatar_'=>$cate['avatar'],'avatar'=>$path,'id'=>$cate['id'],'pid'=>$cate['pid'],'name'=>$cate['category_name'],'sob_code'=>$cate['sob_code'],'note'=>$cate['note'],'force_attach'=>$cate['force_attach'], 'max_limit'=>$cate['max_limit'],'extra_type'=>0, 'alias_type' => $cate['dest']);
            }
        }
                
            $path = "http://api.cloudbaoxiao.com/online/static/0.png";
            $all_categories[0]=array('child'=>array(),'avatar_'=>0,'avatar'=>$path,'id'=>0,'pid'=>-1,'name'=>"顶级分类",'sob_code'=>0,'note'=>'','force_attach'=>0,'extra_type'=>0);
        foreach($categories as $cate)
        {
            if($cate['pid'] !=-1)
            {
            if(array_key_exists($cate['pid'],$all_categories) && array_key_exists('child',$all_categories[$cate['pid']]))
            {
                array_push($all_categories[$cate['pid']]['child'],array('id'=>$cate['id'],'name'=>$cate['category_name']));
            }
            }
        }
    /*
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
    */

        $ugroups = $this->ug->get_my_list();
        log_message('debug','all_categories:' . json_encode($all_categories));
        log_message('debug','sobs:' . json_encode($_sobs));
        log_message('debug','sobs_keys:' . json_encode($sob_keys));
        $this->bsload('account_set/update',
            array(
                'last_error' => $error,
                'title' => '修改帐套'
                //  ,'acc_sets' => $acc_sets
                //  ,'acc_sets' => $acc_sets
                ,'ugroups' => $ugroups['data']['group']
                ,'sob_data' => $sob_groups
                ,'sob_id' => $gid
                ,'sob_keys' => $sob_keys
                ,'all_categories' => $all_categories
                ,'members' => $members
                ,'ranks' => $ranks
                ,'levels' => $levels
                ,'sob_ranks' => $sob_ranks_dic
                ,'sob_levels' => $sob_levels_dic
                ,'sob_members' => $sob_members_dic
                ,'range' => $range
                ,'breadcrumbs' => array(
                    array('url' => base_url(),'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url' => '#','name' => '账套和标签','class' => '')
                    ,array('url' => base_url('category/account_set'),'name' => '帐套管理','class' => '')
                    ,array('url' => '','name' => '帐套编辑','class' => '')
                ),
            )   
        );
    }
    public function new_sob()
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
	    $_ranks = $this->reim_show->rank_level(1);
	    $_levels = $this->reim_show->rank_level(0);
	
	    $ranks = array();
	    $levels = array();
	
	    if($_ranks['status']>0)
	    {
	        $ranks = $_ranks['data'];
	    }
	
	    if($_levels['status']>0)
	    {
	        $levels = $_levels['data'];
	    }
	        
	    $members = array();
	    $_members = $this->groups->get_my_list();
	    if($_members['status'] > 0)
	    {
	        $members = $_members['data']['gmember'];
	    }
	    $groups = array();
	        $_ugroups = $this->ug->get_my_list();
	    if($_ugroups['status']>0)
	    {
	        $groups = $_ugroups['data']['group'];
	    }
        //  $_acc = json_encode($acc_sets);
        // log_message("debug","sob#############$_acc");
        $this->bsload('account_set/new',
            array(
                'title' => '新建帐套'
                //  ,'acc_sets' => $acc_sets
                //  ,'acc_sets' => $acc_sets
                ,'ugroups' => $groups
		        ,'ranks' => $ranks
		        ,'levels' => $levels
		        ,'members' => $members
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
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $sob_name = $this->input->post('sob_name');
        //$save = $this->input->post('renew');
        //log_message("debug","-----------------$groups");
        $ret = $this->account_set->create_account_set($sob_name,'','','','');
        $re = json_encode($ret);
        log_message("debug", "***&&*&*&*:$re");
        $arr = array('helo' => 'jack');
        die(json_encode($re));
        //return redirect(base_url('category/account_set'));
    }

    public function update_sob()
    {
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');

        $range = $this->input->post('range');
        $sid = $this->input->post('sid');
        $sob_name = $this->input->post('sob_name');
        $_groups = $this->input->post('groups');
	    //$_groups = json_decode($_groups,True);
	
	    $_ranks = $this->input->post('ranks');
	    //$_ranks = json_decode($_ranks,True);
	
	    $_levels = $this->input->post('levels');
	    //$_levels = json_decode($_levels,True);
	    $_members = $this->input->post('member');
	    //$_members = json_decode($_members,True);
	    $groups = '';
	    $ranks = '';
	    $levels = '';
	    $members = '';
	
	    switch($range)
	    {
	        case 0 :
	        {
	            if($_groups)
	            {
	                foreach($_groups as &$g)
	                {
	                    $g=(int)$g;
	                }
	                $groups = implode(',',$_groups);
	            }
	            break;
	        }
	
	        case 1:
	        {
	            if($_ranks)
	            {
	                foreach($_ranks as &$r)
	                {
	                    $r=(int)$r;
	                }
	                $ranks = implode(',',$_ranks);
	            }
	            break;
	        }
	
	        case 2:
	        {
	            if($_levels)
	            {
	                foreach($_levels as &$l)
	                {
	                    $l=(int)$l;
	                }
	                $levels = implode(',',$_levels);
	            }
	            break;
	        }
	
	        case 3:
	        {
	            if($_members)
	            {
	                foreach($_members as &$m)
	                {
	                    $m=(int)$m;
	                }
	                $members = implode(',',$_members);
	            }
	            break;
	        }
	
	    }
	        //$save = $this->input->post('renew');
	    log_message('debug','groups:' . $groups);
        $ret = $this->account_set->update_account_set($sid,$sob_name,$groups,$ranks,$levels,$members);
        $re = json_encode($ret);
        log_message("debug", "***&&*&*&*:$re");
        log_message('debug','range:' . $range);
        $arr = array('data' => 'success');
        die(json_encode($arr));
        //return redirect(base_url('category/account_set'));
    }

    public function getsobs()
    {
        $this->need_group_it();
        $_sobs = $this->account_set->get_account_set_list();
	    $sobs = array();
	    if($_sobs['status'])
	    {
	        $sobs = $_sobs['data'];
	    }
        $data = array();

	    foreach($sobs as $s)
	    {
	        $data[$s['sob_id']]['sob_name'] = $s['sob_name'];
	        $data[$s['sob_id']]['groups'] = array();
	        foreach($s['groups'] as $g)
	        {
	            array_push($data[$s['sob_id']]['groups'],array('group_id'=>$g['id'],'group_name'=>$g['name']));
	        }
	    }
	
    /*
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
    */
        die(json_encode($data));
    }

    public function account_set(){
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        log_message('debug','error:' . $error);
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $acc_sets = $this->account_set->get_sobs();
        log_message('debug','account:' . json_encode($acc_sets));
        $sobs = $acc_sets['data'];
        if(!$acc_sets['status'])
        {
            $sobs = array();    
        }

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
        $ugroups = $this->ug->get_my_list();
        //        $_ug = json_encode($ugroups['data']['group']);
        $_acc = json_encode($acc_sets);
        log_message("debug","sob#############".json_encode($acc_set));

        $this->bsload('account_set/index',
            array(
                'title' => '帐套管理'
                //  ,'acc_sets' => $acc_sets
                ,'acc_sets' => $acc_set
                ,'error' => $error
                ,'ugroups' => $ugroups['data']['group']
                ,'breadcrumbs' => array(
                    array('url' => base_url(),'name' => '首页', 'class' => 'ace-icon fa home-icon')
                    ,array('url' => '#','name' => '账套和标签','class' => '')
                    ,array('url' => '','name' => '帐套管理','class' => '')
                ),
            )   
        );
    }
    public function index(){
        $this->need_group_it();
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
        if(!$sobs['status'])
        {
            $_sobs = array();
        }

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

        $_group = array();
        if($category){
            $_group = $category['data']['categories'];
        }
        $category_group = array();
        foreach ($_group as $item) {
            log_message("debug", "Item:" . json_encode($item));
            if(array_key_exists('sob_id', $item)) {
            if($item['sob_id'] == 0 || $item['sob_id'] == '0') {   
                $item['sob_name'] = "默认帐套";
                $item['note'] = "";
                $item['sob_code'] = "";
                $item['sob_id'] = 0;
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
            } else {
                $item['sob_name'] = "默认帐套";
                $item['note'] = "";
                $item['sob_code'] = "";
                $item['sob_id'] = 0;
                $category_group[] = $item;
                continue;
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
        $this->need_group_it();
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $tags = $this->tags->get_list();
        if($tags['status'] > 0)
        {
            if($tags){
                $tags = $tags['data']['tags'];
            }
        }
        else
        {
            $tags = array();
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
        $this->need_group_it();
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

    public function create_category()
    {
        $this->need_group_it();
	    $cid = $this->input->post('cid');
	    $name=$this->input->post('name');
	    $avatar = $this->input->post('avatar');
	    $code=$this->input->post('code');
	    $sob_id = $this->input->post('sob_id');
	    $pid = $this->input->post('pid');
	    $note = $this->input->post('note');
	    $max_limit = $this->input->post('max_limit');
	    $_force_attach = $this->input->post('force_attach');
	    $extra_type = $this->input->post('extra_type');
	    $alias_type = $this->input->post('alias_type');
	    $force_attach = 0;
	    if($_force_attach)
	    {
	        $force_attach = 1;
	    }
	        
	    log_message('debug','cid:' . $cid);
	    log_message('debug','name:' . $name);
	    log_message('debug','avatar:' . $avatar);
	    log_message('debug','code:' . $code);
	    log_message('debug','note:' . $note);
	    log_message('debug','force_attach:' . $force_attach);
	    log_message('debug', 'max_limit:' . $max_limit);
	    log_message('debug', 'extra_type:' . $extra_type);
	    
	    $obj = $this->category->create_update($cid,$pid,$sob_id,$name,$avatar,$code,$force_attach,$note,$max_limit,$extra_type, $alias_type);
	    if($obj['status'] > 0)
	    {
	        $this->session->set_userdata('last_error','添加成功');
	        return redirect(base_url('category/sob_update/' . $sob_id));
	    }   
	    else
	    {
	        $this->session->set_userdata('last_error','添加失败');
	        return redirect(base_url('category/sob_update/' . $sob_id));
	    }
    }
    public function create(){
        $this->need_group_it();
        $name = $this->input->post('category_name');
        $sob_code = $this->input->post('sob_code');
        $pid = $this->input->post('pid');
        $sob_id = $this->input->post('sob_id');
        $note = $this->input->post('note');
        $prove_ahead= $this->input->post('prove_ahead');
        $max_limit = $this->input->post('max_limit');
        $cid = $this->input->post('category_id');
        $avatar = $this->input->post('avatar');
        $force_attach = $this->input->post('force_attach');
        $force_attach = $force_attach == "on" ? 1 : 0;
        $gid = $this->input->post('gid');
        $extra_type = $this->input->post('extra_type');
        log_message("debug","\n#############GID:$gid");
        $sob_id = $this->input->post('sob_id');

        log_message("debug","\n#############GID:$gid");
        log_message("debug","\n#############extra_type:$extra_type");
        log_message("debug","\n#############attach:$force_attach");
        $msg = '添加分类失败';
        $obj = null;
        if($cid > 0){
            $obj = $this->category->update($cid, $name, $pid, $sob_id, $prove_ahead, $max_limit, $note, $sob_code, $avatar, $force_attach,$extra_type);
        } else {
            $obj = $this->category->create($name, $pid, $sob_id, $prove_ahead, $max_limit, $note, $sob_code, $avatar, $force_attach,$extra_type);
        }
        if($obj && $obj['status']){
            $msg = '添加分类成功' . $note;
        } else {
            $msg = $obj['data']['msg'];
        }
        $this->session->set_userdata('last_error', $msg);
        redirect(base_url('category'));
    }

    public function drop($id,$sob_id = -1){
        $this->need_group_it();
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
    if($sob_id == -1)
    {
            return  redirect(base_url('category'));
    }
    return redirect(base_url('category/sob_update/' . $sob_id));
    }
    public function gettreelist(){
        $this->need_group_it();
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
	    log_message('debug','sobs:' . json_encode($sobs));
	    $_sobs = array();
	    if($sobs['status']>0)
	    {
	            $_sobs = $sobs['data'];
	    }
        $data = array();
        foreach($_sobs as $sob)
        {
            if(array_key_exists($sob['sob_id'],$data))
            {
            $data[$sob['sob_id']]['groups'] = $sob['groups'];
            }
            else
            {
                $data[$sob['sob_id']]=array();
                $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                $data[$sob['sob_id']]['groups'] = $sob['groups'];
                $data[$sob['sob_id']]['category'] = array();
            }
        }
        $data[0] = array();
        $data[0]['sob_name'] = '默认帐套';
        $data[0]['groups'] = array();
        $data[0]['category'] = array();
        $category = $this->category->get_list();
        $categories = $category['data']['categories'];
        $cate_dic = array();
        //没有上级类目的顶级类目
        $root_cate = array();
        foreach($categories as $item)
        {
            if($item['pid'] <= 0) 
            {
                $root_cate[$item['id']] = $item;
                continue;
            }
            if(!array_key_exists($item['pid'],$root_cate)) continue;
            if(!array_key_exists('children',$root_cate[$item['pid']]))
            {
                $root_cate[$item['pid']]['children'] = array();
            }
            array_push($root_cate[$item['pid']]['children'],$item);
        }
        log_message('debug','root_cate:' . json_encode($root_cate));
        foreach($root_cate as $key => $value)
        {
            if(array_key_exists($value['sob_id'],$data))
                array_push($data[$value['sob_id']]['category'],$value);
        }
        
        log_message('debug','data' . json_encode($data));
        die(json_encode($data));
    }
    public function get_my_sob_category($uid=0)
    {
        if($uid > 0)
    {
            $__profile = $this->users->reim_get_info($uid);
        $_profile = json_decode($__profile,True);
        if($_profile['status'] < 0)
        {
            die(json_encode(array('msg'=>'返回值错误')));
        }

        $profile = $_profile['data'];
        
        log_message('debug','user_info:'.json_encode($_profile));
    }
    else
    {
             $profile = $this->session->userdata('profile');
    }
        $sobs = $profile['sob'];
        $_sob_id = array();
        //$_my_sobs = array();
        log_message('debug',"__________sobs:".json_encode($sobs));
        foreach($sobs as $i) {
            log_message('debug', "alvayang:" . json_encode($i));
            array_push($_sob_id, $i['sob_id']);
        }
        if(count($_sob_id) == 0) {
            $__sob_id = 0;
            $data[0]=array();
            $data[0]['sob_name']= '默认帐套';
            $data[0]['groups'] = array();
            $data[0]['category'] = array();
            $groups = $data[0]['groups'];
        } else {
            $sobs = $this->account_set->get_account_set_list();
            $_sobs = $sobs['data'];
            $data = array();
            foreach($_sobs as $sob)
            {
                if(!in_array($sob['sob_id'], $_sob_id)) continue;
                if(array_key_exists($sob['sob_id'],$data))
                {
                    $data[$sob['sob_id']]['groups'] = $sob['groups'];
                }
                else
                {
                    $data[$sob['sob_id']]=array();
                    $data[$sob['sob_id']]['sob_name']=$sob['sob_name'];
                    $data[$sob['sob_id']]['groups'] = array();
                    $data[$sob['sob_id']]['category'] = array();
                    $data[$sob['sob_id']]['groups'] = $sob['groups'];
                }
            }
        }
        $category = $this->category->get_list();
        $categories = $category['data']['categories'];
        $cate_dic = array();
        //没有上级类目的顶级类目
        $root_cate = array();
        foreach($categories as $item)
        {
            if($item['pid'] <= 0) 
            {
                $root_cate[$item['id']] = $item;
                continue;
            }
            if(!array_key_exists($item['pid'],$root_cate)) continue;
            if(!array_key_exists('children',$root_cate[$item['pid']]))
            {
                $root_cate[$item['pid']]['children'] = array();
            }
            array_push($root_cate[$item['pid']]['children'],$item);
        }
        log_message('debug','root_cate:' . json_encode($root_cate));
        foreach($root_cate as $key => $value)
        {
            if(array_key_exists($value['sob_id'],$data))
                array_push($data[$value['sob_id']]['category'],$value);
        }
        
        log_message('debug','data' . json_encode($data));

        die(json_encode($data));
    }
}
