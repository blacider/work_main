<?php
	class Account_Set_Model extends Reim_Model{
		public function copy_sob($cp_name,$sob_id)
		{
			log_message('debug','$$$$$$');
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) {
			return false;
			}

			$url = $this->get_url('sob');
			$data = array(
				'act' => 'dup'
				,'name' => $cp_name
				,'tid' => $sob_id);
			$buf = $this->do_Post($url,$data,$jwt);
			log_message('debug','#####');
			log_message('debug','cp_sob_back:'.json_encode($buf));
			return $buf;
		}

		public function get_sobs()
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;

			$url = $this->get_url('sob');
			$buf = $this->do_Get($url,$jwt);
			return json_decode($buf,true);
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
		public function create_account_set($name,$gids,$ranks,$levels,$members)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			$data = array(
				'name' => $name,
				'dids' => $gids,
				'ranks' => $ranks,
				'levels' => $levels,
				'uids' => $members
			);
			$url = $this->get_url('sob');
			$buf = $this->do_Post($url,$data,$jwt);
            log_message('debug','create_account_back:' . $buf);
			$obj = json_decode($buf,true);
			return $obj;
		}
		public function update_account_set($id,$name,$gids,$ranks,$levels,$members)
		{
			$jwt = $this->session->userdata('jwt');
			if(!$jwt) return false;
			$data = array(
				'id' => $id,
				'name' => $name,
				'dids' => $gids,
				'ranks' => $ranks,
				'levels' => $levels,
				'uids' => $members
			);
			log_message('debug', 'data:' . json_encode($data));
			$url = $this->get_url('sob');
			$buf = $this->do_Put($url,$data,$jwt);
			log_message('debug' , 'account_update_back:' . $buf);
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
