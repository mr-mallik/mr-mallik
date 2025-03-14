<?php
require_once __DIR__ . '/../includes/common.php'; # config file
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
        <title></title>
    </head>
    <body class="bg-gray-900 text-gray-200">
    <div id="outer-container" class="mx-auto container">
        <header>
            <nav class="p-8 text-center">
                <div class="flex justify-between items-center">
                    <h1>Logo</h1>
                    <ul class="flex justify-between text-gray-500 gap-12">
                        <?php
                        $menu = siteMenu();
                        foreach ($menu as $key => $value) {
                            echo '<li><a href="' . url($key, false) . '" class="hover:text-gray-300 ' . activeUrl($key) . '" >' . $value . '</a></li>';
                        }
                        ?>
                    </ul>
                    <a href="https://wa.me/447767924720"
                        class="hover:cursor-pointer bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Let's Talk
                    </a>
                </div>
            </nav>
        </header>

        <main>
        <!-- body starts here -->
