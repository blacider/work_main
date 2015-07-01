<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role_model extends Reim_Model {
    private $_table_name;
    //    private $db;
    public function __construct(){
        //        $this->db = $this->load->database('scm', TRUE);
        $this->_table_name = 'tbl_role';
    }

    public function get(){
        return $this->db->get($this->_table_name)->result();
    }

    public function get_role_by_id($id = ''){
        if(empty($id)){
            return array();
        }
        $query = $this->db->get_where($this->_table_name, array('id' => $id));
        return $query->row();
    }

    public function get_role_by_page($pn = 0, $rn = 10){
        if($pn < 0 || $rn <= 0){
            return array();
        }
        $limit = $rn;
        $offset = $pn * $rn;
        $query = $this->db->get_where($this->_table_name, array(), $limit, $offset);
        return $query->result();
    }

    public function get_role_count(){
        return $this->db->count_all_results($this->_table_name);
    }

    public function del($id){
        return $this->db->delete($this->_table_name, array('id' => $id));
    }
    public function update_role_name($id, $new_name){
        $data = array(
            'name' => $new_name,
        );
        $this->db->where('id', $id);
        return $this->db->update($this->_table_name, $data);
    }

    public function create($title){
        if(empty($title)){
            return false;
        }
        $data = array(
            'name' => $title,
            'create_time' => time(),
        );

        $insert_res = $this->db->insert($this->_table_name, $data);
        if($insert_res){
            $_id = $this->db->insert_id();
            return $_id;
        }
        else{
            return false;
        }
    }
}
