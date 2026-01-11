<?php
require_once __DIR__ . '/../../../includes/admin-common.php';
checkAdminAuth();

$dispUrl = APP_URL . '/admin/article/article-list';
$editUrl = APP_URL . '/admin/article/article-edit';

// Get article ID if editing
$articleId = $_GET['id'] ?? null;
$article = null;
$isEditMode = false;

if ($articleId) {
    $stmt = $CONN->prepare("SELECT * FROM blog WHERE blog_id = ?");
    $stmt->execute([$articleId]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$article) {
        redirect($dispUrl, "error", "Article not found!");
    }
    
    $isEditMode = true;
    
    // Get article blocks/details
    $stmt = $CONN->prepare("SELECT * FROM blog_det WHERE blog_id = ? ORDER BY position ASC");
    $stmt->execute([$articleId]);
    $articleBlocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


require_once __DIR__ . '/../../../partials/admin/header.php';
require_once __DIR__ . '/../../../partials/admin/side-nav.php';
?>

<style>
/* Article Editor Styles */
.slug-display {
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    border-radius: 0.5rem;
    font-family: monospace;
    font-size: 0.875rem;
    color: #374151;
}

.dark .slug-display {
    background: #374151;
    color: #e5e7eb;
}

.block-container {
    position: relative;
    padding: 1rem;
    border: 2px solid transparent;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.block-container:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}

.dark .block-container:hover {
    background: #1e3a8a;
}

.block-controls {
    position: absolute;
    right: 0.5rem;
    top: 0.5rem;
    display: flex;
    gap: 0.25rem;
    opacity: 0;
    transition: opacity 0.2s;
}

.block-container:hover .block-controls {
    opacity: 1;
}

.block-menu {
    position: absolute;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 50;
    min-width: 200px;
}

.dark .block-menu {
    background: #1f2937;
    border-color: #374151;
}

.block-menu-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.block-menu-item:hover {
    background: #f3f4f6;
}

.dark .block-menu-item:hover {
    background: #374151;
}

.format-toolbar {
    position: fixed;
    background: #1f2937;
    border-radius: 0.5rem;
    padding: 0.5rem;
    display: none;
    gap: 0.25rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.format-toolbar.show {
    display: flex;
}

.format-btn {
    padding: 0.5rem;
    background: transparent;
    color: white;
    border: none;
    border-radius: 0.25rem;
    cursor: pointer;
    font-size: 0.875rem;
    transition: background 0.2s;
}

.format-btn:hover {
    background: #374151;
}

.format-btn.active {
    background: #3b82f6;
}

.image-preview-container {
    position: relative;
    display: inline-block;
}

.image-preview-container img {
    max-width: 100%;
    border-radius: 0.5rem;
}

.remove-image-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 2rem;
    height: 2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.author-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f9fafb;
    border-radius: 0.5rem;
}

.dark .author-item {
    background: #374151;
}

.ripple {
    position: relative;
    overflow: hidden;
}

.ripple::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.ripple:active::after {
    width: 300px;
    height: 300px;
}
</style>

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                <?php echo $isEditMode ? 'Edit Article' : 'Create New Article'; ?>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                <?php echo $isEditMode ? 'Update your article content and settings' : 'Write a new article for your audience'; ?>
            </p>
        </div>
        
        <div class="flex gap-3 items-center">
            <!-- Slug Display -->
            <div class="flex items-center gap-2">
                <div id="slug-display" class="slug-display"></div>
                <button type="button" id="copy-slug-btn" 
                        class="w-9 h-9 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-all"
                        title="Copy URL">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            
            <a href="<?php echo $dispUrl; ?>" 
               class="flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-all ripple">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <form id="article-form" enctype="multipart/form-data">
        <input type="hidden" id="article-id" value="<?php echo $articleId ?? ''; ?>">
        
        <div class="grid grid-cols-12 gap-6">
            <!-- Left Column - Article Content -->
            <div class="col-span-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-heading mr-1"></i> Article Title
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            required
                            class="block w-full px-4 py-3 text-2xl font-bold bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Enter your article title..."
                            value="<?php echo isset($article) ? escapeOutput($article['title']) : ''; ?>"
                        >
                    </div>

                    <!-- Slug -->
                    <div class="hidden">
                        <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-link mr-1"></i> URL Slug
                        </label>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            required
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm transition-all"
                            placeholder="article-url-slug"
                            value="<?php echo isset($article) ? escapeOutput($article['urlname']) : ''; ?>"
                        >
                    </div>

                    <!-- Excerpt/Short Description -->
                    <div>
                        <label for="short_description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-align-left mr-1"></i> Excerpt
                        </label>
                        <textarea 
                            id="short_description" 
                            name="short_description" 
                            rows="3"
                            class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Write a brief excerpt..."
                        ><?php echo isset($article) ? $article['short_description'] : ''; ?></textarea>
                    </div>

                    <!-- Content Blocks -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="fas fa-th-large mr-2"></i>Content Blocks
                            </h3>
                            <div class="flex gap-2">
                                <button type="button" id="import-markdown-btn" 
                                        class="px-4 py-2 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-all text-sm font-medium">
                                    <i class="fas fa-file-import mr-2"></i>Import Markdown
                                </button>
                                <button type="button" id="clear-blocks-btn" 
                                        class="px-4 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition-all text-sm font-medium">
                                    <i class="fas fa-trash mr-2"></i>Clear All
                                </button>
                                <div class="relative">
                                    <button type="button" id="add-block-btn" 
                                            class="px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all text-sm font-medium">
                                        <i class="fas fa-plus mr-2"></i>Add Block
                                    </button>
                                    <div id="block-menu" class="block-menu hidden">
                                        <div class="block-menu-item" data-block-type="paragraph">
                                            <i class="fas fa-paragraph"></i>
                                            <span>Paragraph</span>
                                        </div>
                                        <div class="block-menu-item" data-block-type="h2">
                                            <i class="fas fa-heading"></i>
                                            <span>Heading 2</span>
                                        </div>
                                        <div class="block-menu-item" data-block-type="h3">
                                            <i class="fas fa-heading"></i>
                                            <span>Heading 3</span>
                                        </div>
                                        <div class="block-menu-item" data-block-type="h4">
                                            <i class="fas fa-heading"></i>
                                            <span>Heading 4</span>
                                        </div>
                                        <div class="block-menu-item" data-block-type="code">
                                            <i class="fas fa-code"></i>
                                            <span>Code Block</span>
                                        </div>
                                        <div class="block-menu-item" data-block-type="image">
                                            <i class="fas fa-image"></i>
                                            <span>Image</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="blocks-container" class="space-y-4 min-h-[200px]">
                            <!-- Blocks will be inserted here dynamically -->
                            <?php if (empty($articleBlocks)): ?>
                            <div class="text-center py-12 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-cube text-4xl mb-3"></i>
                                <p>No content blocks yet. Click "Add Block" to start writing.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Metadata -->
            <div class="col-span-4 space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-blue-600 dark:text-blue-400"></i>
                        </div>
                        Settings
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-tag mr-1"></i> Content Type
                            </label>
                            <select id="type" name="type" required 
                                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="blog" <?php echo (isset($article) && $article['type'] === 'blog') ? 'selected' : ''; ?>>Blog</option>
                                <option value="project" <?php echo (isset($article) && $article['type'] === 'project') ? 'selected' : ''; ?>>Project</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-toggle-on mr-1"></i> Status
                            </label>
                            <select id="status" name="status" required 
                                    class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="D" <?php echo (!isset($article) || $article['status'] === 'D') ? 'selected' : ''; ?>>Draft</option>
                                <option value="A" <?php echo (isset($article) && $article['status'] === 'A') ? 'selected' : ''; ?>>Published</option>
                            </select>
                        </div>

                        <div>
                            <label for="published_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-calendar mr-1"></i> Published Date
                            </label>
                            <input type="date" id="published_date" name="published_date" 
                                   value="<?php echo isset($article) ? $article['published_date'] : date('Y-m-d'); ?>"
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="skills" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-code mr-1"></i> Skills (comma-separated)
                            </label>
                            <input type="text" id="skills" name="skills" 
                                   value="<?php echo isset($article) ? escapeOutput($article['skills']) : ''; ?>"
                                   placeholder="e.g., 1,2,3"
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-image text-green-600 dark:text-green-400"></i>
                        </div>
                        Cover Image
                    </h3>
                    
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors cursor-pointer" 
                         id="cover-image-dropzone">
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" class="hidden">
                        
                        <div id="cover-image-preview" class="<?php echo isset($article['image']) && $article['image'] ? '' : 'hidden'; ?>">
                            <div class="image-preview-container">
                                <img id="cover-image-preview-img" 
                                     src="<?php echo isset($article['image']) ? url($article['image'], false) : ''; ?>" 
                                     alt="Cover" 
                                     class="max-h-48 mx-auto">
                                <button type="button" id="remove-cover-image" class="remove-image-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div id="cover-image-placeholder" class="<?php echo isset($article['image']) && $article['image'] ? 'hidden' : ''; ?>">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                    <input type="hidden" id="cover_image_url" name="cover_image_url" value="<?php echo isset($article['image']) ? $article['image'] : ''; ?>">
                </div>

                <!-- Banner Image -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-panorama text-purple-600 dark:text-purple-400"></i>
                        </div>
                        Banner Image
                    </h3>
                    
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-purple-400 dark:hover:border-purple-500 transition-colors cursor-pointer" 
                         id="banner-image-dropzone">
                        <input type="file" id="banner_image" name="banner_image" accept="image/*" class="hidden">
                        
                        <div id="banner-image-preview" class="<?php echo isset($article['banner_image']) && $article['banner_image'] ? '' : 'hidden'; ?>">
                            <div class="image-preview-container">
                                <img id="banner-image-preview-img" 
                                     src="<?php echo isset($article['banner_image']) ? url($article['banner_image'], false) : ''; ?>" 
                                     alt="Banner" 
                                     class="max-h-48 mx-auto">
                                <button type="button" id="remove-banner-image" class="remove-image-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div id="banner-image-placeholder" class="<?php echo isset($article['banner_image']) && $article['banner_image'] ? 'hidden' : ''; ?>">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                        </div>
                    </div>
                    <input type="hidden" id="banner_image_url" name="banner_image_url" value="<?php echo isset($article['banner_image']) ? $article['banner_image'] : ''; ?>">
                </div>

                <!-- Links -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-link text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        Project Links
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="github" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fab fa-github mr-1"></i> GitHub URL
                            </label>
                            <input type="url" id="github" name="github" 
                                   value="<?php echo isset($article) ? escapeOutput($article['github']) : ''; ?>"
                                   placeholder="https://github.com/..."
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="online" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-globe mr-1"></i> Live URL
                            </label>
                            <input type="url" id="online" name="online" 
                                   value="<?php echo isset($article) ? escapeOutput($article['online']) : ''; ?>"
                                   placeholder="https://..."
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="user_guide" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-book mr-1"></i> User Guide URL
                            </label>
                            <input type="url" id="user_guide" name="user_guide" 
                                   value="<?php echo isset($article) ? escapeOutput($article['user_guide']) : ''; ?>"
                                   placeholder="https://..."
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        SEO Settings
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="seo_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                SEO Title
                            </label>
                            <input type="text" id="seo_title" name="seo_title" 
                                   value="<?php echo isset($article) ? escapeOutput($article['seo_title']) : ''; ?>"
                                   placeholder="SEO optimized title"
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="seo_keyword" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Keywords
                            </label>
                            <input type="text" id="seo_keyword" name="seo_keyword" 
                                   value="<?php echo isset($article) ? escapeOutput($article['seo_keyword']) : ''; ?>"
                                   placeholder="keyword1, keyword2, keyword3"
                                   class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="seo_desc" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Meta Description
                            </label>
                            <textarea id="seo_desc" name="seo_desc" rows="3"
                                      placeholder="Brief description for search engines"
                                      class="block w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            ><?php echo isset($article) ? escapeOutput($article['seo_desc']) : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4 mt-6">
            <a href="<?php echo $dispUrl; ?>" 
               class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-medium transition-all ripple">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all ripple">
                <i class="fas fa-save mr-2"></i><?php echo $isEditMode ? 'Update Article' : 'Create Article'; ?>
            </button>
        </div>
    </form>
</div>

<!-- Markdown Import Modal -->
<div id="markdown-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Import Markdown Content</h3>
                <button type="button" id="close-markdown-modal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Markdown File</label>
                <input type="file" id="markdown-file-input" accept=".md,.markdown,.txt" 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div class="mb-4">
                <div class="flex items-center justify-center my-4">
                    <div class="border-t border-gray-300 dark:border-gray-600 flex-grow"></div>
                    <span class="px-4 text-sm text-gray-500 dark:text-gray-400">OR</span>
                    <div class="border-t border-gray-300 dark:border-gray-600 flex-grow"></div>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Paste Markdown Text</label>
                <textarea id="markdown-text-input" rows="12" 
                          class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-mono" 
                          placeholder="Paste your markdown content here..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" id="cancel-markdown-import" 
                        class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-all">
                    Cancel
                </button>
                <button type="button" id="import-markdown-confirm" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                    Import Content
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formatting Toolbar -->
<div id="format-toolbar" class="format-toolbar">
    <button type="button" class="format-btn" data-format="bold" title="Bold (Ctrl+B)"><b>B</b></button>
    <button type="button" class="format-btn" data-format="italic" title="Italic (Ctrl+I)"><i>I</i></button>
    <button type="button" class="format-btn" data-format="underline" title="Underline (Ctrl+U)"><u>U</u></button>
    <button type="button" class="format-btn" data-format="code" title="Monospace"><code>&lt;/&gt;</code></button>
    <button type="button" class="format-btn" data-format="insertUnorderedList" title="Bullet List">• List</button>
    <button type="button" class="format-btn" data-format="insertOrderedList" title="Numbered List">1. List</button>
    <button type="button" class="format-btn" data-format="link" title="Hyperlink">🔗</button>
</div>

<script>
// Pass existing article data to JavaScript
<?php if ($isEditMode && !empty($articleBlocks)): ?>
window.existingArticleBlocks = <?php echo json_encode($articleBlocks); ?>;
<?php else: ?>
window.existingArticleBlocks = [];
<?php endif; ?>

window.APP_URL = '<?php echo APP_URL; ?>';
window.ARTICLE_ID = '<?php echo $articleId ?? ''; ?>';
</script>

<script src="<?php url('assets/js/import-markdown.js'); ?>"></script>
<script src="<?php url('assets/js/article.js'); ?>"></script>

<?php require_once __DIR__ . '/../../../partials/admin/footer.php'; ?>
