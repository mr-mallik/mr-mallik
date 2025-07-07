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

<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-blog text-3xl text-blue-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Blogs</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?php echo $blogCount; ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-project-diagram text-3xl text-green-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Projects</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?php echo $projectCount; ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-file-alt text-3xl text-purple-600"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Content</dt>
                        <dd class="text-lg font-medium text-gray-900 dark:text-white"><?php echo $blogCount + $projectCount; ?></dd>
                    </dl>
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
                                <a href="<?php echo APP_URL; ?>/admin/<?php echo $item['type'] === 'blog' ? 'blogs' : 'projects'; ?>?action=edit&id=<?php echo $item['project_id']; ?>" 
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
            <a href="<?php echo APP_URL; ?>/admin/blogs?action=add" 
               class="flex items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <i class="fas fa-plus text-blue-600 mr-3"></i>
                <span class="text-blue-600 dark:text-blue-300 font-medium">Add New Blog</span>
            </a>
            <a href="<?php echo APP_URL; ?>/admin/projects?action=add" 
               class="flex items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <i class="fas fa-plus text-green-600 mr-3"></i>
                <span class="text-green-600 dark:text-green-300 font-medium">Add New Project</span>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
