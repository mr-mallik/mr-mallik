<?php
require_once __DIR__ . '/../../includes/admin-common.php'; # config file
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url('apple-touch-icon.png') ?>" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= url('favicon-32x32.png') ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= url('favicon-16x16.png') ?>" />
    <link rel="manifest" href="<?= url('site.webmanifest') ?>" />
    <link rel="mask-icon" href="<?= url('safari-pinned-tab.svg') ?>" color="#5bbad5" />
    
    <!-- App Configuration -->
    <meta name="apple-mobile-web-app-title" content="mrmallik" />
    <meta name="application-name" content="mrmallik" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#1f2937" />
    <title>CMS Portal</title>
    <style>
        * { font-family: 'Roboto', sans-serif; }
        .material-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .material-card:hover { transform: translateY(-2px); box-shadow: 0 12px 20px -10px rgba(0, 0, 0, 0.3); }
        .ripple { position: relative; overflow: hidden; }
        .ripple:after { content: ""; display: block; position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none; background-image: radial-gradient(circle, #fff 10%, transparent 10.01%); background-repeat: no-repeat; background-position: 50%; transform: scale(10, 10); opacity: 0; transition: transform .5s, opacity 1s; }
        .ripple:active:after { transform: scale(0, 0); opacity: .3; transition: 0s; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 dark:text-white min-h-full">
    <main class="mx-auto">