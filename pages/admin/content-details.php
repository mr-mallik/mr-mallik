<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth();

$contentId = $_GET['id'] ?? null;
if (!$contentId) {
    redirect("/admin/content", "error", "Invalid content ID!");
}

// Get content details
$stmt = $CONN->prepare("SELECT * FROM blog WHERE blog_id = ?");
$stmt->execute([$contentId]);
$content = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$content) {
    redirect("/admin/content", "error", "Content not found!");
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
        case 'edit':
            $id = $_POST['id'] ?? null;
            $title = sanitizeBasicInput($_POST['title'] ?? '');
            $description = prepareForDatabase($_POST['description'] ?? '', true); // Allow HTML
            $videoLink = sanitizeBasicInput($_POST['video_link'] ?? '');
            
            // Handle image upload
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_URL . '/assets/' . ($content['type'] === 'blog' ? 'blog' : 'projects') . '/' . $content['urlname'] . '/';
                $uploadResult = handleFileUpload($_FILES['image'], $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $image = $uploadResult['filename'];
                } else {
                    redirect("/admin/content-details?id=$contentId", "error", $uploadResult['error']);
                }
            }
            
            try {
                if ($action === 'add') {
                    $sql = "INSERT INTO blog_det (blog_id, title, description, video_link, image) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute([$contentId, $title, $description, $videoLink, $image]);
                    redirect("/admin/content-details?id=$contentId", "success", "Detail added successfully!");
                } else {
                    $sql = "UPDATE blog_det SET title = ?, description = ?, video_link = ?";
                    $params = [$title, $description, $videoLink];
                    
                    if ($image) {
                        $sql .= ", image = ?";
                        $params[] = $image;
                    }
                    
                    $sql .= " WHERE id = ?";
                    $params[] = $id;
                    
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute($params);
                    redirect("/admin/content-details?id=$contentId", "success", "Detail updated successfully!");
                }
            } catch (Exception $e) {
                redirect("/admin/content-details?id=$contentId", "error", "Error: " . $e->getMessage());
            }
            break;
            
        case 'delete':
            $id = $_POST['id'] ?? null;
            if ($id) {
                try {
                    // Get file name before deletion
                    $stmt = $CONN->prepare("SELECT image FROM blog_det WHERE id = ?");
                    $stmt->execute([$id]);
                    $detail = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Delete from database
                    $stmt = $CONN->prepare("DELETE FROM blog_det WHERE id = ?");
                    $stmt->execute([$id]);
                    
                    // Delete file
                    if ($detail['image']) {
                        $filePath = BASE_URL . '/assets/' . ($content['type'] === 'blog' ? 'blog' : 'projects') . '/' . $content['urlname'] . '/' . $detail['image'];
                        deleteFile($filePath);
                    }
                    
                    redirect("/admin/content-details?id=$contentId", "success", "Detail deleted successfully!");
                } catch (Exception $e) {
                    redirect("/admin/content-details?id=$contentId", "error", "Error: " . $e->getMessage());
                }
            }
            break;
    }
}

// Handle GET actions
$detailAction = $_GET['detail_action'] ?? 'list';
$detailId = $_GET['detail_id'] ?? null;

switch ($detailAction) {
    case 'add':
        $pageTitle = 'Add New Detail';
        $detail = null;
        break;
        
    case 'edit':
        $pageTitle = 'Edit Detail';
        if ($detailId) {
            $stmt = $CONN->prepare("SELECT * FROM blog_det WHERE id = ?");
            $stmt->execute([$detailId]);
            $detail = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$detail) {
                redirect("/admin/content-details?id=$contentId", "error", "Detail not found!");
            }
        } else {
            redirect("/admin/content-details?id=$contentId", "error", "Invalid detail ID!");
        }
        break;
        
    default:
        $pageTitle = 'Content Details';
        
        // Get content details
        $stmt = $CONN->prepare("SELECT * FROM blog_det WHERE blog_id = ? ORDER BY id ASC");
        $stmt->execute([$contentId]);
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<div class="space-y-6">
    <!-- Content Info Header -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-800 rounded-2xl shadow-xl p-6 border border-blue-100 dark:border-gray-700">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center mb-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mr-3 <?php echo $content['type'] === 'blog' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400'; ?>">
                        <i class="fas fa-<?php echo $content['type'] === 'blog' ? 'blog' : 'project-diagram'; ?> mr-1.5"></i>
                        <?php echo ucfirst($content['type']); ?>
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo $content['status'] === 'A' ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400'; ?>">
                        <i class="fas fa-<?php echo $content['status'] === 'A' ? 'check-circle' : 'clock'; ?> mr-1.5"></i>
                        <?php echo $content['status'] === 'A' ? 'Active' : 'Draft'; ?>
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo escapeOutput($content['title']); ?></h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage detailed sections and content blocks</p>
            </div>
            <a href="<?php echo APP_URL; ?>/admin/content" 
               class="flex items-center px-6 py-3 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ripple">
                <i class="fas fa-arrow-left mr-2"></i>Back to Content
            </a>
        </div>
    </div>
    
    <?php if ($detailAction === 'list'): ?>
        <!-- Details List View -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Content Sections</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <?php echo count($details); ?> section<?php echo count($details) !== 1 ? 's' : ''; ?> available
                    </p>
                </div>
                <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $contentId; ?>&detail_action=add" 
                   class="flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ripple">
                    <i class="fas fa-plus mr-2"></i>Add Section
                </a>
            </div>
            
            <?php echo show_alert_message('success'); ?>
            <?php echo show_alert_message('error'); ?>
            
            <div class="p-6">
                <?php if (empty($details)): ?>
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full mb-6">
                            <i class="fas fa-list-ul text-4xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No sections yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">Start building your content by adding detailed sections</p>
                        <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $contentId; ?>&detail_action=add" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all ripple">
                            <i class="fas fa-plus mr-2"></i>Add First Section
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($details as $index => $detail): ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:border-blue-300 dark:hover:border-blue-700 transition-all hover:shadow-lg bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-800">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg font-bold text-sm mr-3">
                                                <?php echo $index + 1; ?>
                                            </span>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                                <?php echo escapeOutput($detail['title']); ?>
                                            </h4>
                                        </div>
                                        
                                        <?php if ($detail['description']): ?>
                                            <div class="text-gray-600 dark:text-gray-400 mb-4 prose prose-sm max-w-none line-clamp-3">
                                                <?php echo $detail['description']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="flex items-center space-x-4 text-sm">
                                            <?php if ($detail['video_link']): ?>
                                                <a href="<?php echo $detail['video_link']; ?>" target="_blank" 
                                                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                                    <i class="fas fa-video mr-2"></i>View Video
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ($detail['image']): ?>
                                                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                                    <i class="fas fa-image mr-2"></i>Has Image
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($detail['image']): ?>
                                            <div class="mt-4">
                                                <img src="<?php echo APP_URL; ?>/assets/<?php echo $content['type'] === 'blog' ? 'blog' : 'projects'; ?>/<?php echo $content['urlname']; ?>/<?php echo $detail['image']; ?>" 
                                                     alt="<?php echo escapeOutput($detail['title']); ?>" 
                                                     class="max-w-md h-auto rounded-lg shadow-md">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 ml-6">
                                        <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $contentId; ?>&detail_action=edit&detail_id=<?php echo $detail['id']; ?>" 
                                           class="w-9 h-9 flex items-center justify-center bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this section?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                                            <button type="submit" 
                                                    class="w-9 h-9 flex items-center justify-center bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition-all"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Add/Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo $pageTitle; ?></h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the section details below</p>
                </div>
                <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $contentId; ?>" 
                   class="flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200 ripple">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Sections
                </a>
            </div>
            
            <?php echo show_alert_message('error'); ?>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="<?php echo $detailAction; ?>">
                <?php if (isset($detail)): ?>
                    <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                <?php endif; ?>
                
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-heading mr-1"></i> Section Title
                    </label>
                    <input type="text" name="title" id="title" required 
                           value="<?php echo escapeOutput(isset($detail) ? $detail['title'] : ''); ?>"
                           class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                           placeholder="Enter section title">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-1"></i> Description
                    </label>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <i class="fas fa-info-circle mr-1"></i> Supports HTML tags: &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;u&gt;, &lt;br&gt;, &lt;a&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, etc.
                    </div>
                    <textarea name="description" id="description" rows="10" 
                              placeholder="Enter description with HTML tags if needed..."
                              class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm transition-all"><?php echo isset($detail) ? $detail['description'] : ''; ?></textarea>
                </div>
                
                <div>
                    <label for="video_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-video mr-1"></i> Video Link (Optional)
                    </label>
                    <input type="url" name="video_link" id="video_link" 
                           value="<?php echo escapeOutput(isset($detail) ? $detail['video_link'] : ''); ?>"
                           placeholder="https://youtube.com/..."
                           class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
                
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-image mr-1"></i> Section Image (Optional)
                    </label>
                    <input type="file" name="image" id="image" accept="image/*" 
                           onchange="previewImage(this, 'image-preview')"
                           class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                    <div id="image-preview" class="mt-3">
                        <?php if (isset($detail['image']) && $detail['image']): ?>
                            <div class="material-card bg-gray-50 dark:bg-gray-700 p-3 rounded-xl">
                                <img src="<?php echo APP_URL; ?>/assets/<?php echo $content['type'] === 'blog' ? 'blog' : 'projects'; ?>/<?php echo $content['urlname']; ?>/<?php echo $detail['image']; ?>" 
                                     alt="Current image" class="max-w-md h-auto rounded-lg">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo APP_URL; ?>/admin/content-details?id=<?php echo $contentId; ?>" 
                       class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-medium transition-all ripple">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all ripple">
                        <i class="fas fa-save mr-2"></i><?php echo $detailAction === 'add' ? 'Add Section' : 'Update Section'; ?>
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
