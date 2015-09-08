<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
 * work with bootstrap 2.3.2 pagination
 *
 */

class Pager {

    private $_total;
    private $_pn;
    private $_rn;
    private $_base_url;
    private $_plength;

    public function __construct(){
        $this->_total = 0;
        $this->_pn = 1;
        $this->_rn = 10;
        $this->_plength = 10;
        $this->_base_url = '';
    }

    public function initialize($config){
        foreach($config as $key => $value){
            $_key = '_' . $key;
            $this->$_key = $value;
        }
    }

    public function create_links(){
        $total_rows = $this->_total;
        $base_url = $this->_base_url;
        $current_page_id = $this->_pn;
        $page_size = $this->_rn;
        $page_step = $this->_plength;

        $total_pages = ceil($total_rows/$page_size);
        $start = ($current_page_id >= $page_step) ? ($current_page_id - ceil($page_step/2) + 1) : 1;
        //$start = (($end - $page_step + 1) > 0) ? ($end - $page_step + 1) : 1;
        $end = min(($start + $page_step - 1), $total_pages);
        //$start = max($start, ($end - $page_step +1));
        $start = (($end - $page_step + 1) > 0) ? ($end - $page_step + 1) : 1;


        if(strpos($base_url, '?') > 0){
            $base_url = $base_url . '&';
        }
        else{
            $base_url = $base_url . '?';
        }

        $first_url = $base_url . 'pn=1&rn=' . $page_size;
        $last_url = $base_url . 'pn=' . $total_pages . '&rn=' . $page_size;
        $prev_idx = $current_page_id < 1 ? 1 : $current_page_id - 1;
        $next_idx = $current_page_id >= $total_pages ? $total_pages : $current_page_id + 1;
        $prev_url = $base_url . 'pn=' . $prev_idx .  '&rn=' . $page_size;
        $next_url = $base_url . 'pn=' . $next_idx .  '&rn=' . $page_size;


#$html = '<div class="pagination pagination-small pagination-left"><ul>';
#$html .= '<li><a href = "' . $first_url . '">&laquo;</a></li>';
        $html = '<a class="pagination pagination-small pagination-left" href="' . $prev_url . '">上一页</a>';
        for ($p = $start; $p <= $end; $p++){
            $url = $base_url . 'pn=' . $p . '&rn=' . $page_size;
            $html .= '<a href="' . $url . '">' . $p . '</a></li>';
        }
        $html .= '<a href="' . $next_url . '">下一页</a>';
        //$html .= '</ul></div>';
        return $html;
    }

}
