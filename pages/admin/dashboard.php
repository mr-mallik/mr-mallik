<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth();

// Get statistics
$blogStmt = $CONN->query("SELECT COUNT(*) as count FROM blog WHERE type = 'blog'");
$blogCount = $blogStmt->fetch(PDO::FETCH_ASSOC)['count'];

$projectStmt = $CONN->query("SELECT COUNT(*) as count FROM blog WHERE type = 'project'");
$projectCount = $projectStmt->fetch(PDO::FETCH_ASSOC)['count'];

// Get recent items
$recentStmt = $CONN->query("SELECT * FROM blog ORDER BY published_date DESC LIMIT 5");
$recentItems = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<div class="space-y-8">
    <!-- Stats Cards - Material Design -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Blogs Card -->
        <div class="material-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-blog text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-5xl font-bold"><?php echo $blogCount; ?></p>
                    </div>
                </div>
                <p class="text-blue-100 font-medium">Total Blogs</p>
                <div class="mt-3 pt-3 border-t border-white/20">
                    <a href="<?php echo APP_URL; ?>/admin/content?type=blog" class="text-sm text-white hover:text-blue-100 flex items-center">
                        Manage Blogs <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="material-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-project-diagram text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-5xl font-bold"><?php echo $projectCount; ?></p>
                    </div>
                </div>
                <p class="text-green-100 font-medium">Total Projects</p>
                <div class="mt-3 pt-3 border-t border-white/20">
                    <a href="<?php echo APP_URL; ?>/admin/content?type=project" class="text-sm text-white hover:text-green-100 flex items-center">
                        Manage Projects <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Content Card -->
        <div class="material-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-file-alt text-3xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-5xl font-bold"><?php echo $blogCount + $projectCount; ?></p>
                    </div>
                </div>
                <p class="text-purple-100 font-medium">Total Content</p>
                <div class="mt-3 pt-3 border-t border-white/20">
                    <span class="text-sm text-purple-100">Blogs + Projects</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Items -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Items</h3>
        </div>
        <div class="p-6">
            <?php if (empty($recentItems)): ?>
                <p class="text-gray-500 dark:text-gray-400">No content available yet.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recentItems as $item): ?>
                        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-<?php echo $item['type'] === 'blog' ? 'blog' : 'project-diagram'; ?> text-xl text-gray-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php echo ucfirst($item['type']); ?> • <?php echo formatDate($item['published_date'], 'M d, Y'); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="<?php echo APP_URL; ?>/admin/content?action=edit&id=<?php echo $item['blog_id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="<?php echo APP_URL; ?>/admin/content?action=add" 
               class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fas fa-plus text-blue-600 mr-3"></i>
                <span class="text-blue-600 dark:text-blue-300 font-medium">Add New Blog</span>
            </a>
            <a href="<?php echo APP_URL; ?>/admin/content?action=add" 
               class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <i class="fas fa-plus text-green-600 mr-3"></i>
                <span class="text-green-600 dark:text-green-300 font-medium">Add New Project</span>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
