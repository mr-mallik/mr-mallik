<?php
require_once __DIR__ . '/../../includes/admin-common.php'; # config file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
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
    <meta name="theme-color" content="#000000" />
    <title>CMS Portal</title>
</head>
<body class="bg-black-base dark:text-white min-h-full">
    <main class="mx-auto">