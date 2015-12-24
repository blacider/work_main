<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Customization extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('item_customization_model');
    }

    public function toggle($id) {
        $id = intval($id);
        if (empty($id)) {
            show_404();
            return NULL;
        }

        $enabled = $this->input->post('enabled');
        log_message('debug', 'toggle ' . $id . ' to ' . ( $enabled ? 'enabled' : 'disabled' ));
        $ret = $this->item_customization_model->toggle($id, $enabled);
        
        header('Content-Type: application/json');
        echo json_encode($ret);
    }

    public function save() {
        log_message('debug', 'field data: ' . json_encode($_POST));
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $field_result = $this->item_customization_model->get_by_type($type);
        if (empty($field_result['status'])) {
            echo "<script>alert('验证数据失败！');window.location.href='javascript:history.back(-1);'</script>";
            return;
        }

        $fd = $field_result['data']['declaration'];
        log_message('debug', 'declaration: ' . json_encode($fd));
        $data = array(
            'type' => $type
        );

        // 匹配字段配置
        if ($fd['editable_title']) {
            $data['title'] = $this->input->post('title');
        }
        if ($fd['editable_placeholder']) {
            $data['description'] = $this->input->post('description');
        }
        if ($fd['editable_target']) {
            $target = $this->input->post('target');
            $data['target'] = json_decode($target, TRUE);
        }
        if ($fd['editable_required']) {
            $required = $this->input->post('required');
            $data['required'] = json_decode($required, TRUE);
        }
        $data['extra'] = array();
        $extra = $this->input->post('extra');
        foreach ($fd['configuration'] as $fc) {
            if ($fc['name'] && isset($extra[$fc['name']])) {
                $data['extra'][$fc['name']] = $extra[$fc['name']];
            }
        }

        $data['printable'] = array();
        $printable = $this->input->post('printable');
        log_message('debug', 'printabled data: ' . json_encode($printable));
        foreach ($fd['printable'] as $fp) {
            if ($fp['name'] && isset($printable[$fp['name']])) {
                $data['printable'][$fp['name']] = $printable[$fp['name']];
            }
        }
        log_message('debug', 'data: ' .json_encode($data));


        if ($id) {
            $data = $this->item_customization_model->update($id, $data);
        } else {
            $data = $this->item_customization_model->create($data);
        }

        if ($data['status']) {
            redirect('/company/item_customization');
        } else {
            $this->session->set_userdata('last_error', $data['data']['msg']);
            echo "<script>alert('验证数据失败！');window.location.href='javascript:history.back(-1);'</script>";
            return;
        }
    }

    public function delete($id) {
        $id = intval($id);
        if (empty($id)) {
            show_404();
            return NULL;
        }

        log_message('debug', 'delete ' . $id);
        $ret = $this->item_customization_model->delete($id);
        
        header('Content-Type: application/json');
        echo json_encode($ret);
    }
}
