<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REIM_Controller extends CI_Controller{
    public function _remap($method,$params)
    {
        $this->load->library('user_agent');
        $refer = $this->agent->referrer();
        $jwt = $this->session->userdata('jwt');
        $controller = $this->uri->rsegment_array();
        $method_set = ['login','install', 'pub','users', 'register' ,'resetpwd'];
        if(!in_array($controller[1],$method_set))
        {
            if(!$jwt) 
            {
                redirect(base_url('login'));
            }
        }
        $uri=$this->uri;
        call_user_func_array(array($this,$method),$params);
    }

    public function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    public function __construct(){
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->library('user_agent');
        $refer = $this->agent->referrer();
        //log_message("debug", "construct:" . $refer);
        $this->load->library('PHPExcel/IOFactory');
        $uri = $this->uri->uri_string();
        if($this->session->userdata('jwt') == "" && $this->session->userdata('uid') == ""){
            $flag = 1;
            $prefixs = array('login', 'register', 'join', 'install', 'errors', 'resetpwd', 'pub', 'users', 'register');
            foreach($prefixs as $prefix){
                if($this->startsWith($uri, $prefix)){
                    $flag = 0;
                }
            }

            if($flag == 1) {
                $this->session->set_userdata('last_url', $uri);
                redirect(base_url('login'));
                die("");
            }
            return true;
        }
        return false;
    }

    public function  eload($view_name, $custom_data, $menu_page = 'menu.php'){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            // 重定向到登陆
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            $this->session->set_userdata('user', $profile);
            $custom_data['profile'] = $profile;
        }

        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $custom_data['base_url'] = base_url();
        $this->load->view('header', $custom_data);
        $this->load->view($menu_page, $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer', $custom_data);
    }

    public function jsalert($msg, $target = ''){
        if($target){
            die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">alert("' . $msg . '"); location.href="' . $target . '";</script>');
        }else {
            die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">alert("' . $msg . '"); history.go(-1);</script>');
        }

    }

    public function _pager($url, $total, $pn, $rn){
        $this->load->library('pager');
        $config['base_url'] = base_url($url);
        $config['total'] = $total;
        $config['rn'] = $rn;
        $config['pn'] = $pn;
        $this->pager->initialize($config);
        return $this->pager->create_links();
    }

    public function _upload($uid, $name){
        if($name == "") $name = 'package';
        $this->load->helper('file');
        $user_prefix = md5($uid);
        $s = substr($user_prefix, 0, 2) . "/" . substr($user_prefix, 2, 2);
        $prefix = 'statics/' . 'users_data/' . $s . "/" . $uid . "/" . date('Y/m');
        $config['upload_path'] = $this->config->item('static_base') . $prefix;
        $relate_file = $config['upload_path'];
        if(!file_exists($config['upload_path'])){
            //echo $config['upload_path'];
            $mkres = mkdir($config['upload_path'], 0777, true);
            if(!$mkres){
                log_message("debug", "mkdir error: " . $config['upload_path']);
                return array('status' => false, 'msg' => '创建目录失败');
            }
        }
        $config['allowed_types'] = '*';
        $config['max_size'] = '50000000';
        $config['encrypt_name'] = True;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload($name))
        {
            return array('status' => false, 'msg' => '图片上传失败', 'detail' => $this->upload->display_errors());
        } 
        else
        {
            return array('status' => true, 'data' => $this->upload->data(), 'prefix' => $prefix);
        }
    }


    public function  bsload($view_name, $custom_data, $menu_page = 'menu.bs.php'){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            // 重定向到登陆
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }
        $report_template = array();

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            if(array_key_exists('templates', $profile)) {
                $report_template = $profile['templates'];
            }
            $this->session->set_userdata('user', $profile);
            $custom_data['profile'] = $profile;
        }

        $custom_data['groupname'] = $this->session->userdata('groupname');
        $custom_data['report_templates'] = $report_template;
        log_message("debug", "Get From Cache =====================");
        log_message("debug", $custom_data['groupname']);
        log_message("debug", "Get From Cache =====================");
        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $custom_data['base_url'] = base_url();
        $this->load->view('header.bs.php', $custom_data);
        $this->load->view($menu_page, $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer.bs.php', $custom_data);
    }


    public function  aeload($view_name, $custom_data){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['menu'] = $this->user_model->get_menu($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            $this->session->set_userdata('user', $profile);
            $custom_data['menu'] = $this->user_model->get_menu(0, 1);
            $custom_data['profile'] = $profile;
        }

        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $this->load->view('header.old.php', $custom_data);
        $this->load->view('menu.old.php', $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer.old.php', $custom_data);
    }

    public function show_error($msg){
    }

    public function save_to_local($title, $data, $excle_name) {
        $exclefile = $excle_name;
        $objwriter = $this->return_buf($title, $data);
        $objwriter->save($exclefile);
        return $exclefile;

    }

    public function render_to_download_2($filename, $data) {
        if($this->agent->is_browser('Internet Explorer')) {
            $excle_name = urlencode($filename);
        }

        $writer = $this->build_excel($data);

        header("Pragma: public");
        header("Content-Type: application/vnd.ms-execl");
        header('Content-Disposition: attachment;filename=' . $filename);
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
        header("Pragma: no-cache");
        $writer->save("php://output");

        exit();
    }

    public function render_to_download($title, $data, $excel_name, $title_2 = '', $data_2 = array(), $title_3 = '', $data_3 = array()){
        if($this->agent->is_browser('Internet Explorer')) {
            $excle_name = urlencode($excle_name);
        }
        $objwriter = $this->return_buf($title, $data, $title_2, $data_2, $title_3, $data_3);
        header("Pragma: public");
        header("Content-Type: application/vnd.ms-execl");
        header('Content-Disposition: attachment;filename=' . $excel_name);
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
        header("Pragma: no-cache");
        $objwriter->save("php://output");
        exit();
    }

    public function build_excel($data)
    {
        $__excel = new PHPExcel();
        $__excel->getProperties()
            ->setCreator("RushuCloud Ltd.co")
            ->setLastModifiedBy("RushuCloud.Ltd.co");

        while ($__excel->getSheetCount() < count($data)) {
            $__excel->createSheet();
        }

        foreach ($data as $index => $sheet_data) {
            $sheet = $__excel->setActiveSheetIndex($index);

            log_message("debug", "create sheet with " . json_encode($sheet_data));

            $title = $sheet_data["title"];
            $rows = $sheet_data["data"];

            // TODO: 自动宽度应该在设置值之后
            $sheet->setTitle($title);
            $first_row = $rows[0];
            $j = 0;
            foreach ($first_row as $k => $v) {
                $c_name = $this->getCharByNunber($j);
                $sheet->getStyle($c_name)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $sheet->setCellValue($c_name . '1', ' ' . strval($k));
                $sheet->getColumnDimension($c_name)->setAutoSize(true);
                $j++;
            }

            $x = 2;
            foreach ($rows as $row) {
                $y = 0;
                foreach ($row as $k => $v) {
                    $c_name = $this->getCharByNunber($y);
                    $sheet->getStyle($c_name)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $sheet->setCellValue($this->getCharByNunber($y) . $x, ' ' . strval($v));
                    $y++;
                }
                $x++;
            }

            $j = 0;
            foreach ($first_row as $k => $v) {
                $c_name = $this->getCharByNunber($y);
                $sheet->getColumnDimension($c_name)->setAutoSize(true);
            }
        }

        $objwriter = IOFactory::createWriter($__excel, 'Excel5');
        return  $objwriter;
    }

    public function return_buf($title, $data, $title_2 = '', $data_2 = array(), $title_3 = '', $data_3 = array()) {

        $Excel = new PHPExcel();
        $Excel->getProperties()->setCreator("RushuCloud Ltd.co")
            ->setLastModifiedBy("RushuCloud.Ltd.co")
            ->setTitle($title)
            ->setSubject($title);

        $Excel->setActiveSheetIndex(0);
        $Excel->getSheet()->setTitle($title);

        $cell_one = $data[0];
        $j = 0;
        foreach ($cell_one as $k => $v) {
            $c_name = $this->getCharByNunber($j);
            $Excel->getActiveSheet() -> getStyle($c_name) ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $Excel->getSheet()->getColumnDimension($c_name)->setAutoSize(true);
            $Excel->getSheet()->setCellValue($c_name . '1', ' '. strval($k));
            $j++;
        }

        $x = 2;
        foreach ($data as $value) {
            $y = 0;
            foreach ($value as $k => $v) {
                $c_name = $this->getCharByNunber($y);
                $Excel->getActiveSheet() -> getStyle($c_name) ->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $Excel->getSheet()->getColumnDimension($c_name)->setAutoSize(true);
                $Excel->getSheet()->setCellValue($this->getCharByNunber($y) . $x, ' ' . strval($v));
                $y++;
            }
            $x++;
        }



        // TODO: 如此肮脏，算了，先推下来再说吧。
        if($title_2 && count($data_2) > 0){
            $Excel->createSheet();
            $Excel->setActiveSheetIndex(1);
            $Excel->getSheet(1)->setTitle($title_2);

            $cell_one = $data_2[0];
            $j = 0;
            foreach ($cell_one as $k => $v) {
                $Excel->getSheet(1)->setCellValue($this->getCharByNunber($j) . '1', ' ' . $k);
                $j++;
            }

            $x = 2;
            foreach ($data_2 as $value) {
                $y = 0;
                foreach ($value as $k => $v) {
                    $Excel->getSheet(1)->setCellValue($this->getCharByNunber($y) . $x, ' ' . $v);
                    $y++;
                }
                $x++;
            }
        }
        // TODO: 如此肮脏，算了，先推下来再说吧。
        if($title_3){
            $Excel->createSheet();
            $Excel->setActiveSheetIndex(2);
            $Excel->getSheet(2)->setTitle($title_3);

            if(count($data_3) > 0) {
                $cell_one = $data_3[0];
                $j = 0;
                foreach ($cell_one as $k => $v) {
                    $Excel->getSheet(2)->setCellValue($this->getCharByNunber($j) . '1', ' ' . $k);
                    $j++;
                }

                $x = 2;
                foreach ($data_3 as $value) {
                    $y = 0;
                    foreach ($value as $k => $v) {
                        $Excel->getSheet(2)->setCellValue($this->getCharByNunber($y) . $x, ' ' . $v);
                        $y++;
                    }
                    $x++;
                }
            }
        }


        //$objwriter = new PHPExcel_Writer_Excel2007($Excel);
        $objwriter = IOFactory::createWriter($Excel, 'Excel5');
        //$objwriter = IOFactory::createWriter($Excel, 'Excel2007');
        return $objwriter;
    }


    protected static function getCharByNunber($num) {
        $num = intval($num);
        $arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        return $arr[$num];
    }

    public function do_Get($url, $extraheader = array()){
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        log_message("debug", "Start Request");
        $output = curl_exec($ch) ;
        log_message("debug", "Get Success:" . $output);
        curl_close($ch);
        return $output;
    }

    private function get_privilege(){
        $profile = $this->session->userdata('profile');
        if(!($profile)){
            log_message("debug","Nothing ");
            return redirect(base_url('login'), 'refresh');
        }
        return $profile['admin'];

    }

    public function need_group_admin(){
        $admin = $this->get_privilege();
        if($admin == 1) return true;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }

    public function need_group_it(){
        $admin = $this->get_privilege();
        if($admin == 1 || $admin == 3) return true;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }

    public function need_group_casher(){
        $admin = $this->get_privilege();
        if($admin == 1 || $admin == 2) return true;;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }


    public function stringFromColumnIndex($pColumnIndex = 0) 
    { 
        static $_indexCache = array(); 

        if (!isset($_indexCache[$pColumnIndex])) { 
            // Determine column string 
            if ($pColumnIndex < 26) { 
                $_indexCache[$pColumnIndex] = chr(65 + $pColumnIndex); 
            } elseif ($pColumnIndex < 702) { 
                $_indexCache[$pColumnIndex] = chr(64 + ($pColumnIndex / 26)) . 
                    chr(65 + $pColumnIndex % 26); 
            } else { 
                $_indexCache[$pColumnIndex] = chr(64 + (($pColumnIndex - 26) / 676)) . 
                    chr(65 + ((($pColumnIndex - 26) % 676) / 26)) . 
                    chr(65 + $pColumnIndex % 26); 
            } 
        } 
        return $_indexCache[$pColumnIndex]; 
    }

}
