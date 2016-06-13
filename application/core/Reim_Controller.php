<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REIM_Controller extends CI_Controller{

    const WORKER = 0;
    const ADMIN = 1;
    const CASHIER = 2;
    const IT = 3;
    const GROUP_MANAGER = 4;

    public function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->model('user_model');
    }

    public function _remap($method,$params)
    {
        if (!$this->session->userdata('oauth2_ak')) {
            $controller = $this->uri->rsegment_array();
            $white_list = ['', 'login', 'install', 'pub', 'users', 'register', 'mobile'];
            if(!in_array($controller[1], $white_list)) {
                redirect(base_url('/#login'));
            }
        }
        try {
            call_user_func_array(array($this, $method), $params);
        }
        catch (RequireLoginError $e) {
            redirect(base_url('/#login'));
        }
    }

    public function bsload($view_name, $custom_data, $template_views=array()){
        $this->user_model->refresh_session();
        $profile = $this->session->userdata('profile');
        $company_pay_data = $this->session->userdata('company');
        $uid = $this->session->userdata('uid');
        assert($profile and $uid);
        $report_template = array();
        $custom_data['company_config'] = array();
        if(array_key_exists('report_setting', $profile)) {
            if(array_key_exists('templates',$profile['report_setting']))
            $report_template = $profile['report_setting']['templates'];
        }
        if(!array_key_exists('profile', $custom_data)){
            $custom_data['profile'] = $profile;
        }
        $admin_groups_granted = array();
        if(array_key_exists("admin_groups_granted_all", $profile) && $profile["admin_groups_granted_all"])
        {
            $admin_groups_granted = $profile["admin_groups_granted_all"];
        }
        $custom_data['admin_groups_granted'] = $admin_groups_granted;
        if (isset($profile['group']['config'])) {
            $custom_data['company_config'] = json_decode($profile['group']['config'], TRUE);
        }
        $custom_data['company_pay_data'] = $company_pay_data;
        $custom_data['groupname'] = $this->session->userdata('groupname');
        $custom_data['report_templates'] = $report_template;

        $custom_data['user_access_token'] = $this->session->userdata('oauth2_ak');
        $custom_data['userId'] = $uid;

        $custom_data['base_url'] = base_url();

        $api_url_base = $this->config->item('api_url_base');
        $custom_data['api_url_base'] = $api_url_base;

        // ie check
        $browser_not_supported = false;
        if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() < 8) {
            $browser_not_supported = true;
        }
        $custom_data['browser_not_supported'] = $browser_not_supported;

        $lte_ie8 = false;
        if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() <=8) {
            $lte_ie8 = true;
        }
        $custom_data['lte_ie8'] = $lte_ie8;

        $this->load->view('header.bs.php', $custom_data);
        $this->load->view('menu.bs.php', $custom_data);
        $this->load->view($view_name, $custom_data);
        foreach($template_views as $tv)
        {
            $this->load->view($tv,$custom_data);
        }

        $agent = $this->agent->agent_string();
        $hasAttacker = false;
        if(stripos($agent, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        $custom_data['has_attacker'] = $hasAttacker;

        $this->load->view('footer.bs.php', $custom_data);
    }

    public function render_to_download_2($filename, $data) {
        $writer = $this->build_excel($data);
        return $this->output_excel($filename, $writer);
    }

    public function render_to_download($title, $data, $excel_name, $title_2 = '', $data_2 = array(), $title_3 = '', $data_3 = array()){
        $writer = $this->return_buf($title, $data, $title_2, $data_2, $title_3, $data_3);
        return $this->output_excel($excel_name, $writer);
    }

    protected function encode_filename_hdval($filename) {
        $filename = rawurlencode($filename);
        $this->load->library('user_agent');
        if ($this->agent->browser() == 'Internet Explorer' and
            $this->agent->version() <= 8
        ) {
            return sprintf('attachment;filename=%s;charset=utf8', $filename);
        } else {
            return sprintf("attachment;filename*=UTF-8''%s", $filename);
        }
    }

    protected function output_excel ($filename, $writer) {
        $fn_hdval = $this->encode_filename_hdval($filename);
        header("Content-Type: application/vnd.ms-execl");
        header("Content-Disposition: $fn_hdval");
        header("Cache-Control: no-cache");
        $writer->save("php://output");
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

        $objwriter = PHPExcel_IOFactory::createWriter($__excel, 'Excel5');
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

        $objwriter = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');
        return $objwriter;
    }

    private function getCharByNunber($num) {
        return PHPExcel_Cell::stringFromColumnIndex($num);
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
