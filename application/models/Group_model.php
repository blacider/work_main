<?php

class Group_Model extends Reim_Model {

    public function batch_del($members)
    {
        $data = array('members' => $members);
        return $this->api_delete('load', $data);
    }

    public function set_managers($persons)
    {
        $data = array();
        foreach($persons as $p){
            array_push($data, $p);
        }
        $data = array('relations' => json_encode($data));
        return $this->api_put('load', $data);
    }

    public function reim_imports($data)
    {
        return $this->api_post('load', $data);
    }

    public function update_rank_level($rank,$id,$name)
    {
        $data = array (
            'name' => $name,
            'rank' => $rank,
            'id' => $id
        );
        return $this->api_put('rank', $data);
    }

    public function del_rank_level($rank,$id)
    {
        return $this->api_delete('rank/' . $id . '/' . $rank);
    }

    public function get_rank_level($rank)
    {
        return $this->api_get('rank/' . $rank);
    }

    public function create_rank_level($rank,$name,$uids='')
    {
        $data = array (
            'name' => $name,
            'rank' => $rank
        );
        return $this->api_post('rank', $data);
    }


    public function get_my_full_list() {
        return $this->api_get('groups/0/full');
    }

    public function get_my_list(){
        return $this->api_get('groups/0');
    }

    public function remove_user($uid = 0){
        return $this->api_delete('staff/' . $uid);
    }

    public function delete_group($id) {
        return $this->api_delete('user_group/' . $id);
    }
}

