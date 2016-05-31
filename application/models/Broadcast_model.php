<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Broadcast_Model extends Reim_Model {

    public function send($id)
    {
        $data = array();
        return $this->api_put('notice/' . $id . '/send', $data);
    }

    public function create($uid, $title, $content,  $users, $groups, $ranks, $levels , $all) {
        $data = array(
            'uid' => $uid,
            'title' => $title,
            'content' => $content,
            'users' => $users,
            'groups' => $groups,
            'ranks' => $ranks,
            'levels' => $levels,
            'all' => $all
        );
        return $this->api_post('notice', $data);
    }

    public function get_info($id = 0)
    {
        if($id == 0) {
            $url = 'notice/list';
        } else {
            $url = 'notice/' . $id;
        }
        return $this->api_get($url);
    }

    public function update($id ,$uid, $title, $content,  $users, $groups, $ranks, $levels , $all) {
        $data = array(
            'uid' => $uid,
            'title' => $title,
            'content' => $content,
            'users' => $users,
            'groups' => $groups,
            'ranks' => $ranks,
            'levels' => $levels,
            'all' => $all
        );
        return $this->api_put('notice/' . $id, $data);
    }

    public function delete($id)
    {
        return $this->api_delete('notice/' . $id);
    }

}
