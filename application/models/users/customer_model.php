<?php

class Customer_model extends CI_Model {
    public static  $table_name = 'tbl_customers';

    public function get_all_customers(){
        $count = $this->db->count_all(self::$table_name);
        return array('data' => $this->db->get(self::$table_name)->result_array(), 'count' => $count);
    }

    public function get_customer_by_id($id){
        if(empty($id)){
            return array();
        }
        $query = $this->db->get_where(self::$table_name, array('id' => $id));
        return $query->row_array();
    }

    public function destory_customer_by_id($id){
        return $this->db->delete(self::$table_name, array('id' => $id));
    }

    public function create($name) {
        $this->db->insert(self::$table_name, array('name' => $name));
        return $this->db->insert_id();
    }

    public function update_customer($id, $name){
        $this->db->where('id', $id);
        return $this->db->update(self::$table_name, array('name' => $name));
    }
}
