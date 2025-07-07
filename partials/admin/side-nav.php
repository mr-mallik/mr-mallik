<?php
// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Don't show navigation if not logged in
    return;
}

$currentUri = $_SERVER['REQUEST_URI'];
$adminPages = [
    'dashboard' => ['url' => '/admin', 'icon' => 'fas fa-tachometer-alt', 'title' => 'Dashboard'],
    'blogs' => ['url' => '/admin/blogs', 'icon' => 'fas fa-blog', 'title' => 'Blogs'],
    'projects' => ['url' => '/admin/projects', 'icon' => 'fas fa-project-diagram', 'title' => 'Projects'],
    // 'profile' => ['url' => '/admin/profile', 'icon' => 'fas fa-user', 'title' => 'Profile'],
    'logout' => ['url' => '/admin/logout', 'icon' => 'fas fa-sign-out-alt', 'title' => 'Logout']
];

function isActiveAdminPage($url) {
    $currentUri = $_SERVER['REQUEST_URI'];
    return strpos($currentUri, $url) !== false ? 'bg-gray-700 text-white' : '';
}
?>

<nav class="bg-gray-800 text-white w-64 min-h-screen fixed left-0 top-0 z-50">
    <div class="p-4">
        <h2 class="text-xl font-bold mb-6">CMS Panel</h2>
        <ul class="space-y-2">
            <?php foreach ($adminPages as $key => $page): ?>
                <li>
                    <a href="<?php echo APP_URL . $page['url']; ?>" 
                       class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors <?php echo isActiveAdminPage($page['url']); ?>">
                        <i class="<?php echo $page['icon']; ?>"></i>
                        <span><?php echo $page['title']; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="absolute bottom-4 left-4 right-4">
        <div class="bg-gray-700 p-3 rounded-lg">
            <p class="text-sm text-gray-300">Welcome back,</p>
            <p class="font-medium"><?php echo $_SESSION['admin_user']['name'] ?? 'Admin'; ?></p>
        </div>
    </div>
</nav>

<!-- Main content wrapper to account for sidebar -->
<div class="ml-64 min-h-screen">
    <header class="bg-white dark:bg-gray-900 shadow-sm border-b">
        <div class="flex justify-between items-center p-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <?php
                    $currentPath = basename($_SERVER['REQUEST_URI']);
                    echo ucfirst($currentPath === 'admin' ? 'Dashboard' : $currentPath);
                    ?>
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="<?php echo APP_URL; ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-external-link-alt mr-2"></i>View Site
                </a>
                <a href="<?php echo APP_URL; ?>/admin/logout" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </header>
    
    <div class="p-6">
