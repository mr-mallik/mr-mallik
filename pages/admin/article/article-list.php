<?php
require_once __DIR__ . '/../../../includes/admin-common.php';
checkAdminAuth();

$dispUrl = APP_URL . "/admin/article/article-list";
$editUrl = APP_URL . "/admin/article/article-edit";

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            try {
                // Get file names before deletion
                $stmt = $CONN->prepare("SELECT image, banner_image, type FROM blog WHERE blog_id = ?");
                $stmt->execute([$id]);
                $content = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Delete from database
                $stmt = $CONN->prepare("DELETE FROM blog WHERE blog_id = ?");
                $stmt->execute([$id]);
                
                // Delete details
                $stmt = $CONN->prepare("DELETE FROM blog_det WHERE blog_id = ?");
                $stmt->execute([$id]);
                
                // Delete files
                if ($content['image']) {
                    $filePath = BASE_URL . $content['image'];
                    deleteFile($filePath);
                }
                
                if ($content['banner_image']) {
                    $filePath = BASE_URL . $content['banner_image'];
                    deleteFile($filePath);
                }
                
                redirect($dispUrl, "success", ucfirst($content['type']) . " deleted successfully!");
            } catch (Exception $e) {
                redirect($dispUrl, "error", "Error: " . $e->getMessage());
            }
        }
    }
}

// Get filter and pagination parameters
$filterType = $_GET['type'] ?? ''; // Filter by type (blog or project)
$page = $_GET['page'] ?? 1;
$itemsPerPage = 10;

// Build WHERE clause for filtering
$whereClause = '';
if ($filterType) {
    $whereClause = "type = '" . sanitizeBasicInput($filterType) . "'";
}

// Get pagination data
$paginationData = getPaginationData('blog', $page, $itemsPerPage, $whereClause);

// Get content items
$sql = "SELECT * FROM blog" . ($whereClause ? " WHERE $whereClause" : "") . " ORDER BY published_date DESC LIMIT {$itemsPerPage} OFFSET {$paginationData['offset']}";
$stmt = $CONN->query($sql);
$contentItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get counts for filters
$blogCount = $CONN->query("SELECT COUNT(*) FROM blog WHERE type = 'blog'")->fetchColumn();
$projectCount = $CONN->query("SELECT COUNT(*) FROM blog WHERE type = 'project'")->fetchColumn();

require_once __DIR__ . '/../../../partials/admin/header.php';
require_once __DIR__ . '/../../../partials/admin/side-nav.php';
?>

<!-- Content List View -->
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Manage Content</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage all your blogs and projects in one place</p>
        </div>
        <a href="<?php echo $editUrl; ?>" 
           class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ripple">
            <i class="fas fa-plus mr-2"></i>Add New Content
        </a>
    </div>
    
    <!-- Filter Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-2">
        <div class="flex items-center space-x-2">
            <a href="<?php echo $dispUrl; ?>" 
               class="flex items-center px-6 py-3 rounded-lg font-medium transition-all <?php echo $filterType === '' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-th-large mr-2"></i>
                All Content
                <span class="ml-2 px-2.5 py-0.5 text-xs rounded-full <?php echo $filterType === '' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-700'; ?>">
                    <?php echo $blogCount + $projectCount; ?>
                </span>
            </a>
            <a href="<?php echo $dispUrl; ?>?type=blog" 
               class="flex items-center px-6 py-3 rounded-lg font-medium transition-all <?php echo $filterType === 'blog' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-blog mr-2"></i>
                Blogs
                <span class="ml-2 px-2.5 py-0.5 text-xs rounded-full <?php echo $filterType === 'blog' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-700'; ?>">
                    <?php echo $blogCount; ?>
                </span>
            </a>
            <a href="<?php echo $dispUrl; ?>?type=project" 
               class="flex items-center px-6 py-3 rounded-lg font-medium transition-all <?php echo $filterType === 'project' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-project-diagram mr-2"></i>
                Projects
                <span class="ml-2 px-2.5 py-0.5 text-xs rounded-full <?php echo $filterType === 'project' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-700'; ?>">
                    <?php echo $projectCount; ?>
                </span>
            </a>
        </div>
    </div>
    
    <?php echo show_alert_message('success'); ?>
    <?php echo show_alert_message('error'); ?>
    
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        Published Date
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <?php if (empty($contentItems)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">No content found</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Start by adding your first <?php echo $filterType ? $filterType : 'blog or project'; ?></p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contentItems as $item): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($item['image']): ?>
                                        <img class="h-12 w-12 rounded-lg object-cover mr-4 shadow-sm" 
                                             src="<?php url($item['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    <?php else: ?>
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center mr-4">
                                            <i class="fas fa-<?php echo $item['type'] === 'blog' ? 'blog' : 'project-diagram'; ?> text-gray-500 dark:text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?php echo escapeOutput($item['title']); ?>
                                        </div>
                                        <?php if ($item['short_description']): ?>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">
                                                <?php echo cutWords(strip_tags($item['short_description']), 60); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $item['type'] === 'blog' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400'; ?>">
                                    <i class="fas fa-<?php echo $item['type'] === 'blog' ? 'blog' : 'project-diagram'; ?> mr-1.5 text-xs"></i>
                                    <?php echo ucfirst($item['type']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $item['status'] === 'A' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400'; ?>">
                                    <i class="fas fa-<?php echo $item['status'] === 'A' ? 'check-circle' : 'clock'; ?> mr-1.5 text-xs"></i>
                                    <?php echo $item['status'] === 'A' ? 'Active' : 'Draft'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                <?php echo formatDate($item['published_date'], 'M d, Y'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo $editUrl; ?>?id=<?php echo $item['blog_id']; ?>" 
                                       class="w-9 h-9 flex items-center justify-center bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $item['blog_id']; ?>" 
                                       class="w-9 h-9 flex items-center justify-center bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-all"
                                       title="Manage Details">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this <?php echo $item['type']; ?>? This will also delete all associated details.');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $item['blog_id']; ?>">
                                        <button type="submit" 
                                                class="w-9 h-9 flex items-center justify-center bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition-all"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if ($paginationData['totalPages'] > 1): ?>
        <div class="flex justify-center">
            <nav class="flex items-center space-x-2">
                <?php if ($paginationData['hasPrev']): ?>
                    <a href="?page=<?php echo $paginationData['currentPage'] - 1; ?><?php echo $filterType ? '&type=' . $filterType : ''; ?>" 
                       class="px-4 py-2 text-sm font-medium bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                        <i class="fas fa-chevron-left mr-1"></i> Previous
                    </a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $paginationData['totalPages']; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo $filterType ? '&type=' . $filterType : ''; ?>" 
                       class="px-4 py-2 text-sm font-medium <?php echo $i === $paginationData['currentPage'] ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'; ?> rounded-lg transition-all">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($paginationData['hasNext']): ?>
                    <a href="?page=<?php echo $paginationData['currentPage'] + 1; ?><?php echo $filterType ? '&type=' . $filterType : ''; ?>" 
                       class="px-4 py-2 text-sm font-medium bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                        Next <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../../partials/admin/footer.php'; ?>
