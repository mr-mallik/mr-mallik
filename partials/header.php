<?php
require_once __DIR__ . '/../includes/common.php'; # config file
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url('apple-touch-icon.png') ?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?= url('favicon-32x32.png') ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?= url('favicon-16x16.png') ?>" />
        <link rel="manifest" href="<?= url('site.webmanifest') ?>" />
        <link rel="mask-icon" href="<?= url('safari-pinned-tab.svg') ?>" color="#5bbad5" />
        <meta name="apple-mobile-web-app-title" content="mrmallik" />
        <meta name="application-name" content="mrmallik" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#000000" />
        <meta name="author" content="Gulger Mallik" />
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <meta name="bingbot" content="index, follow" />
        <meta name="yandex" content="index, follow" />

        <title>Gulger Mallik aka Mr. Mallik</title>
        <meta name="description" content="Gulger Mallik is a Software Engineer and a Fullstack developer.">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php url('assets/js/aos/aos.css'); ?>">
        <script src="<?php url('assets/js/aos/aos.js'); ?>"></script>
    </head>
    <body class="bg-black-base text-gray-200">
    <div id="outer-container" class="mx-auto container">
        <header class="py-8 text-center">
            <nav class="">
                <!-- <div class="fixed"> -->
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <img src="<?php url('assets/images/logo/mallik_logo.png'); ?>" alt="Mr Mallik" 
                                class="w-12 h-12 rounded-full mx-auto transition-transform duration-800 hover:rotate-[360deg] hover:cursor-pointer" 
                                onmouseout="this.style.transform='rotate(-360deg)'">
                            <a href="<?= url('') ?>" class="signature text-3xl">mr mallik</a>
                        </div>
                        <ul class="flex justify-between text-gray-400 gap-12">
                            <?php
                            $menu = siteMenu();
                            foreach ($menu as $key => $value) {
                                echo '<li><a href="' . url($key, false) . '" class="hover:text-gray-300 ' . activeUrl($key) . '" >' . $value . '</a></li>';
                            }
                            ?>
                        </ul>
                        <a href="mailto:<?= strtolower(CONTACT_EMAIL) ?>" target="_blank"
                            class="hover:cursor-pointer bg-gray-900 dark:text-white font-bold py-2 px-4 rounded-lg">
                            Let's Talk
                        </a>
                    </div>
                <!-- </div> -->
            </nav>
        </header>

        <main>
        <!-- body starts here -->
