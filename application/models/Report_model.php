<?php

class Report_Model extends Reim_Model {

    public function confirm_success($rid)
    {
        $data = array(
            'act' => 'confirm',
            'status' => 2,
            'rids' => $rid
        );
        return $this->api_put('success', $data);
    }

    public function get_snapshot_by_report_id($id) {
        return $this->api_get('report/'.$id.'/snapshot');
    }

    public function get_finance_report_by_ids($ids) {
        $query = [
            'ids' => implode('|', $ids),
        ];
        return $this->api_get('report_finance_flow/list/1', $query);
    }

    public function get_report_by_status_and_query(
        $status,
        $keyword,
        $dept,
        $submit_startdate,
        $submit_enddate,
        $approval_startdate,
        $approval_enddate
    ) {
        $query = array(
            'keyword='. $keyword,
            'dept='. $dept,
            'submit_startdate='. $submit_startdate,
            'submit_enddate='. $submit_enddate,
            'approval_startdate='. $approval_startdate,
            'approval_enddate='. $approval_enddate
        );
        return $this->api_get('report_finance_flow/list/'.$status, null, $query);
    }

    public function update_report_template($id, $name, $config, $type, $options)
    {
        $data = array(
            'id' => $id,
            'type' => $type,
            'name' => $name,
            'config' => json_encode($config),
            'options' => json_encode($options)
        );
        return $this->api_put('report_template/' . $id, $data);
    }

    public function create_report_template($name,$config, $type)
    {
        $data = array(
            'name' => $name,
            'config' => $config,
            'type' => implode(',', $type)
        );
        return $this->api_post('report_template', $data);
    }

    public function get_report_template($id = 0)
    {
        if(0 == $id) {
            $url = 'report_template';
        } else {
            $url = 'report_template/' . $id;
        }
        return $this->api_get($url);
    }

    public function delete_report_template($id)
    {
        return $this->api_delete('report_template/' . $id);
    }

    public function add_comment($rid,$comment)
    {
        $data = array(
            'comment' => $comment
        );
        return $this->api_put('report/'.$rid, $data);
    }

    public function revoke($rid)
    {
        return $this->api_get('revoke/'.$rid);
    }

    public function export_pdf($rids, $email=null) {
        $data = array(
            'rid' => $rids,
            'email' => $email,
        );
        return $this->api_post('exports', $data);
    }

    public function get_permission($rid) {
        return $this->api_get("check_approval_permission/$rid");
    }

    public function get_detail($rid){
        return $this->api_get("report/$rid");
    }

    public function delete_report($rid){
        return $this->api_delete("report/$rid");
    }

    public function get_bills_by_status_and_query($status = 2, $keyword, $dept, $startdate, $enddate){
        $query = array(
            'keyword='. $keyword,
            'dept='. $dept,
            'startdate='. $startdate,
            'enddate='. $enddate
        );

        return $this->api_get('bills/'.$status, null, $query);
    }

    public function get_bills($status = -2){
        return $this->api_get("bills/" . $status);
    }

    public function get_finance($status = 1){
        return $this->api_get("report_finance_flow/list/" . $status);
    }

    public function get_all_bills(){
        return $this->api_get("bills/2");
    }

    public function create_v2($report)
    {
        return $this->api_post("report", $report);
    }

    public function update_v2($report)
    {
        $id = $report['id'];
        $url = "report/$id";
        if($report['is_approver']) {
           $url = "report/$id/modify";
        }
        return $this->api_put($url, $report);
    }

    public function get_report_by_id($id) {
        return $this->api_get("report/$id");
    }

    public function get_reports_by_ids($ids) {
        $data = array(
            'ids' => $ids
        );
        return $this->api_post("reports", $data);
    }

    public function audit_report($rid, $status, $receivers, $content = '') {
        $data = array(
            'status' => $status,
            'manager_id' => $receivers,
            'comment' => $content
        );
        return $this->api_put("report/$rid", $data);
    }

    public function report_flow($rid, $grouping = 0) {
        return $this->api_get("report_flow/$rid/1/$grouping");
    }

    public function multi_report_flow($rids) {
        $data = array(
            'rids' => implode(',', $rids),
        );
        return $this->api_post("report_flow", $data);
    }

    public function submit_check($manager_ids, $iids, $template_id, $extras){
        $data = array(
            'iids' => $iids,
            'manager_ids' => $manager_ids,
            'template_id' => $template_id,
            'extras' => json_encode($extras),
        );
        return $this->api_post("check_submit_flow", $data);
    }
}
