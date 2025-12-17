<?php
// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Don't show navigation if not logged in
    return;
}

$currentUri = $_SERVER['REQUEST_URI'];
$adminPages = [
    'dashboard' => ['url' => '/admin', 'icon' => 'fas fa-tachometer-alt', 'title' => 'Dashboard'],
    'content' => ['url' => '/admin/content', 'icon' => 'fas fa-th-large', 'title' => 'Content'],
    'cookie-consent' => ['url' => '/admin/cookie-consent', 'icon' => 'fas fa-cookie-bite', 'title' => 'Cookie Consent'],
    'profile' => ['url' => '/admin/profile', 'icon' => 'fas fa-user', 'title' => 'Profile'],
    'logout' => ['url' => '/admin/logout', 'icon' => 'fas fa-sign-out-alt', 'title' => 'Logout']
];

function isActiveAdminPage($url) {
    $currentUri = $_SERVER['REQUEST_URI'];
    return strpos($currentUri, $url) !== false ? 'bg-blue-600 text-white shadow-lg' : '';
}
?>

<nav class="bg-white dark:bg-gray-800 text-gray-800 dark:text-white w-72 min-h-screen fixed left-0 top-0 z-50 shadow-2xl">
    <div class="p-6">
        <div class="flex items-center mb-8 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <i class="fas fa-shield-alt text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold">CMS Panel</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Admin Portal</p>
            </div>
        </div>
        
        <ul class="space-y-1">
            <?php foreach ($adminPages as $key => $page): ?>
                <li>
                    <a href="<?php echo APP_URL . $page['url']; ?>" 
                       class="flex items-center space-x-4 px-4 py-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 group <?php echo isActiveAdminPage($page['url']); ?> ripple">
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg <?php echo isActiveAdminPage($page['url']) ? 'bg-white/20' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-gray-200 dark:group-hover:bg-gray-600'; ?> transition-colors">
                            <i class="<?php echo $page['icon']; ?> text-lg"></i>
                        </div>
                        <span class="font-medium"><?php echo $page['title']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="absolute bottom-6 left-6 right-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-2xl shadow-lg border border-blue-200 dark:border-gray-600">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                    <?php 
                        $firstName = $_SESSION['admin_user']['first_name'] ?? '';
                        $lastName = $_SESSION['admin_user']['last_name'] ?? '';
                        $fullName = trim($firstName . ' ' . $lastName);
                        $initials = '';
                        if ($firstName) $initials .= strtoupper($firstName[0]);
                        if ($lastName) $initials .= strtoupper($lastName[0]);
                        echo $initials ?: 'A';
                    ?>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-600 dark:text-gray-300 font-medium">Welcome back</p>
                    <p class="font-bold text-gray-900 dark:text-white truncate">
                        <?php echo $fullName ?: 'Admin'; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Main content wrapper to account for sidebar -->
<div class="ml-72 min-h-screen bg-gray-50 dark:bg-gray-900">
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-40">
        <div class="flex justify-between items-center px-8 py-5">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php
                    $currentPath = basename($_SERVER['REQUEST_URI']);
                    echo ucfirst($currentPath === 'admin' ? 'Dashboard' : str_replace('-', ' ', $currentPath));
                    ?>
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    <?php echo date('l, F j, Y'); ?>
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo APP_URL; ?>" target="_blank" 
                   class="flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-all duration-200 ripple">
                    <i class="fas fa-external-link-alt mr-2"></i>View Site
                </a>
                <a href="<?php echo APP_URL; ?>/admin/logout" 
                   class="flex items-center px-4 py-2 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 rounded-lg transition-all duration-200 ripple">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </header>
    
    <div class="p-8">
