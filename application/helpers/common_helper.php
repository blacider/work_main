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

