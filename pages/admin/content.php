<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
        case 'edit':
            $id = $_POST['id'] ?? null;
            $type = sanitizeBasicInput($_POST['type'] ?? 'blog');
            $title = sanitizeBasicInput($_POST['title'] ?? '');
            $overview = prepareForDatabase($_POST['overview'] ?? '', true); // Allow HTML
            $shortDescription = prepareForDatabase($_POST['short_description'] ?? '', true); // Allow HTML
            $publishedDate = sanitizeBasicInput($_POST['published_date'] ?? '');
            $skills = sanitizeBasicInput($_POST['skills'] ?? '');
            $status = sanitizeBasicInput($_POST['status'] ?? 'D');
            $github = sanitizeBasicInput($_POST['github'] ?? '');
            $online = sanitizeBasicInput($_POST['online'] ?? '');
            $userGuide = sanitizeBasicInput($_POST['user_guide'] ?? '');
            $seoTitle = sanitizeBasicInput($_POST['seo_title'] ?? '');
            $seoKeyword = sanitizeBasicInput($_POST['seo_keyword'] ?? '');
            $seoDesc = sanitizeBasicInput($_POST['seo_desc'] ?? '');
            
            // Generate URL name
            $urlname = $id ? generateUniqueSlug($title, 'blog', $id) : generateUniqueSlug($title, 'blog');
            
            // Handle image upload
            $image = '';
            $bannerImage = '';
            $uploadDir = '/assets/' . ($type === 'blog' ? 'blog' : 'projects') . '/' . $urlname . '/';
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($_FILES['image'], BASE_URL . $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $image = $uploadDir . $uploadResult['filename'];
                } else {
                    redirect("/admin/content", "error", $uploadResult['error']);
                }
            }
            
            if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($_FILES['banner_image'], BASE_URL . $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $bannerImage = $uploadDir . $uploadResult['filename'];
                } else {
                    redirect("/admin/content", "error", $uploadResult['error']);
                }
            }
            
            try {
                if ($action === 'add') {
                    $sql = "INSERT INTO blog (type, title, urlname, overview, short_description, published_date, skills, status, github, online, user_guide, seo_title, seo_keyword, seo_desc, image, banner_image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute([$type, $title, $urlname, $overview, $shortDescription, $publishedDate, $skills, $status, $github, $online, $userGuide, $seoTitle, $seoKeyword, $seoDesc, $image, $bannerImage]);
                    redirect("/admin/content", "success", ucfirst($type) . " added successfully!");
                } else {
                    $sql = "UPDATE blog SET type = ?, title = ?, urlname = ?, overview = ?, short_description = ?, published_date = ?, skills = ?, status = ?, github = ?, online = ?, user_guide = ?, seo_title = ?, seo_keyword = ?, seo_desc = ?";
                    $params = [$type, $title, $urlname, $overview, $shortDescription, $publishedDate, $skills, $status, $github, $online, $userGuide, $seoTitle, $seoKeyword, $seoDesc];
                    
                    if ($image) {
                        $sql .= ", image = ?";
                        $params[] = $image;
                    }
                    
                    if ($bannerImage) {
                        $sql .= ", banner_image = ?";
                        $params[] = $bannerImage;
                    }
                    
                    $sql .= " WHERE blog_id = ?";
                    $params[] = $id;
                    
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute($params);
                    redirect("/admin/content", "success", ucfirst($type) . " updated successfully!");
                }
            } catch (Exception $e) {
                redirect("/admin/content", "error", "Error: " . $e->getMessage());
            }
            break;
            
        case 'delete':
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
                    
                    redirect("/admin/content", "success", ucfirst($content['type']) . " deleted successfully!");
                } catch (Exception $e) {
                    redirect("/admin/content", "error", "Error: " . $e->getMessage());
                }
            }
            break;
    }
}

// Handle GET actions
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$filterType = $_GET['type'] ?? ''; // Filter by type (blog or project)

// Get current page for pagination
$page = $_GET['page'] ?? 1;
$itemsPerPage = 10;

switch ($action) {
    case 'add':
        $pageTitle = 'Add New Content';
        $content = null;
        break;
        
    case 'edit':
        $pageTitle = 'Edit Content';
        if ($id) {
            $stmt = $CONN->prepare("SELECT * FROM blog WHERE blog_id = ?");
            $stmt->execute([$id]);
            $content = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$content) {
                redirect("/admin/content", "error", "Content not found!");
            }
        } else {
            redirect("/admin/content", "error", "Invalid content ID!");
        }
        break;
        
    case 'details':
        // Redirect to content details management
        redirect("/admin/content-details?id=$id");
        break;
        
    default:
        $pageTitle = 'Manage Content';
        
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
        break;
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<?php if ($action === 'list'): ?>
    <!-- Content List View -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Manage Content</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage all your blogs and projects in one place</p>
            </div>
            <a href="<?php echo APP_URL; ?>/admin/content?action=add" 
               class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ripple">
                <i class="fas fa-plus mr-2"></i>Add New Content
            </a>
        </div>
        
        <!-- Filter Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-2">
            <div class="flex items-center space-x-2">
                <a href="<?php echo APP_URL; ?>/admin/content" 
                   class="flex items-center px-6 py-3 rounded-lg font-medium transition-all <?php echo $filterType === '' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                    <i class="fas fa-th-large mr-2"></i>
                    All Content
                    <span class="ml-2 px-2.5 py-0.5 text-xs rounded-full <?php echo $filterType === '' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-700'; ?>">
                        <?php echo $blogCount + $projectCount; ?>
                    </span>
                </a>
                <a href="<?php echo APP_URL; ?>/admin/content?type=blog" 
                   class="flex items-center px-6 py-3 rounded-lg font-medium transition-all <?php echo $filterType === 'blog' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                    <i class="fas fa-blog mr-2"></i>
                    Blogs
                    <span class="ml-2 px-2.5 py-0.5 text-xs rounded-full <?php echo $filterType === 'blog' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-700'; ?>">
                        <?php echo $blogCount; ?>
                    </span>
                </a>
                <a href="<?php echo APP_URL; ?>/admin/content?type=project" 
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
                                        <a href="<?php echo APP_URL; ?>/admin/content?action=edit&id=<?php echo $item['blog_id']; ?>" 
                                           class="w-9 h-9 flex items-center justify-center bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo APP_URL; ?>/admin/content?action=details&id=<?php echo $item['blog_id']; ?>" 
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
    
<?php else: ?>
    <!-- Add/Edit Form -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo $pageTitle; ?></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the details below</p>
            </div>
            <a href="<?php echo APP_URL; ?>/admin/content" 
               class="flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ripple">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
        
        <?php echo show_alert_message('error'); ?>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <?php if (isset($content)): ?>
                <input type="hidden" name="id" value="<?php echo $content['blog_id']; ?>">
            <?php endif; ?>
            
            <!-- Basic Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                    </div>
                    Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-tag mr-1"></i> Content Type
                        </label>
                        <select name="type" id="type" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="blog" <?php echo (isset($content) && $content['type'] === 'blog') ? 'selected' : ''; ?>>Blog</option>
                            <option value="project" <?php echo (isset($content) && $content['type'] === 'project') ? 'selected' : ''; ?>>Project</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-toggle-on mr-1"></i> Status
                        </label>
                        <select name="status" id="status" required class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="A" <?php echo (isset($content) && $content['status'] === 'A') ? 'selected' : ''; ?>>Active</option>
                            <option value="D" <?php echo (isset($content) && $content['status'] === 'D') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-heading mr-1"></i> Title
                    </label>
                    <input type="text" name="title" id="title" required 
                           value="<?php echo escapeOutput($content['title'] ?? ''); ?>"
                           class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Enter title">
                </div>
                
                <div class="mt-6">
                    <label for="overview" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-1"></i> Overview
                    </label>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <i class="fas fa-info-circle mr-1"></i> Supports HTML tags: &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;u&gt;, &lt;br&gt;, &lt;a&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, etc.
                    </div>
                    <textarea name="overview" id="overview" rows="8" 
                              placeholder="Enter overview with HTML tags if needed..."
                              class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm transition-all"><?php echo $content['overview'] ?? ''; ?></textarea>
                </div>
                
                <div class="mt-6">
                    <label for="short_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-file-alt mr-1"></i> Short Description
                    </label>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <i class="fas fa-info-circle mr-1"></i> Supports HTML tags for formatting. Keep it concise for preview purposes.
                    </div>
                    <textarea name="short_description" id="short_description" rows="4" 
                              placeholder="Enter short description with HTML tags if needed..."
                              class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm transition-all"><?php echo $content['short_description'] ?? ''; ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="published_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-1"></i> Published Date
                        </label>
                        <input type="date" name="published_date" id="published_date" 
                               value="<?php echo $content['published_date'] ?? date('Y-m-d'); ?>"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="skills" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-code mr-1"></i> Skills (comma-separated IDs)
                        </label>
                        <input type="text" name="skills" id="skills" 
                               value="<?php echo htmlspecialchars($content['skills'] ?? ''); ?>"
                               placeholder="e.g., 1,2,3"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="github" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fab fa-github mr-1"></i> GitHub URL
                        </label>
                        <input type="url" name="github" id="github" 
                               value="<?php echo htmlspecialchars($content['github'] ?? ''); ?>"
                               placeholder="https://github.com/..."
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="online" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-globe mr-1"></i> Online URL
                        </label>
                        <input type="url" name="online" id="online" 
                               value="<?php echo htmlspecialchars($content['online'] ?? ''); ?>"
                               placeholder="https://..."
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="user_guide" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-book mr-1"></i> User Guide URL
                        </label>
                        <input type="url" name="user_guide" id="user_guide" 
                               value="<?php echo htmlspecialchars($content['user_guide'] ?? ''); ?>"
                               placeholder="https://..."
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-image mr-1"></i> Main Image
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               onchange="previewImage(this, 'image-preview')"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                        <div id="image-preview" class="mt-3">
                            <?php if (isset($content['image']) && $content['image']): ?>
                                <div class="material-card bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                                    <img src="<?=url($content['image']); ?>" 
                                         alt="Current image" class="w-full h-auto rounded-lg">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div>
                        <label for="banner_image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-panorama mr-1"></i> Banner Image
                        </label>
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" 
                               onchange="previewImage(this, 'banner-preview')"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                        <div id="banner-preview" class="mt-3">
                            <?php if (isset($content['banner_image']) && $content['banner_image']): ?>
                                <div class="material-card bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                                    <img src="<?=url($content['banner_image']); ?>" 
                                         alt="Current banner" class="w-full h-auto rounded-lg">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-search text-green-600 dark:text-green-400"></i>
                    </div>
                    SEO Settings
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <label for="seo_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-heading mr-1"></i> SEO Title
                        </label>
                        <input type="text" name="seo_title" id="seo_title" 
                               value="<?php echo htmlspecialchars($content['seo_title'] ?? ''); ?>"
                               placeholder="Optimized title for search engines"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="seo_keyword" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-tags mr-1"></i> SEO Keywords
                        </label>
                        <input type="text" name="seo_keyword" id="seo_keyword" 
                               value="<?php echo htmlspecialchars($content['seo_keyword'] ?? ''); ?>"
                               placeholder="keyword1, keyword2, keyword3"
                               class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="seo_desc" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-align-left mr-1"></i> SEO Description
                        </label>
                        <textarea name="seo_desc" id="seo_desc" rows="3" 
                                  placeholder="A compelling description for search engine results"
                                  class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"><?php echo htmlspecialchars($content['seo_desc'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                <a href="<?php echo APP_URL; ?>/admin/content" 
                   class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-medium transition-all ripple">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all ripple">
                    <i class="fas fa-save mr-2"></i><?php echo $action === 'add' ? 'Add Content' : 'Update Content'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
