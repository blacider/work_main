<?php

class Images extends Reim_Controller {
    public function index($id, $type = 0){
        $this->load->model("user_model", "users");
        $info = $this->users->reim_get_hg_avatar($id);
        die($info);

    }
}
