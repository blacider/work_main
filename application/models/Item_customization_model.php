<?php

class Item_Customization_Model extends Reim_Model {

    public function get_list() {
        return $this->api_get('item_customization/list');
    }

    public function get_declarations() {
        return $this->api_get('item_customization/declare');
    }

    public function get($id) {
        $id = intval($id);
        return $this->api_get('item_customization/' . $id);
    }

    public function create($data) {
        $headers = ['Content-Type: application/json',];
        $data = json_encode($data);
        return $this->api_post('item_customization', $data, null, $headers);
    }

    public function update($id, $data) {
        $headers = ['Content-Type: application/json',];
        $data = json_encode($data);
        return $this->api_put('item_customization/update/' . $id, $data, null, $headers);
    }

    public function get_by_type($type) {
        $type = intval($type);
        return $this->api_get('item_customization/declare/' . $type);
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
        $url = sprintf('item_customization/%s/%d', $action, $id);
        return $this->api_put($url, $data);
    }

    public function delete($id) {
        $url = sprintf('item_customization/%d', $id);
        return $this->api_delete($url);
    }

    public function move($id, $to) {
        $url = sprintf('item_customization/move/%d', $id);
        $data = array(
            'to' => $to
        );
        return $this->api_put($url, $data);
    }

}
