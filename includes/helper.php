<?php

function dfa($arr, $exit = true) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}

function redirect($url, $session_key='', $session_message = []) {
    
    if ($session_key && $session_message) {
        $_SESSION[$session_key] = $session_message;
    }

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

// cut words
function cutWords($string, $length = 100, $append = '...') {
    $string = strip_tags($string);
    if (strlen($string) > $length) {
        $string = substr($string, 0, $length);
        $string = substr($string, 0, strrpos($string, ' '));
        $string .= $append;
    }
    
    return $string;
}

function show_alert_message($session_key) {
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION[$session_key])) {
        $type = $session_key ?? 'error';
        $message = $_SESSION[$session_key] ?? "An error occurred.";
        
        $classes = [
            'success' => 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded',
            'info' => 'bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded',
            'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded',
            'error' => 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded'
        ];
        
        $class = $classes[$type] ?? $classes['error'];
        
        echo "<div class='$class'>";
        echo $message;
        echo "</div>";
        unset($_SESSION[$session_key]);
    }
}

function image_src($src)
{
    $filePath = BASE_URL . $src;

    if (file_exists($filePath) && !is_dir($filePath)) {
        return url($src);
    } else {
        return url('assets/images/default.jpg');
    }
}