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
            $type = 'project'; // Force type to project
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
            $uploadDir = '/assets/projects/'. $urlname .'/';
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($_FILES['image'], BASE_URL . $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $image = $uploadDir . $uploadResult['filename'];
                } else {
                    redirect("/admin/projects", "error", $uploadResult['error']);
                }
            }
            
            if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($_FILES['banner_image'], BASE_URL . $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $bannerImage = $uploadDir . $uploadResult['filename'];
                } else {
                    redirect("/admin/projects", "error", $uploadResult['error']);
                }
            }
            
            try {
                if ($action === 'add') {
                    $sql = "INSERT INTO blog (type, title, urlname, overview, short_description, published_date, skills, status, github, online, user_guide, seo_title, seo_keyword, seo_desc, image, banner_image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute([$type, $title, $urlname, $overview, $shortDescription, $publishedDate, $skills, $status, $github, $online, $userGuide, $seoTitle, $seoKeyword, $seoDesc, $image, $bannerImage]);
                    redirect("/admin/projects", "success", "Project added successfully!");
                } else {
                    $sql = "UPDATE blog SET title = ?, urlname = ?, overview = ?, short_description = ?, published_date = ?, skills = ?, status = ?, github = ?, online = ?, user_guide = ?, seo_title = ?, seo_keyword = ?, seo_desc = ?";
                    $params = [$title, $urlname, $overview, $shortDescription, $publishedDate, $skills, $status, $github, $online, $userGuide, $seoTitle, $seoKeyword, $seoDesc];
                    
                    if ($image) {
                        $sql .= ", image = ?";
                        $params[] = $image;
                    }
                    
                    if ($bannerImage) {
                        $sql .= ", banner_image = ?";
                        $params[] = $bannerImage;
                    }
                    
                    $sql .= " WHERE project_id = ?";
                    $params[] = $id;
                    
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute($params);
                    redirect("/admin/projects", "success", "Project updated successfully!");
                }
            } catch (Exception $e) {
                redirect("/admin/projects", "error", "Error: " . $e->getMessage());
            }
            break;
            
        case 'delete':
            $id = $_POST['id'] ?? null;
            if ($id) {
                try {
                    // Get file names before deletion
                    $stmt = $CONN->prepare("SELECT image, banner_image FROM blog WHERE project_id = ?");
                    $stmt->execute([$id]);
                    $project = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Delete from database
                    $stmt = $CONN->prepare("DELETE FROM blog WHERE project_id = ?");
                    $stmt->execute([$id]);
                    
                    // Delete details
                    $stmt = $CONN->prepare("DELETE FROM blog_det WHERE project_id = ?");
                    $stmt->execute([$id]);
                    
                    // Delete files
                    if ($project['image']) {
                        $filePath = BASE_URL . '/assets/projects/' . $project['image'];
                        deleteFile($filePath);
                    }
                    
                    if ($project['banner_image']) {
                        $filePath = BASE_URL . '/assets/projects/' . $project['banner_image'];
                        deleteFile($filePath);
                    }
                    
                    redirect("/admin/projects", "success", "Project deleted successfully!");
                } catch (Exception $e) {
                    redirect("/admin/projects", "error", "Error: " . $e->getMessage());
                }
            }
            break;
    }
}

// Handle GET actions
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Get current page for pagination
$page = $_GET['page'] ?? 1;
$itemsPerPage = 10;

switch ($action) {
    case 'add':
        $pageTitle = 'Add New Project';
        $project = null;
        break;
        
    case 'edit':
        $pageTitle = 'Edit Project';
        if ($id) {
            $stmt = $CONN->prepare("SELECT * FROM blog WHERE project_id = ? AND type = 'project'");
            $stmt->execute([$id]);
            $project = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$project) {
                redirect("/admin/projects", "error", "Project not found!");
            }
        } else {
            redirect("/admin/projects", "error", "Invalid project ID!");
        }
        break;
        
    case 'details':
        // Redirect to project details management
        redirect("/admin/blog-details?id=$id");
        break;
        
    default:
        $pageTitle = 'Manage Projects';
        
        // Get pagination data
        $paginationData = getPaginationData('blog', $page, $itemsPerPage, "type = 'project'");
        
        // Get projects
        $sql = "SELECT * FROM blog WHERE type = 'project' ORDER BY published_date DESC LIMIT {$itemsPerPage} OFFSET {$paginationData['offset']}";
        $stmt = $CONN->query($sql);
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<?php if ($action === 'list'): ?>
    <!-- Project List View -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Projects</h2>
            <a href="<?php echo APP_URL; ?>/admin/projects?action=add" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Add New Project
            </a>
        </div>
        
        <?php echo show_alert_message('success'); ?>
        <?php echo show_alert_message('error'); ?>
        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Project
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Published Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Links
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <?php if ($project['image']): ?>
                                        <img class="h-10 w-10 rounded-full mr-3" 
                                             src="<?php url($project['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($project['title']); ?>">
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?php echo htmlspecialchars($project['title']); ?>
                                        </div>
                                        <?php if ($project['short_description']): ?>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <?php echo cutWords($project['short_description'], 60); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $project['status'] === 'A' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo $project['status'] === 'A' ? 'Active' : 'Draft'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <?php echo formatDate($project['published_date'], 'M d, Y'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex space-x-2">
                                    <?php if ($project['github']): ?>
                                        <a href="<?php echo $project['github']; ?>" target="_blank" class="text-gray-600 hover:text-gray-800">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($project['online']): ?>
                                        <a href="<?php echo $project['online']; ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo APP_URL; ?>/admin/projects?action=edit&id=<?php echo $project['project_id']; ?>" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo APP_URL; ?>/admin/projects?action=details&id=<?php echo $project['project_id']; ?>" 
                                   class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-list"></i>
                                </a>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $project['project_id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($paginationData['totalPages'] > 1): ?>
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if ($paginationData['hasPrev']): ?>
                        <a href="?page=<?php echo $paginationData['currentPage'] - 1; ?>" 
                           class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                            Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $paginationData['totalPages']; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" 
                           class="px-3 py-2 text-sm <?php echo $i === $paginationData['currentPage'] ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700'; ?> rounded-md">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($paginationData['hasNext']): ?>
                        <a href="?page=<?php echo $paginationData['currentPage'] + 1; ?>" 
                           class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                            Next
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
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $pageTitle; ?></h2>
            <a href="<?php echo APP_URL; ?>/admin/projects" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
        
        <?php echo show_alert_message('error'); ?>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <?php if (isset($project)): ?>
                <input type="hidden" name="id" value="<?php echo $project['project_id']; ?>">
            <?php endif; ?>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <option value="A" <?php echo (isset($project) && $project['status'] === 'A') ? 'selected' : ''; ?>>Active</option>
                            <option value="D" <?php echo (isset($project) && $project['status'] === 'D') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="published_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published Date</label>
                        <input type="date" name="published_date" id="published_date" 
                               value="<?php echo (isset($project) ? $project['published_date'] : date('Y-m-d')); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Title</label>
                    <input type="text" name="title" id="title" required 
                           value="<?php echo htmlspecialchars(isset($project) ? $project['title'] : ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                
                <div class="mt-6">
                    <label for="overview" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Overview</label>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        Supports HTML tags: &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;u&gt;, &lt;br&gt;, &lt;a&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, etc.
                    </div>
                    <textarea name="overview" id="overview" rows="8" 
                              placeholder="Enter project overview with HTML tags if needed..."
                              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 font-mono text-sm"><?php echo isset($project) ? $project['overview'] : ''; ?></textarea>
                </div>
                
                <div class="mt-6">
                    <label for="short_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Description</label>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        Supports HTML tags for formatting. Keep it concise for preview purposes.
                    </div>
                    <textarea name="short_description" id="short_description" rows="4" 
                              placeholder="Enter short description with HTML tags if needed..."
                              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 font-mono text-sm"><?php echo isset($project) ? $project['short_description'] : ''; ?></textarea>
                </div>
                
                <div class="mt-6">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skills Used (comma-separated IDs)</label>
                    <input type="text" name="skills" id="skills" 
                           value="<?php echo htmlspecialchars(isset($project) ? $project['skills'] : ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="github" class="block text-sm font-medium text-gray-700 dark:text-gray-300">GitHub URL</label>
                        <input type="url" name="github" id="github" 
                               value="<?php echo htmlspecialchars(isset($project) ? $project['github'] : ''); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="online" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Live Demo URL</label>
                        <input type="url" name="online" id="online" 
                               value="<?php echo htmlspecialchars(isset($project) ? $project['online'] : ''); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="user_guide" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Guide URL</label>
                        <input type="url" name="user_guide" id="user_guide" 
                               value="<?php echo htmlspecialchars(isset($project) ? $project['user_guide'] : ''); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Image (400px X 400px)</label>
                        <input type="file" name="image" id="image" accept="image/*" 
                               onchange="previewImage(this, 'image-preview')"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <div id="image-preview" class="mt-2">
                            <?php if (isset($project['image']) && $project['image']): ?>
                                <img src="<?=url($project['image']); ?>" width="400" height="400"
                                     alt="Current image" class="max-w-full h-auto rounded-lg shadow-md">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div>
                        <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image (1500px X 500px)</label>
                        <input type="file" name="banner_image" id="banner_image" accept="image/*" 
                               onchange="previewImage(this, 'banner-preview')"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <div id="banner-preview" class="mt-2">
                            <?php if (isset($project['banner_image']) && $project['banner_image']): ?>
                                <img src="<?=url($project['banner_image']); ?>" 
                                     alt="Current banner" class="max-w-full h-auto rounded-lg shadow-md">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">SEO Settings</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="seo_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">SEO Title</label>
                        <input type="text" name="seo_title" id="seo_title" 
                               value="<?php echo htmlspecialchars(isset($project) ? $project['seo_title'] : ''); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="seo_keyword" class="block text-sm font-medium text-gray-700 dark:text-gray-300">SEO Keywords</label>
                        <input type="text" name="seo_keyword" id="seo_keyword" 
                               value="<?php echo htmlspecialchars(isset($project) ? $project['seo_keyword'] : ''); ?>"
                               class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <div>
                        <label for="seo_desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300">SEO Description</label>
                        <textarea name="seo_desc" id="seo_desc" rows="3" 
                                  class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"><?php echo htmlspecialchars(isset($project) ? $project['seo_desc'] : ''); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="<?php echo APP_URL; ?>/admin/projects" 
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <?php echo $action === 'add' ? 'Add Project' : 'Update Project'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>