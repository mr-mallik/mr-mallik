<?php
require_once __DIR__ . "/../partials/finance/header.php";
?>

<div class="bg-black-base flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 space-y-6 card-bg-radial rounded shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-300">Login</h2>
        <form class="space-y-4" action="auth.php" method="POST">
            <?= show_alert_message('error'); ?>
            <?= show_alert_message('success'); ?>
            <?= show_alert_message('info'); ?>
            <?= show_alert_message('warning'); ?>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-500">Username</label>
                <input type="text" name="username" id="username" required
                    class="w-full px-3 py-2 dark:text-white mt-1 border rounded-md shadow-sm border-gray-300">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-500">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3 py-2 dark:text-white mt-1 border rounded-md shadow-sm border-gray-300">
            </div>
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-gray-700 rounded-md">
                    Login
                </button>
            </div>
        </form>
        <p class="text-sm text-center text-gray-600">Design and Develop by 
            <a href="<?= SOCIAL_LINKEDIN ?>" target="_blank" class="font-bold hover:underline ">Gulger Mallik</a> <br/>
            &copy; <?php echo date("Y"); ?> Finance Portal | All Rights Reserved.
        </p>
    </div>
</div>

</main>
</body>
</html>