<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Broadcast_Model extends Reim_Model {

    public function send($id)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array();

		$url = $this->get_url('notice/' . $id . '/send');
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "broadcast_send_url:" . $url);
        log_message("debug", "broadcast_send_data:" . json_encode($data));
        log_message("debug", "broadcast_send_back:" . $buf);
        $_buf = json_decode($buf,True);
        return $_buf;
    }

    public function create($uid, $title, $content,  $users, $groups, $ranks, $levels , $all) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'uid' => $uid
            ,'title' => $title 
            ,'content' => $content
            ,'users' => $users
            ,'groups' => $groups
            ,'ranks' => $ranks
            ,'levels' => $levels
            ,'all' => $all
        );

		$url = $this->get_url('notice');
        $buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", "broadcast_create_url:" . $url);
        log_message("debug", "broadcast_create_data:" . json_encode($data));
        log_message("debug", "broadcast_create_back:" . $buf);
        $_buf = json_decode($buf,True);
        return $_buf;

    }

    public function get_info($id = 0)
    {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;

        if($id == 0)
		    $url = $this->get_url('notice/list');
        else
		    $url = $this->get_url('notice/' . $id);
            
        $buf = $this->do_Get($url,$jwt);
        log_message("debug", "broadcast_get_url:" . $url);
        log_message("debug", "broadcast_get_back:" . $buf);
        $_buf = json_decode($buf,True);
        return $_buf;

    }

    public function update($id ,$uid, $title, $content,  $users, $groups, $ranks, $levels , $all) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'uid' => $uid
            ,'title' => $title 
            ,'content' => $content
            ,'users' => $users
            ,'groups' => $groups
            ,'ranks' => $ranks
            ,'levels' => $levels
            ,'all' => $all
        );

		$url = $this->get_url('notice/' . $id);
        $buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", "broadcast_update_url:" . $url);
        log_message("debug", "broadcast_update_data:" . json_encode($data));
        log_message("debug", "broadcast_update_back:" . $buf);
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
        log_message("debug", "broadcast_delete_back:" . $buf);
        $_buf = json_decode($buf,True);
        return $_buf;
    }

}
