<?php
	class Account_Set_Model extends Reim_Model{
		public function get_sobs()
		{
			$jwt = $this->session->userdata('jwt');
			if($jwt) return false;

			$url = $this->get_url('common');
			$buf = $this->do_Get($url,$jwt);
			log_message('debug','######'.json($buf));
			return $buf;
		}
		public function get_account_set_list()
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			$url = $this->get_url('sob/full');
			$buf=$this->do_Get($url,$jwt);
			$obj = json_decode($buf,true);
			log_message("debug","###########ACOUNT_SETS****:$buf");
			return $obj;
		}
		public function create_account_set($name,$gids)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			$data = array(
				'name' => $name,
				'dids' => $gids
			);
			$url = $this->get_url('sob');
			$buf = $this->do_Post($url,$data,$jwt);
			$obj = json_decode($buf,true);
			return $obj;
		}
		public function update_account_set($id,$name,$gids)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			$data = array(
				'id' => $id,
				'name' => $name,
				'dids' => $gids
			);
			$url = $this->get_url('sob');
			$buf = $this->do_Put($url,$data,$jwt);
			$obj = json_decode($buf,true);
			return $obj;	
		}
		public function delete_account_set($id)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			
			$data = array();
			$url = $this->get_url("sob/$id");
			log_message("debug","####$url");
			$buf = $this->do_Delete($url,$data,$jwt);
			return $buf;
		}
	}
?>
