<?php

class Company_Model extends Reim_Model {

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
        return $this->api_post('company_admin', $data);
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
