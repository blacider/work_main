<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REIM_Controller extends CI_Controller{

    const WORKER = 0;
    const ADMIN = 1;
    const CASHIER = 2;
    const IT = 3;
    const GROUP_MANAGER = 4;

    public function _remap($method,$params)
    {
        $this->load->library('user_agent');
        $refer = $this->agent->referrer();
        $jwt = $this->session->userdata('jwt');
        $controller = $this->uri->rsegment_array();
        $method_set = ['login', 'install', 'pub','users', 'register' ,'resetpwd'];
        if(!in_array($controller[1],$method_set))
        {
            if(!$jwt)
            {
                redirect(base_url('/#login'));
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
            $prefixs = array('', 'login', 'register', 'join', 'install', 'errors', 'resetpwd', 'pub', 'users', 'register');
            foreach($prefixs as $prefix){
                if($this->startsWith($uri, $prefix)){
                    $flag = 0;
                }
            }

            if($flag == 1) {
                $this->session->set_userdata('last_url', $uri);
                redirect(base_url('/#login'));
                die("");
            }
            return true;
        }
        return false;
    }

    public function eload($view_name, $custom_data, $menu_page = 'menu.php'){
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


    public function  bsload($view_name, $custom_data,$template_views = array()){
        $menu_page = 'menu.bs.php'; 
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = array();
        $common = array();
        $_common = $this->user_model->get_common();
        if($_common['status'] > 0)
        {
            $common = $_common['data'];
        }
        if(array_key_exists('profile',$common))
        {
            $profile = $common['profile'];
        }
        if(!($profile || $uid)){
            // 重定向到登陆
            redirect(base_url('login'), 'refresh');
        }
        $report_template = array();

        $custom_data['company_config'] = array();
        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
//            if(array_key_exists('templates', $profile)) {
            if(array_key_exists('report_setting', $profile)) {
                if(array_key_exists('templates',$profile['report_setting']))
                $report_template = $profile['report_setting']['templates'];
            }
            $this->session->set_userdata('user', $profile);
            $custom_data['profile'] = $profile;
            $admin_groups_granted = array();
            if(array_key_exists("admin_groups_granted_all", $profile) && $profile["admin_groups_granted_all"])
            {
                $admin_groups_granted = $profile["admin_groups_granted_all"];
            }
            $custom_data['admin_groups_granted'] = $admin_groups_granted;
            if (isset($profile['group']['config'])) {
                $custom_data['company_config'] = json_decode($profile['group']['config'], TRUE);
            }
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
        foreach($template_views as $tv)
        {
            $this->load->view($tv,$custom_data);
        }
        $attacker = $this->agent->agent_string();
        // $attacker = "test start; ;JianKongBao Monitor test end";
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        $custom_data['has_attacker'] = $hasAttacker;
        $this->load->view('footer.bs.php', $custom_data);
    }


    public function aeload($view_name, $custom_data){
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

    public function render_to_download_2($filename, $data) {
        if($this->agent->is_browser('Internet Explorer')) {
            $filename = urlencode($filename);
        }
        $writer = $this->build_excel($data);
        header("Content-Type: application/vnd.ms-execl");
        header('Content-Disposition: attachment;filename=' . $filename);
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-cache");
        header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
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
            $style = $sheet_data["style"];

            $sheet->setTitle($title);
            $first_row = $rows[0];
            $j = 0;
            foreach ($first_row as $k => $v) {
                $c_name = $this->getCharByNunber($j);
                $addr = $c_name . '1';
                $sheet->getStyle($addr)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $sheet->getStyle($addr)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($addr)->getFont()->setBold(true)->setName('微软雅黑')->setSize(12);
                $sheet->setCellValue($addr, strval($k));
                $sheet->getColumnDimension($c_name)->setAutoSize(true);
                $j++;
            }

            $x = 2;
            foreach ($rows as $row) {
                $y = 0;
                foreach ($row as $k => $v) {
                    $c_name = $this->getCharByNunber($y);
                    $addr = $c_name . $x;
                    $sheet->getStyle($addr)->getFont()->setName('微软雅黑')->setSize(12);
                    // 如果未设置样式或者数据类型指定了string
                    if (empty($style[$k]) || empty($style[$k]['data_type']) || $style[$k]['data_type'] == 'string') {
                        $sheet->setCellValueExplicit($addr, strval($v), PHPExcel_Cell_DataType::TYPE_STRING);
                    } else {
                        $sheet->setCellValue($addr, $v);
                    }
                    $y++;
                }
                $x++;
            }

            $j = 0;
            foreach ($first_row as $k => $v) {
                $c_name = $this->getCharByNunber($j);
                $range = $c_name . '2:' . $c_name . (count($rows) + 1);

                $sheet->getColumnDimension($c_name)->setAutoSize(true);
                $sheet->getStyle($range)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $j++;

                if (empty($style[$k])) {
                    $sheet->getStyle($range)->getNumberFormat()->setFormatCode('#');
                    continue;
                }

                $s = $style[$k];
                if (!empty($s['data_type'])) {
                    if ($s['data_type'] == "number") {
                        $decimal_places = 2;
                        if (isset($s['decimal_places']) && is_numeric($s['decimal_places'])) {
                            $decimal_places = $s['decimal_places'];
                        }
                        if ($decimal_places > 0) {
                            $format = '0.' . str_repeat('0', $decimal_places);
                        }
                        else {
                            $format = '0';
                        }
                        $sheet->getStyle($range)->getNumberFormat()->setFormatCode($format);
                    } elseif ($s['data_type'] == "date") {
                        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
                    } elseif ($s['data_type'] == "time") {
                        $sheet->getStyle($range)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME6);
                    }
                }
            }
        }

        //
        $__excel->setActiveSheetIndex(0);

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

        $objwriter = IOFactory::createWriter($Excel, 'Excel5');
        return $objwriter;
    }


    protected static function getCharByNunber($num) {
        $num = intval($num);
        $arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        return $arr[$num];
    }

    public function do_Get($url, $extraheader = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url ) ;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $output = curl_exec($ch) ;
        if ($output === FALSE) {
            log_message('debug', curl_error($ch));
        }
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
        if($admin == self::ADMIN) return true;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }

    public function need_group_it(){
        $admin = $this->get_privilege();
        if($admin == self::ADMIN || $admin == self::IT) return true;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }

    public function need_group_agent(){
        $admin = $this->get_privilege();
        if($admin == self::ADMIN || $admin == self::IT || $admin == self::GROUP_MANAGER) return true;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }
    public function need_group_casher(){
        $admin = $this->get_privilege();
        if($admin == self::ADMIN || $admin == self::CASHIER || $admin == self::GROUP_MANAGER) return true;;
        $this->session->set_userdata("last_error", "权限不足");
        return redirect(base_url('items'), 'refresh');
    }


}
