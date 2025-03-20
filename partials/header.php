<?php
require_once __DIR__ . '/../includes/common.php'; # config file
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php url('assets/js/aos/aos.css'); ?>">
        <script src="<?php url('assets/js/aos/aos.js'); ?>"></script>
        <title></title>
    </head>
    <body class="bg-black-base text-gray-200">
    <div id="outer-container" class="mx-auto container max-w-5xl">
        <header class="p-8 text-center">
            <nav class="">
                <!-- <div class="fixed"> -->
                    <div class="flex justify-between items-center">
                        <h1>Logo</h1>
                        <ul class="flex justify-between text-gray-400 gap-12">
                            <?php
                            $menu = siteMenu();
                            foreach ($menu as $key => $value) {
                                echo '<li><a href="' . url($key, false) . '" class="hover:text-gray-300 ' . activeUrl($key) . '" >' . $value . '</a></li>';
                            }
                            ?>
                        </ul>
                        <a href="mailto:gulgermallik@gmail.com" target="_blank"
                            class="hover:cursor-pointer bg-gray-900 text-white font-bold py-2 px-4 rounded-lg">
                            Let's Talk
                        </a>
                    </div>
                <!-- </div> -->
            </nav>
        </header>

        <main>
        <!-- body starts here -->
