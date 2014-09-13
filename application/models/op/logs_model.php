<?php
class Logs_model extends CI_Model {
    private $_table_name;

    public function __construct(){
        $this->_table_name = 'tbl_logs';
    }


    public function create($host, $level, $type, $message = ''){
        $data = array(
            'level' => $level
            ,'host' => $host
            ,'message' => $message
            ,'type' => $type
        );
        $this->db->insert($this->_table_name, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function list_logs($page = 0, $pagesize = 10, $host = '', $level = '', $type = ''){
        if($host){
            $this->db->where('host', $host);
        }
        if($level){
            $this->db->where('level', $level);
        }
        if($type){
            $this->db->where('type', $type);
        }
        $total = $this->db->count_all();

        if($host){
            $this->db->where('host', $host);
        }
        if($level){
            $this->db->where('level', $level);
        }
        if($type){
            $this->db->where('type', $type);
        }
        $data = $this->db->get($this->_table_name, $pagesize, $page * $pagesize)->result_array();
        return array('data' => $data, 'total' => $total);

    }
    public function index(){
    }
}
