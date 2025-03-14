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