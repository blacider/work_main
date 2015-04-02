<?php
class Category_Model extends Reim_Model {

    public function get_list(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
		$url = $this->get_url('common/0');
		$buf = $this->do_Get($url, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function create($name, $pid, $prove_ahead = 0, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
        );
		$url = $this->get_url('category');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
    public function update($cid, $name, $pid, $prove_ahead = 0, $maxlimit = 0) {
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'name' => $name
            ,'pid' => $pid
            ,'limit' => $maxlimit
            ,'pb' => $prove_ahead
        );
		$url = $this->get_url('category/' . $cid);
		$buf = $this->do_Put($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

    public function remove($cid){
        $jwt = $this->session->userdata('jwt');
        log_message("debug", "JWT: " . $jwt);
        if(!$jwt) return false;
		$url = $this->get_url('category/' . $cid);
		$buf = $this->do_Delete($url, array(), $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }

}
