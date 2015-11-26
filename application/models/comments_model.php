<?php

class Comments_Model extends Reim_Model {
    //const ERRORS_TABLE_NAME = "tbl_feedback";
    //const USERSTABLE = "tbl_member";

    public function get_list($page = 0, $size = 20){
        //$jwt = $this->session->userdata('jwt');
        //if(!$jwt) return false;
		$url = $this->get_url('feedback');

        $jwt = array();
        log_message("debug", "URL:" . $url);
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
        /*
        $data = $this->load->database('data', True);
        $handler = clone($data);
        $count = $handler->count_all_results(self::ERRORS_TABLE_NAME);
        $offset = $page * $size;
        $data->join(self::USERSTABLE, self::USERSTABLE . ".id = " . self::ERRORS_TABLE_NAME . ".uid");
        $data->offset($offset);
        $data->limit($size);
        $data->select(self::USERSTABLE . ".nickname, " . self::USERSTABLE . ".email," . self::USERSTABLE . ".phone, " . self::ERRORS_TABLE_NAME . ".*");
        $data->order_by(self::ERRORS_TABLE_NAME . ".createdt", "desc");
        $_data = $data->get(self::ERRORS_TABLE_NAME)->result_array();
        log_message("debug", $data->last_query());
        return array('total' => $count, 'data' => $_data);
         */
    }


    public function add_worker($work_id, $msg, $mid){
		$url = $this->get_url('feedback');
        $jwt = array();
        log_message("debug", "URL:" . $url);
        $data = array('msg' => $msg, 'work_id' => $work_id, 'mid' => $mid);
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "model:" . $buf);
		$obj = json_decode($buf, true);
        return $obj;
        /*
        $sdb = $this->load->database('data', True);
        $createdt = date('Y-m-d H:i:s', time());
        $data = array(
            'worker_id' => $work_id
            ,'feedback' => $msg
            ,'feed_dt' => $createdt
        );
        $sdb->where(self::ERRORS_TABLE_NAME . ".id", $mid);
        $sdb->update(self::ERRORS_TABLE_NAME, $data);
        log_message("debug", "Here" . $sdb->last_query());
         */
        //return true;
    }
}
