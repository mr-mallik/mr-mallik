<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $title = isset($article) ? 'Edit Article' : 'Create New Article';
    include __DIR__ . '/../partials/meta.php'; 
    ?>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <?php include __DIR__ . '/../partials/header.php'; ?>

    <main class="max-w-7xl mx-auto px-5 py-8">
        
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <a href="/admin/articles" class="text-blue-600 hover:text-blue-800 text-sm font-medium">&larr; Back to Articles</a>
            
            <div class="flex gap-3 items-center">
                <!-- Slug with Copy Button -->
                <div class="flex items-center gap-2">
                    <div id="slug-display" class="slug-display"></div>
                    <button type="button" id="copy-slug-btn" class="btn btn-sm btn-secondary" title="Copy URL">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Article Type -->
                <select 
                    id="type" 
                    name="type" 
                    required
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >
                    <option value="blog" <?= isset($article) && $article->type === 'blog' ? 'selected' : '' ?>>Blog</option>
                    <option value="case_study" <?= isset($article) && $article->type === 'case_study' ? 'selected' : '' ?>>Case Study</option>
                </select>
                
                <!-- Published Status - Only show in edit mode -->
                <?php if (isset($isEditMode) && $isEditMode): ?>
                <select 
                    id="published" 
                    name="published" 
                    required
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >
                    <option value="false" <?= !isset($article) || !$article->published ? 'selected' : '' ?>>Draft</option>
                    <option value="true" <?= isset($article) && $article->published ? 'selected' : '' ?>>Published</option>
                </select>
                <?php else: ?>
                <input type="hidden" id="published" name="published" value="false">
                <span class="px-3 py-2 bg-gray-100 rounded-lg text-sm text-gray-600">Draft</span>
                <?php endif; ?>
            </div>
        </div>

        <form id="article-form" enctype="multipart/form-data">
            <div class="grid grid-cols-12 gap-6">
                <!-- Left Column - Article Content -->
                <div class="col-span-8">
                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <input type="hidden" id="article-id" value="<?= isset($article) ? $article->id : '' ?>">
                        <input type="hidden" id="slug" name="slug" value="<?= isset($article) ? htmlspecialchars($article->slug) : '' ?>">
                        
                        <!-- Title -->
                        <div class="mb-8">
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                required
                                class="w-full px-0 py-3 border-0 focus:outline-none text-4xl font-bold placeholder-gray-300"
                                placeholder="Article Title"
                                value="<?= isset($article) ? htmlspecialchars($article->title) : '' ?>"
                            >
                        </div>

                        <!-- Excerpt -->
                        <div class="mb-8">
                            <textarea 
                                id="excerpt" 
                                name="excerpt" 
                                rows="3"
                                class="w-full px-0 py-3 border-0 focus:outline-none text-lg placeholder-gray-400 resize-none"
                                placeholder="Write a brief excerpt..."
                            ><?= isset($article) ? htmlspecialchars($article->excerpt ?? '') : '' ?></textarea>
                        </div>

                        <!-- Content Blocks -->
                        <div class="border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Content</h3>
                                    <div class="mode-switch">
                                        <button type="button" id="block-mode-btn" class="active">📝 Block Mode</button>
                                        <button type="button" id="markdown-mode-btn">📄 Markdown Mode</button>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" id="clear-blocks-btn" class="btn btn-sm btn-secondary text-red-600 hover:text-red-800">
                                        🗑️ Clear All
                                    </button>
                                    <button type="button" id="import-markdown-btn" class="btn btn-sm btn-secondary">
                                        📄 Import Markdown
                                    </button>
                                    <div class="relative">
                                        <button type="button" id="add-block-btn" class="btn btn-sm">
                                            + Add Block
                                        </button>
                                    <div id="block-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-t-lg" data-block-type="h2">Heading 2</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50" data-block-type="h3">Heading 3</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50" data-block-type="h4">Heading 4</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50" data-block-type="paragraph">Paragraph</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50" data-block-type="image">Image</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50" data-block-type="video">Video</button>
                                        <button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-b-lg" data-block-type="code">Code Block</button>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div id="blocks-container" class="">
                                <!-- Blocks will be inserted here dynamically -->
                            </div>
                            
                            <div id="markdown-container" class="hidden">
                                <textarea id="markdown-editor" class="markdown-editor" placeholder="Write your article in markdown format..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Metadata -->
                <div class="col-span-4 space-y-8">
                    <!-- Authors Section -->
                    <div class="bg-white p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Authors</h3>
                            <button type="button" id="add-author-btn" class="btn btn-sm">
                                + Add
                            </button>
                        </div>
                        
                        <div id="authors-container" class="space-y-3">
                            <!-- Authors will be inserted here dynamically -->
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div class="bg-white p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cover Image</h3>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer" id="cover-image-dropzone">
                            <input 
                                type="file" 
                                id="cover_image" 
                                name="cover_image" 
                                accept="image/*"
                                class="hidden"
                            >
                            <div id="cover-image-preview" class="hidden">
                                <img id="cover-image-preview-img" src="" alt="Cover preview" class="max-h-48 mx-auto rounded-lg">
                                <button type="button" id="remove-cover-image" class="mt-2 text-xs text-red-600 hover:text-red-800">Remove</button>
                            </div>
                            <div id="cover-image-placeholder">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-2 text-xs text-gray-600">Upload image</p>
                            </div>
                        </div>
                        <input type="hidden" id="cover_image_url" name="cover_image_url" value="<?= isset($article) ? htmlspecialchars($article->cover_image_url ?? '') : '' ?>">
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO Settings</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="seo_title" class="block text-xs font-medium text-gray-700 mb-1">SEO Title</label>
                                <input 
                                    type="text" 
                                    id="seo_title" 
                                    name="seo_title" 
                                    maxlength="255"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    placeholder="SEO optimized title"
                                    value="<?= isset($article) ? htmlspecialchars($article->seo_title ?? '') : '' ?>"
                                >
                            </div>

                            <div>
                                <label for="seo_description" class="block text-xs font-medium text-gray-700 mb-1">SEO Description</label>
                                <textarea 
                                    id="seo_description" 
                                    name="seo_description" 
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-none"
                                    placeholder="Meta description"
                                ><?= isset($article) ? htmlspecialchars($article->seo_description ?? '') : '' ?></textarea>
                            </div>

                            <div>
                                <label for="seo_keywords" class="block text-xs font-medium text-gray-700 mb-1">SEO Keywords</label>
                                <input 
                                    type="text" 
                                    id="seo_keywords" 
                                    name="seo_keywords" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    placeholder="keyword1, keyword2, keyword3"
                                    value="<?= isset($article) ? htmlspecialchars($article->seo_keywords ?? '') : '' ?>"
                                >
                                <p class="text-xs text-gray-500 mt-1">Comma-separated keywords</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-6">
                <button type="submit" class="btn">Save Article</button>
                <?php if (isset($article) && $article->id): ?>
                <a href="/admin/articles/preview/<?= $article->id ?>" target="_blank" class="btn btn-secondary">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview
                </a>
                <?php endif; ?>
                <a href="/admin/articles" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </main>

    <!-- Markdown Import Modal -->
    <div id="markdown-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Import Markdown Content</h3>
                    <button type="button" id="close-markdown-modal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Markdown File</label>
                    <input type="file" id="markdown-file-input" accept=".md,.markdown,.txt" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div class="mb-4">
                    <div class="flex items-center justify-center my-4">
                        <div class="border-t border-gray-300 flex-grow"></div>
                        <span class="px-4 text-sm text-gray-500">OR</span>
                        <div class="border-t border-gray-300 flex-grow"></div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Paste Markdown Text</label>
                    <textarea id="markdown-text-input" rows="12" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-mono" placeholder="Paste your markdown content here..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancel-markdown-import" class="btn btn-secondary">Cancel</button>
                    <button type="button" id="import-markdown-confirm" class="btn">Import Content</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Formatting Toolbar -->
    <div id="format-toolbar" class="format-toolbar">
        <button type="button" class="format-btn" data-format="bold" title="Bold (Ctrl+B)"><b>B</b></button>
        <button type="button" class="format-btn" data-format="italic" title="Italic (Ctrl+I)"><i>I</i></button>
        <button type="button" class="format-btn" data-format="underline" title="Underline (Ctrl+U)"><u>U</u></button>
        <button type="button" class="format-btn" data-format="code" title="Monospace"><code>{'</>'}</code></button>
        <button type="button" class="format-btn" data-format="insertUnorderedList" title="Bullet List">• List</button>
        <button type="button" class="format-btn" data-format="insertOrderedList" title="Numbered List">1. List</button>
        <button type="button" class="format-btn" data-format="indent" title="Indent (Tab)">→</button>
        <button type="button" class="format-btn" data-format="outdent" title="Outdent (Shift+Tab)">←</button>
        <button type="button" class="format-btn" data-format="link" title="Hyperlink">🔗</button>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>
    <script src="<?= getenv('APP_URL') ?: 'http://localhost' ?>/js/import-markdown.js"></script>
    <script src="<?= getenv('APP_URL') ?: 'http://localhost' ?>/js/article.js"></script>
</body>
</html>