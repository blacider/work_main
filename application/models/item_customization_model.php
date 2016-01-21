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

        // PUT 空数据会出错，所以随便构造一点数据
        $data = array(
            'key' => 'value'
        );
        $url = $this->get_url(sprintf('item_customization/%s/%d', $action, $id));
        $jwt = $this->session->userdata('jwt');
        $buf = $this->do_Put($url, $data, $jwt);

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
        $url = $this->get_url(sprintf('item_customization/move/%d', $id));
        $jwt = $this->session->userdata('jwt');

        $data = array(
            'to' => $to
        );
        $buf = $this->do_Put($url, $data, $jwt);

        log_message('debug', 'move : ' . $buf);
        $data = json_decode($buf, TRUE);

        return $data;
    }
}