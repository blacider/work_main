<?php

class Item_Customization_Model extends Reim_Model {
    public function get_list() {
        $url = $this->get_url('item_customization/list');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Get($url, $jwt);

        log_message('debug', 'item customization list : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }

    public function get_declarations() {
        $url = $this->get_url('item_customization/declare');
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Get($url, $jwt);

        log_message('debug', 'item customization declaration : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }

    public function get($id) {
        $id = intval($id);
        $url = $this->get_url('item_customization/' . $id);
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Get($url, $jwt);

        log_message('debug', 'item customization : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }

    public function create($data) {
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item_customization');

        array_push($jwt, 'Content-Type: application/json');
        $data = json_encode($data);
        $buf = $this->do_Post($url, $data, $jwt);
        
        log_message('debug', 'item customization create : ' . $buf);
        $data = json_decode($buf, TRUE);
        return $data;      
    }

    public function update($id, $data) {
        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('item_customization/update/' . $id);
        
        array_push($jwt, 'Content-Type: application/json');
        $data = json_encode($data);
        $buf = $this->do_Put($url, $data, $jwt);
            
        log_message('debug', 'item customization update : ' . $buf);
        $data = json_decode($buf, TRUE);
        return $data;      
    }

    public function get_by_type($type) {
        $type = intval($type);
        $url = $this->get_url('item_customization/declare/' . $type);
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Get($url, $jwt);

        log_message('debug', 'item customization declare : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;      
    }

    public function toggle($id, $enabled) {
        $action = 'active';
        if (empty($enabled)) {
            $action = 'deactive';
        }

        $url = $this->get_url(sprintf('item_customization/%s/%d', $action, $id));
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, [ ], $jwt);

        log_message('debug', 'toggle enabled : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }

    public function delete($id) {
        $url = $this->get_url(sprintf('item_customization/%d', $id));
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Delete($url, [ ], $jwt);

        log_message('debug', 'toggle enabled : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }

    public function move($id, $to) {
        
    }
}

trait TypeDeclarationTrait {
    static $TYPE_DECLARATION = [
        self::PRESET_TYPE_AMOUNT => [
            "type_name" => "金额",
            "description" => "",
            "frozen" => 1,
            "editable_title" => 0,
            "editable_enabled" => 0,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "lower_amount_only",
                    "text" => "审批人修改金额不大于原始金额",
                    "type" => "switch",
                ],
            ],
            "printable" => [],
            "editable_target" => 0,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_CURRENCY => [
            "type_name" => "货币",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "currency",
                    "text" => "外币币种及金额",
                ],
                [
                    "name" => "rate",
                    "text" => "汇率",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_CATEGORY => [
            "type_name" => "类别",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "",
                    "text" => "帐套配置",
                    "type" => "link",
                ],
            ],
            "printable" => [
                [
                    "name" => "sob",
                    "text" => "帐套",
                ],
                [
                    "name" => "category",
                    "text" => "一级类目",
                ],
                [
                    "name" => "sub_category",
                    "text" => "二级类目",
                ],
            ],
            "editable_target" => 0,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_TIME => [
            "type_name" => "时间",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "default_current_timestamp",
                    "text" => "系统默认填写提交时间",
                    "type" => "switch",
                ],
            ],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 0,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_TIMESPAN => [
            "type_name" => "时间段",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "title_start",
                    "text" => "开始时间名称",
                    "type" => "text",
                ],
                [
                    "name" => "show_calculation",
                    "text" => "显示日均金额",
                    "type" => "switch",
                ],
            ],
            "printable" => [
                [
                    "name" => "timespan",
                    "text" => "起始/结束时间",
                ],
                [
                    "name" => "calculation",
                    "text" => "日均金额",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::PRESET_TYPE_MEMBERS => [
            "type_name" => "参与人",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "show_calculation",
                    "text" => "显示人均金额",
                    "type" => "switch",
                ],
            ],
            "printable" => [
                [
                    "name" => "members",
                    "text" => "参与人",
                ],
                [
                    "name" => "members_count",
                    "text" => "人数统计",
                ],
                [
                    "name" => "amount_per_capita",
                    "text" => "人均金额",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_FEE_AFFORD => [
            "type_name" => "费用承担",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "",
                    "text" => "费用承担对象管理",
                    "type" => "link",
                ],
            ],
            "printable" => [
                [
                    "name" => "group",
                    "text" => "费用承担部门",
                ],
                [
                    "name" => "object",
                    "text" => "费用承担对象",
                ],
            ],
            "editable_target" => 0,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_MERCHANTS => [
            "type_name" => "商家",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::PRESET_TYPE_TAGS => [
            "type_name" => "标签",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [
                [
                    "name" => "",
                    "text" => "标签管理",
                    "type" => "tags",
                ],
            ],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::PRESET_TYPE_TYPE => [
            "type_name" => "类型",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [
                [
                    "name" => "",
                    "text" => "消费类型管理",
                    "type" => "link",
                ],
            ],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 0,
            "editable_required" => 0,
        ],
        self::PRESET_TYPE_REMARK => [
            "type_name" => "备注",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::PRESET_TYPE_PHOTO => [
            "type_name" => "照片",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [],
            "printable" => [],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::PRESET_TYPE_ATTACHMENT => [
            "type_name" => "附件",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 0,
            "configuration" => [],
            "printable" => [],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::TYPE_TEXT => [
            "type_name" => "备注",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::TYPE_NUMBER => [
            "type_name" => "数字",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::TYPE_SELECT => [
            "type_name" => "标签",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [
                [
                    "name" => "",
                    "text" => "标签",
                    "type" => "tags",
                ],
            ],
            "printable" => [
                [
                    "name" => "default",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
        self::TYPE_AVERAGE_AMOUNT => [
            "type_name" => "平均金额",
            "description" => "",
            "frozen" => 0,
            "editable_title" => 1,
            "editable_enabled" => 1,
            "editable_placeholder" => 1,
            "configuration" => [],
            "printable" => [
                [
                    "name" => "quantity",
                    "text" => "",
                ],
            ],
            "editable_target" => 1,
            "editable_required" => 1,
        ],
    ];
}