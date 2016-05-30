<?php

class Company_Model extends Reim_Model {

    public function set_single_company_config($key,$value)
    {
        $data = array('key'=>$key,'value'=>$value);
        return $this->get_put('company_config', $data);
    }

    public function get_company_config()
    {
        return $this->api_get('company_config');
    }

    public function deny_report_finance($rid,$comment)
    {
        return $this->api_post('report_finance_flow/deny/' . $rid, array('comment' => $comment));
    }

    public function pass_report_finance($rid)
    {
        return $this->api_post('report_finance_flow/pass/' . $rid);
    }

    public function get_report_finance_permission($rid)
    {
        return $this->api_get('report_finance_flow/check_permission/' . $rid);
    }

    public function report_property_delete($id)
    {
        return $this->api_delete('report_property/' . $id);
    }

    public function report_property_update($name,$config,$id)
    {
        $data = array('name' => $name, 'config' => $config);
        return $this->api_put('report_property/' . $id, $data);
    }

    public function report_property_create($name,$config)
    {
        $data = array('name' => $name, 'config' => $config);
        return $this->api_post('report_property', $data);
    }

    public function get_single_reports_settings($id)
    {
        return $this->api_get('report_property/' . $id);
    }

    public function get_reports_settings_list()
    {
        return $this->api_get('report_property/0');
    }

    public function delete_approve($pid)
    {
        return $this->api_delete('audit_policy/'.$pid);
    }

    public function show_approve()
    {
        return $this->api_get('audit_policy');
    }

    public function create_approve($name,$members,$amount,$allow_all_category,$policies,$pid=-1,$ranks,$levels,$groups)
    {
        if($pid == -1) {
            $data = array(
                'name'=>$name,
                'members'=>$members,
                'amount'=>$amount,
                'allow_all_category'=>$allow_all_category,
                'policies'=>$policies
            );
        } else {
            $data = array(
                'pid'=>$pid,
                'name'=>$name,
                'members'=>$members,
                'amount'=>$amount,
                'allow_all_category'=>$allow_all_category,
                'policies'=>$policies
            );
        }
        return $this->api_post('audit_policy', $data);
    }

    public function delete_rule($pid)
    {
        return $this->api_delete('commit_policy/'.$pid);
    }

    public function show_rules()
    {
        return $this->api_get('commit_policy');
    }

    public function update_rule($rid,$name,$category,$count,$period,$all_company,$groups,$members,$ranks,$levels)
    {
        if($all_company==1) {
            $data=array(
                'pid' => $rid,
                'name'=>$name,
                'category'=>$category,
                'count'=>$count,
                'period'=>$period,
                'all_company'=>$all_company,
            );
        } else {
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
        return $this->api_post('commit_policy', $data);
    }

    public function create_update_rules($name,$ugids,$mems,$level,$rank,$policies,$all_company,$pid=0)
    {
        $data = array(
            'name'=>$name,
            'groups'=>$ugids,
            'members'=>$mems,
            'levels'=>$level,
            'ranks'=>$rank,
            'policies'=>$policies,
            'all_company'=>$all_company
        );
        if ($pid) {
            $data['pid'] = $pid;
        }
        return $this->api_post('commit_policy', $data);
    }

    public function get(){
        return $this->api_get('company_admin');
    }

    public function profile($config, $maxlimit = 0) {
        $data = array('config' => json_encode($config),);
        return $this->api_post('company_admin', $pdata);
    }

    public function update($cid, $name, $pid, $prove_ahead = 0, $maxlimit = 0) {
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'limit' => $maxlimit,
            'pb' => $prove_ahead
        );
        return $this->api_put('category/' . $cid, $data);
    }

    public function remove($cid){
        return $this->api_delete('category/' . $cid);
    }

    public function create_finance_policy($name) {
        return $this->api_post('finance_policy', array('name' => $name));
    }

    public function get_finance_policy(){
        return $this->api_get('finance_policy');
    }

    public function get_single_finance_policy($id)
    {
        return $this->api_get('finance_policy/' . $id);
    }

    public function drop_finance_policy($id) {
        return $this->api_delete('finance_policy/' . $id);
    }

    public function update_finance_policy($fid,$name,$policies,$gids)
    {
        $data = array(
            'name' => $name,
            'step' => $policies,
            'gid' => $gids
        );
        return $this->api_put('finance_policy/' . $fid, $data);
    }

}
