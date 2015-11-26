<?php
class Rule_Model extends Reim_Model {

    public function update($gid, $uid, $cates, $amounts){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return false;
        $data = array(
            'gid' => $gid
            ,'uid' => $uid
            ,'cates' => $cates
            ,'amounts' => $amounts
        );
        log_message("debug", json_encode($data));
		$url = $this->get_url('rules');
		$buf = $this->do_Post($url, $data, $jwt);
        log_message("debug", $buf);
		$obj = json_decode($buf, true);
        return $obj;
    }
}
