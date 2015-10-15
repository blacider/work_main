<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Broadcast_Model extends Reim_Model {

    public function create($uid, $title, $content, $type, $users, $groups, $ranks, $levels) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'uid' => $id
            ,'title' => $title 
            ,'content' => $content
            ,'type' => $type
            ,'users' => $users
            ,'groups' => $groups
            ,'ranks' => $ranks
            ,'levels' => $levels
        );

		$url = $this->get_url('notice');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "broadcast_create_url:" . $url);
        log_message("debug", "broadcast_create_data:" . json_encode($data));
        log_message("debug", "broadcast_create_back:" . json_encode($buf));
        $_buf = json_decode($buf,True);
        return $_buf;

    }

    public function get_info()
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

		$url = $this->get_url('notice/list');
        $buf = $this->do_Get($url,$jwt);
        log_message("debug", "broadcast_get_url:" . $url);
        log_message("debug", "broadcast_get_back:" . json_encode($buf));
        $_buf = json_decode($buf,True);
        return $_buf;

    }

    public function update($id)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'title' => $title 
            ,'content' => $content
            ,'type' => $type
            ,'groups' => $groups
        );

		$url = $this->get_url('notice/' . $id);
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "broadcast_update_url:" . $url);
        log_message("debug", "broadcast_update_data:" . json_encode($data));
        log_message("debug", "broadcast_update_back:" . json_encode($buf));
        $_buf = json_decode($buf,True);
        return $_buf;
    }

    public function delete($id)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

		$url = $this->get_url('notice/' . $id);
        $buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", "broadcast_delete_url:" . $url);
        log_message("debug", "broadcast_delete_back:" . json_encode($buf));
        $_buf = json_decode($buf,True);
        return $_buf;
    }

}
