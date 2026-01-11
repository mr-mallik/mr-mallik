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
                    redirect("/admin/article", "success", ucfirst($type) . " added successfully!");
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
                    redirect("/admin/article", "success", ucfirst($type) . " updated successfully!");
                }
            } catch (Exception $e) {
                redirect("/admin/article", "error", "Error: " . $e->getMessage());
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
                    
                    redirect("/admin/article", "success", ucfirst($content['type']) . " deleted successfully!");
                } catch (Exception $e) {
                    redirect("/admin/article", "error", "Error: " . $e->getMessage());
                }
            }
            break;
    }
}

// Handle GET actions
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

// Redirect to article list if no action specified
if (!$action) {
    redirect("/admin/article");
}

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
                redirect("/admin/article", "error", "Content not found!");
            }
        } else {
            redirect("/admin/article", "error", "Invalid content ID!");
        }
        break;
        
    case 'details':
        // Redirect to content details management
        redirect("/admin/content-details?id=$id");
        break;
        
    default:
        // Unknown action - redirect to list
        redirect("/admin/article");
        break;
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <!-- Add/Edit Form -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo $pageTitle; ?></h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the details below</p>
            </div>
            <a href="<?php echo APP_URL; ?>/admin/article" 
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
                <a href="<?php echo APP_URL; ?>/admin/article" 
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
