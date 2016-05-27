<?php
class Account_Set_Model extends Reim_Model{
    public function copy_sob($cp_name,$sob_id)
    {
        $data = array(
            'act' => 'dup',
            'name' => $cp_name,
            'tid' => $sob_id
        );
        return $this->api_post('sob', $data);
    }

    public function get_sobs()
    {
        return $this->api_get('sob');
    }

    public function get_account_set_list()
    {
        return $this->api_get('sob/full');
    }

    public function create_account_set($name,$gids,$ranks,$levels,$members)
    {
        $data = array(
            'name' => $name,
            'dids' => $gids,
            'ranks' => $ranks,
            'levels' => $levels,
            'uids' => $members
        );
        return $this->api_post('sob', $data);
    }

    public function update_account_set($id,$name,$gids,$ranks,$levels,$members)
    {
        $data = array(
            'id' => $id,
            'name' => $name,
            'dids' => $gids,
            'ranks' => $ranks,
            'levels' => $levels,
            'uids' => $members
        );
        return $this->api_put('sob', $data);
    }

    public function delete_account_set($id)
    {
        return $this->api_delete("sob/$id");
    }

    public function insert_batch($sobs) {
        $data = array('sob' => $sobs);
        return $this->api_post("sob_load", $data);
    }

    public function update_batch($sid, $sobs) {
        $data = array('sob' => $sobs);
        return $this->api_put("sob_load/" . $sid, $data);
    }
}
?>
