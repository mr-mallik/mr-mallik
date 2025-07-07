<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth();

$projectId = $_GET['id'] ?? null;
if (!$projectId) {
    redirect("/admin/blogs", "error", "Invalid project ID!");
}

// Get project details
$stmt = $CONN->prepare("SELECT * FROM blog WHERE project_id = ?");
$stmt->execute([$projectId]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    redirect("/admin/blogs", "error", "Project not found!");
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
        case 'edit':
            $id = $_POST['id'] ?? null;
            $title = sanitizeInput($_POST['title'] ?? '');
            $description = sanitizeInput($_POST['description'] ?? '');
            $videoLink = sanitizeInput($_POST['video_link'] ?? '');
            
            // Handle image upload
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_URL . '/assets/' . ($project['type'] === 'blog' ? 'stories' : 'projects');
                $uploadResult = handleFileUpload($_FILES['image'], $uploadDir);
                
                if (isset($uploadResult['success'])) {
                    $image = $uploadResult['filename'];
                } else {
                    redirect("/admin/blogs?action=details&id=$projectId", "error", $uploadResult['error']);
                }
            }
            
            try {
                if ($action === 'add') {
                    $sql = "INSERT INTO blog_det (project_id, title, description, video_link, image) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $CONN->prepare($sql);
                    $stmt->execute([$projectId, $title, $description, $videoLink, $image]);
                    redirect("/admin/blog-details?id=$projectId", "success", "Detail added successfully!");
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
                    redirect("/admin/blog-details?id=$projectId", "success", "Detail updated successfully!");
                }
            } catch (Exception $e) {
                redirect("/admin/blog-details?id=$projectId", "error", "Error: " . $e->getMessage());
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
                        $filePath = BASE_URL . '/assets/' . ($project['type'] === 'blog' ? 'stories' : 'projects') . '/' . $detail['image'];
                        deleteFile($filePath);
                    }
                    
                    redirect("/admin/blog-details?id=$projectId", "success", "Detail deleted successfully!");
                } catch (Exception $e) {
                    redirect("/admin/blog-details?id=$projectId", "error", "Error: " . $e->getMessage());
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
                redirect("/admin/blog-details?id=$projectId", "error", "Detail not found!");
            }
        } else {
            redirect("/admin/blog-details?id=$projectId", "error", "Invalid detail ID!");
        }
        break;
        
    default:
        $pageTitle = 'Project Details';
        
        // Get project details
        $stmt = $CONN->prepare("SELECT * FROM blog_det WHERE project_id = ? ORDER BY id ASC");
        $stmt->execute([$projectId]);
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;
}

require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>

<div class="space-y-6">
    <!-- Project Info Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo htmlspecialchars($project['title']); ?></h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2"><?php echo ucfirst($project['type']); ?> Details Management</p>
            </div>
            <a href="<?php echo APP_URL; ?>/admin/<?php echo $project['type'] === 'blog' ? 'blogs' : 'projects'; ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to <?php echo ucfirst($project['type']); ?>s
            </a>
        </div>
    </div>
    
    <?php if ($detailAction === 'list'): ?>
        <!-- Details List View -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Details</h3>
                <a href="<?php echo APP_URL; ?>/admin/blog-details?id=<?php echo $projectId; ?>&detail_action=add" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Add Detail
                </a>
            </div>
            
            <?php echo show_alert_message('success'); ?>
            <?php echo show_alert_message('error'); ?>
            
            <div class="p-6">
                <?php if (empty($details)): ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">No details available yet.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($details as $detail): ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                            <?php echo htmlspecialchars($detail['title']); ?>
                                        </h4>
                                        <?php if ($detail['description']): ?>
                                            <p class="text-gray-600 dark:text-gray-400 mb-3">
                                                <?php echo nl2br(htmlspecialchars($detail['description'])); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($detail['video_link']): ?>
                                            <p class="text-sm text-blue-600 dark:text-blue-400 mb-3">
                                                <i class="fas fa-video mr-1"></i>
                                                <a href="<?php echo $detail['video_link']; ?>" target="_blank" class="hover:underline">
                                                    View Video
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($detail['image']): ?>
                                            <div class="mb-3">
                                                <img src="<?php echo APP_URL; ?>/assets/<?php echo $project['type'] === 'blog' ? 'stories' : 'projects'; ?>/<?php echo $detail['image']; ?>" 
                                                     alt="<?php echo htmlspecialchars($detail['title']); ?>" 
                                                     class="max-w-xs h-auto rounded-lg shadow-md">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="<?php echo APP_URL; ?>/admin/blog-details?id=<?php echo $projectId; ?>&detail_action=edit&detail_id=<?php echo $detail['id']; ?>" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this detail?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white"><?php echo $pageTitle; ?></h3>
                <a href="<?php echo APP_URL; ?>/admin/blog-details?id=<?php echo $projectId; ?>" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Details
                </a>
            </div>
            
            <?php echo show_alert_message('error'); ?>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="action" value="<?php echo $detailAction; ?>">
                <?php if (isset($detail)): ?>
                    <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
                <?php endif; ?>
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" name="title" id="title" required 
                           value="<?php echo htmlspecialchars(isset($detail) ? $detail['title'] : ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="6" 
                              class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars(isset($detail) ? $detail['description'] : ''); ?></textarea>
                </div>
                
                <div>
                    <label for="video_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Video Link</label>
                    <input type="url" name="video_link" id="video_link" 
                           value="<?php echo htmlspecialchars(isset($detail) ? $detail['video_link'] : ''); ?>"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" 
                           onchange="previewImage(this, 'image-preview')"
                           class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <div id="image-preview" class="mt-2">
                        <?php if (isset($detail['image']) && $detail['image']): ?>
                            <img src="<?php echo APP_URL; ?>/assets/<?php echo $project['type'] === 'blog' ? 'stories' : 'projects'; ?>/<?php echo $detail['image']; ?>" 
                                 alt="Current image" class="max-w-full h-auto rounded-lg shadow-md">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="<?php echo APP_URL; ?>/admin/blog-details?id=<?php echo $projectId; ?>" 
                       class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <?php echo $detailAction === 'add' ? 'Add Detail' : 'Update Detail'; ?>
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../partials/admin/footer.php'; ?>
