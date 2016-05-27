<?php

function build_url ($url, $params) {
    if (empty($params)) {
        return $url;
    }
    if (false === strpos($url, '?')) {
        $url .= '?';
    } else {
        $url .= '&';
    }
    $url .= http_build_query($params);
    return $url;
}


function array_get($array, $key, $default=null) {
    assert(is_array($array));
    if (array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default;
    }
}

