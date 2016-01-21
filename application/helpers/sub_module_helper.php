<?php
    function get_sub_module($pathname)
    {
        if(!$pathname)
            return false;
        $extention = '.php';
        $path_list = explode('/',__DIR__);
        array_pop($path_list);
        array_push($path_list,'views');

        if(substr($pathname,0,1) != '/')
        {
            $pathname = '/' . $pathname;
        }

        return implode('/',$path_list) . $pathname . $extention;
    }

    function get_sub_widget($pathname,$data = array())
    {
         extract($data);
         include get_sub_module($pathname); 
    }
