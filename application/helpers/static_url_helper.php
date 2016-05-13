<?php

function static_url ($path) {
    // TODO CDN url
    if (substr($path, 0, 1) !== '/') {
        $path = '/' . $path;
    }
    $file_path = BASEDIR . $path;
    $file_mtime = filemtime($file_path);
    if (false === strpos($path, '?')) {
        $path = $path . '?';
    }
    $path = $path . '_m=' . intval($file_mtime);
    return $path;
}

