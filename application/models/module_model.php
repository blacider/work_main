<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Module_model extends Reim_Model {

    private $_table_name;

    public function __construct(){
        //        $this->db = $this->load->database('scm', TRUE);
        $this->_table_name = 'tbl_module';
    }

    public static function get_tablename(){
        return $this->_table_name;
    }

    public function get(){
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }

    public function create($title, $desc, $path, $group_id){
        if(empty($title) || empty($path)){
            return false;
        }
        $create_time = time();
        $data = array(
            'title' => $title,
            'description' => $desc,
            'path' => $path,
            'group_id' => $group_id,
            'create_time' => $create_time,
        );
        return $this->db->insert($this->_table_name, $data);
    }

    public function delete($id){
        return $this->db->delete($this->_table_name, array('id' => $id));
    }
}
