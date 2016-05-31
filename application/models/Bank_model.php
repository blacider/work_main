<?php

class Bank_Model extends Reim_Model{
    public function get_banks($checksum=0) {

        return $this->api_get('banks/'.$checksum);
    }
}

