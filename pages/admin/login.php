<?php
require_once __DIR__ . "/../../includes/admin-common.php";

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect("/admin");
}

require_once __DIR__ . "/../../partials/admin/header.php";
?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-4">
    <div class="w-full max-w-md">
        <!-- Material Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-10 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-blue-100">Sign in to your CMS account</p>
            </div>
            
            <!-- Form Section -->
            <div class="px-8 py-10">
                <form class="space-y-6" action="auth" method="POST">
                    <?= show_alert_message('error'); ?>
                    <?= show_alert_message('success'); ?>
                    <?= show_alert_message('info'); ?>
                    <?= show_alert_message('warning'); ?>
                    
                    <!-- Username Input -->
                    <div class="relative">
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="username" id="username" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-900 dark:text-white"
                                placeholder="Enter your username">
                        </div>
                    </div>
                    
                    <!-- Password Input -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-900 dark:text-white"
                                placeholder="Enter your password">
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ripple">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </button>
                </form>
            </div>
            
            <!-- Footer Section -->
            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                    Designed & Developed by 
                    <a href="<?= SOCIAL_LINKEDIN ?>" target="_blank" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">Gulger Mallik</a>
                </p>
                <p class="text-xs text-center text-gray-500 dark:text-gray-500 mt-2">
                    &copy; <?php echo date("Y"); ?> All Rights Reserved
                </p>
            </div>
        </div>
    </div>
</div>

</main>
</body>
</html>