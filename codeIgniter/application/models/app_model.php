<?php
class App_Model extends Reim_Model {

    public function create($platform, $verison, $prefix){
        $data = array(
            'platform' => $platform
            ,'version' => $verison
            ,'path' => $prefix
            ,'online' => 0
            ,'create_time' => time()
        );
        $this->db->insert(self::APP_TABLE, $data);
        return $this->db->insert_id();
    }

    public function get_all(){
        return $this->db->get(self::APP_TABLE)->result_array();
    }

    public function get_one($id){
        $this->db->where('id', $id);
        return $this->db->get(self::APP_TABLE)->row_array();
    }
    public function set_default($aid, $online = 0) {
        $this->db->where('id', $aid);
        $this->db->update(self::APP_TABLE, array('online' => $online));
    }
    public function drop($id){
        $this->db->where('id', $id);
        return $this->db->delete(self::APP_TABLE);
    }

    public function find_online($type = 0){
        $this->db->where(array('platform' => $type, 'online' => 1));
        $this->db->order_by('id', 'desc');
        return $this->db->get(self::APP_TABLE, 1)->row_array();
    }
    public function find_all_online(){
        $this->db->where(array('online' => 1));
        $this->db->order_by('id', 'desc');
        return $this->db->get(self::APP_TABLE)->result_array();
    }
}
