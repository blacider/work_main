<?php

class Mobile extends Reim_Controller
{
    public function get($action)
    {
        if ($action == 'weixin_wallet') {
            return $this->weixin_wallet();
        }
        return show_404();
    }

    public function weixin_wallet()
    {
        $this->load->config('api');
        $api_url_base = $this->config->item('api_url_base');
        $client_id = $this->config->item('api_client_id');
        $client_secret = $this->config->item('api_client_secret');

        $this->load->view('mobile/wallet', array(
            'api_url_base' => $api_url_base,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ));
    }
}
