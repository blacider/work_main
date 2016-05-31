<?php

class Category_Model extends Reim_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function delete_fee_afford($fid)
    {
        return $this->api_delete('fee_afford/' . $fid);
    }

    public function get_fee_afford($fid)
    {
        return $this->api_get('fee_afford/' . $fid);
    }

    public function update_fee_afford($pid,$oid,$standalone,$uids,$gids,$ranks,$levels) {
        $data = array(
            "pid" => $pid,
            "objects" => json_encode($oid),
            "standalone" => $standalone,
            "privilege" => json_encode(array(
                "users" => $uids,
                "groups" => $gids,
                "ranks" => $ranks,
                "levels" => $levels
            ))
        );
        return $this->api_put('fee_afford', $data);
    }

    public function create_fee_afford($pid,$oid,$standalone,$uids,$gids,$ranks,$levels)
    {
        $data = array(
            "pid" => $pid,
            "objects" => json_encode($oid),
            "standalone" => $standalone,
            "privilege" => json_encode(array(
                "users" => $uids,
                "groups" => $gids,
                "ranks" => $ranks,
                "levels" => $levels
            ))
        );
        return $this->api_post('fee_afford', $data);
    }

    public function get_afford_project($eid = 0)
    {
        return $this->api_get('fee_afford_project/' . $eid);
    }

    public function del_fee_afford_project($id)
    {
        return $this->api_delete('fee_afford_project/' . $id);
    }

    public function update_fee_afford_project($id,$name)
    {
        $data = array('name' => $name);
        return $this->api_put('fee_afford_project/' . $id, $data);
    }

    public function expense_create($name)
    {
        $data = array('name' => $name);
        return $this->api_post('fee_afford_project', $data);
    }

    public function get_custom_item()
    {
        return $this->api_get('custom_item');
    }

    public function get_list(){
        return $this->user_model->get_common();
    }

    public function create_update($cid = 0,$pid,$sob_id, $name, $avatar,$code,$force_attach,$note, $max_limit = 0 , $extra_type, $alias_type)
    {
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'sob_id' => $sob_id,
            'avatar' => $avatar,
            'sob_code' => $code,
            'force_attachement' => $force_attach,
            'note' => $note,
            'limit' => $max_limit,
            'extra_type' => $extra_type,
            'alias_type' => $alias_type
        );
        if(0 == $cid) {
            return $this->api_post('category', $data);
        } else {
            return $this->api_put('category/' . $cid, $data);
        }
    }

    public function create($name, $pid, $sob_id, $prove_ahead = 0, $maxlimit = 0, $note = "", $sob_code = 0 , $avatar = 0, $force_attach = 0 , $extra_type=0) {
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'sob_id' => $sob_id,
            'note' => $note,
            'limit' => $maxlimit,
            'pb' => $prove_ahead,
            'sob_code' => $sob_code,
            'avatar' => $avatar,
            'force_attachement' => $force_attach,
            'extra_type' => $extra_type
        );
        return $this->api_post('category', $data);
    }

    public function update($cid, $name, $pid, $sob_id, $prove_ahead = 0, $maxlimit = 0, $note = "", $sob_code = 0 , $avatar = 0,$force_attach , $extra_type) {
        $data = array(
            'name' => $name,
            'pid' => $pid,
            'sob_id' => $sob_id,
            'sob_code' => $sob_code,
            'note' => $note,
            'limit' => $maxlimit,
            'pb' => $prove_ahead,
            'avatar' => $avatar,
            'force_attachement' => $force_attach,
            'extra_type' => $extra_type
        );
        return $this->api_put('category/' . $cid, $data);
    }

    public function remove($cid){
        return $this->api_delete('category/' . $cid);
    }

    public function get_sob_tree() {
        return $this->api_get('sob/tree');
    }
}
