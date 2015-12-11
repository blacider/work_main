<?php
    function get_html_container($content,$html_id='reim_html_id',$is_hidden=true)
    {
        $is_hidden_string = 'hidden';
        if(!$is_hidden)
        {
            $is_hidden_string = '';
        }
        
        if(!is_string($content)) 
        {
            $content = json_encode($content);
        }
        return "<div " . $is_hidden_string ." id='" . htmlspecialchars($html_id) . "' data-value= '" . htmlspecialchars($content) . "' >" . htmlspecialchars($content) . "</div>";
    }

