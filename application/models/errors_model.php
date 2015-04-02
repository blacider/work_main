<?php

class Errors_Model extends Reim_Model {
    const ERRORS_TABLE_NAME = "tbl_errors";
    /*
    public function create($api, $msg, $level, $host = ''){
        $this->load->database('data', True);
        $createdt = date('Y-m-d H:i:s', time());
        $data = array(
            'host' => $host
            ,'api' => $api
            ,'level' => $level
            ,'msg' => $msg
            ,'createdt' => $createdt
        );
        $this->db->insert(self::ERRORS_TABLE_NAME, $data);
        return $this->db->insert_id();
    }
     */


    public function get_list($page = 0, $size = 20, $type = "", $host = "", $level = 0, $ts_start = 0, $ts_end = 9999999999){
        $data = $this->load->database('data', True);
        if($type) {
            $data->where('api', $type);
        }
        if($host) {
            $data->where('host', $host);
        }
        if($level) {
            $data->where('level', $level);
        }
        $handler = clone($data);
        $count = $handler->count_all_results(self::ERRORS_TABLE_NAME);
        $offset = $page * $size;
        $data->offset($page);
        $data->limit($size);
        $data->order_by('id', 'desc');
        $_data = $data->get(self::ERRORS_TABLE_NAME)->result_array();
        log_message("debug", $data->last_query());
        return array('total' => $count, 'data' => $_data);
    }
}
