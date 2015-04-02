<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role_Module_Relation_model extends Reim_Model {

    private $_table_name;
    //    private $db;

    public function __construct(){
        //        $this->db = $this->load->database('scm', TRUE);
        $this->_table_name = 'tbl_role_module_r';
    }

    public function get(){
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }

    public function delete_by_module_id($id){
        return $this->db->delete($this->_table_name, array('module_id' => $id));
    }

    public function delete_by_role_id($id){
        return $this->db->delete($this->_table_name, array('role_id' => $id));
    }

    public function delete($id){
        return $this->db->delete($this->_table_name, array('id' => $id));
    }

    public function create_batch($role_id, Array $module_ids){
        if(empty($module_ids)){
            return false;
        }
        $data = array();
        $create_time = time();
        foreach($module_ids as $module_id){
            $data[] = array(
                'role_id' => $role_id,
                'module_id' => $module_id,
                'create_time' => $create_time,
            );
        }
        return $this->db->insert_batch($this->_table_name, $data);
    }

    public function get_by_role_id($id){
        $this->db->where_in('role_id', $id);
        $this->db->order_by('role_id asc, module_id asc');
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }
}
