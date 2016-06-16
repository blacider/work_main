<?php

class UserGroup_Model extends Reim_Model {

    public function get_my_list(){
        return $this->api_get('user_group/list');
    }

    public function create_group($manager,$uids,$name,$code,$pid,$images)
    {
        $data = array(
            'name' => $name,
            'uids' => $uids,
            'pid' => $pid,
            'manager' => $manager,
            'code' => $code,
            'images' => $images
        );
        log_message("debug", "create group with " . json_encode($data));
        return $this->api_post('user_group', $data);
    }

    public function update_data($manager,$uids, $name,$code,$pid,$gid = 0,$images){
        $data = array(
            'manager' => $manager
            ,'name' => $name
            ,'code' => $code
            ,'uids' => $uids
            ,'pid' => $pid
            ,'id' => $gid
            ,'images' => $images
        );
        return $this->api_post('user_group', $data);
    }

    public function delete_group($id) {
        return $this->api_delete('user_group/' . $id);
    }

    public function get_single_group($id) {
        return $this->api_get('user_group/single/' . $id);
    }
}

