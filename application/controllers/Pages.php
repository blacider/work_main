<?php
	class Pages extends CI_Controller{


		public function index() {
			die("Good day");
		}

		public function view($page){
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php'))
			{
			// 页面不存在
				echo "hello";
			show_404();
			}
			echo APPPATH.'views/pages/'.$page.'.php';
			$data['title'] = ucfirst($page); // 将title中的第一个字符大写
			echo "{$data['title']}";
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
				}
	}