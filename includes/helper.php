<?php

function dfa($arr, $exit = true) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}

function redirect($url) {
    header('Location: ' . APP_URL . $url);
    exit;
}

function url($url, $print=true) {
    if ($print) {
        echo APP_URL . '/' . $url;
    }
    else {
        return APP_URL . '/' . $url;
    }
}

function activeUrl($url) {
    $parts = explode('/', $_SERVER['REQUEST_URI']);
    
    if(APP_ENV == "local") {
        # drop key = 1 and re-index the array
        array_shift($parts);
    }

    return basename($parts[1]) == $url ? "active" : "";
}