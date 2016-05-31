<?php

class Reim_Show_Model extends Reim_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('items_model', 'items');
        $this->load->model('report_model', 'reports');
    }
    

    public function get_report_template()
    {
        $_report_template = $this->reports->get_report_template();
        $report_template = array();
        $report_template_dic = array();
        if($_report_template['status'] > 0)
        {
            $report_template = $_report_template['data'];    
        }
        foreach($report_template as $rt)
        {
            $report_template_dic[$rt['id']] = $rt['name'];
        }

        return $report_template_dic;
    }

    public function get_item_type_name()
    {
        $obj = $this->items->get_item_type_name();
        $item_type_dic = array();
        $item_type_dic[0] = '报销';
        $item_type_dic[1] = '预算';
        $item_type_dic[2] = '预借';
        $item_types = array();

        if($obj['status'] > 0)
        {
            $item_types = $obj['data'];
        }

        foreach($item_types as $item)
        {
            $item_type_dic[$item['type']] = $item['name'];    
        }
        return $item_type_dic;
    }

    public function usergroups()
    {
        $obj = $this->api_get('user_group/list');
        $usergroups = array();
        if($obj['status']>0)
        {
            $data = $obj['data']['group'];
            foreach($data as $g)
            {
                array_push($usergroups,array('id' => $g['id'],'name' => $g['name']));
            }
        }
        log_message('debug','usergroup:' . json_encode($usergroups));
        return $usergroups;
    }

    public function rank_level($type = 1)
    {
        return $this->api_get('rank/' . $type);
    }
}
