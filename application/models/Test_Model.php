<?php
	class Test_Model extends Reim_Model{
		public function get($pre,$id)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;

			$url = $this->get_url($pre."/".$id);
			$buf = $this->do_Get($url,$jwt);
			return $buf;
		}
	}
?>
