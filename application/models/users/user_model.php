<?php

class User_model extends CI_Model {
    private $_table_name;

    public function __construct(){
        $this->_table_name = 'tbl_admin';
    }

    public function get_user($username){
        if(empty($username)){
            return array();
        }
        $query = $this->db->get_where($this->_table_name, array('username' => $username));
        return $query->row_array();
    }

    public function get_all(){
        $count = $this->db->count_all($this->_table_name);
        return array('data' => $this->db->get($this->_table_name)->result_array(), 'total' => $count);
    }

    public function get_by_id($id){
        return $this->db->get_where($this->_table_name, array('id' => $id))->row_array();
    }

    public function get_user_by_museum($role_id){
        $query = $this->db->get_where($this->_table_name, array('mid' => $role_id));
        return $query->result();
    }

    public function update_avatar($path, $uid){
        $data = array('avatar' => $path);
        $this->db->where('id', $uid);
        $this->db->update('tbl_user', $data);
        return true;
    }


    public function update_admin($user_id, $nickname, $role = 1, $ascription = 1, $password = ''){
        $data = array(
            'nickname' => $nickname,
            'role' => $role,
            'ascription' => $ascription
        );
        if(!empty($password)){
            $data['passwd'] = md5($password);
        }
        $this->db->where('id', $user_id);
        return $this->db->update($this->_table_name, $data);
    }


    public function remove_by_id($id){
	if(!$id) return false;
        return $this->db->delete($this->_table_name, array('id' => $id));
    }

    public function remove_by_museum($role_id){
        $this->db->where('mid', $role_id);
        return $this->db->update($this->_table_name, $data);
    }

    public function create($username, $password, $nickname, $ascription = 1, $role = 1){
        if(empty($username) || empty($password)){
            return false;
        }
        $create_time = time();
        $data = array(
            'username' => $username,
            'passwd' => md5($password),
            'nickname' => $nickname,
            'create_dt' => $create_time,
	    'ascription' => $ascription,
	    'role' => $role
        );
        $insert_res = $this->db->insert($this->_table_name, $data);
        if($insert_res){
            $_id = $this->db->insert_id();
            return $_id;
        }
        else{
            return 0;
        }
    }

}

