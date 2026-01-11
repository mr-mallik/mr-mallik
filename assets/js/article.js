// Article Editor - Block Management and Form Handling

class ArticleEditor {
    constructor() {
        this.blocksContainer = document.getElementById('blocks-container');
        this.blockMenu = document.getElementById('block-menu');
        this.addBlockBtn = document.getElementById('add-block-btn');
        this.form = document.getElementById('article-form');
        this.titleInput = document.getElementById('title');
        this.slugInput = document.getElementById('slug');
        this.slugDisplay = document.getElementById('slug-display');
        this.copySlugBtn = document.getElementById('copy-slug-btn');
        this.coverImageInput = document.getElementById('cover_image');
        this.coverImageDropzone = document.getElementById('cover-image-dropzone');
        this.articleId = document.getElementById('article-id')?.value || null;
        this.publishedSelect = document.getElementById('published');
        this.authorsContainer = document.getElementById('authors-container');
        this.addAuthorBtn = document.getElementById('add-author-btn');
        this.seoTitleInput = document.getElementById('seo_title');
        this.formatToolbar = document.getElementById('format-toolbar');
        this.clearBlocksBtn = document.getElementById('clear-blocks-btn');
        this.blockModeBtn = document.getElementById('block-mode-btn');
        this.markdownModeBtn = document.getElementById('markdown-mode-btn');
        this.blocksContainer = document.getElementById('blocks-container');
        this.markdownContainer = document.getElementById('markdown-container');
        this.markdownEditor = document.getElementById('markdown-editor');
        
        this.blockCounter = 0;
        this.blocks = [];
        this.authorCounter = 0;
        this.authors = [];
        this.availableAuthors = [];
        this.insertAfterBlockId = null;
        this.currentMode = 'block'; // 'block' or 'markdown'
        
        this.init();
    }

    init() {
        // Fetch available authors from database
        // this.fetchAuthors();
        
        // Auto-generate slug from title
        this.titleInput.addEventListener('input', () => {
            this.autoGenerateSlug();
            this.autoGenerateSeoTitle();
        });
        
        // Copy slug functionality
        this.copySlugBtn.addEventListener('click', () => this.copySlug());
        
        // Cover image upload
        this.setupCoverImageUpload();
        
        // Published status change handler (only in edit mode)
        if (this.publishedSelect && this.publishedSelect.tagName === 'SELECT') {
            this.publishedSelect.addEventListener('change', () => this.handlePublishedChange());
        }
        
        // Toggle block menu
        this.addBlockBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.blockMenu.classList.toggle('hidden');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', () => {
            this.blockMenu.classList.add('hidden');
        });
        
        // Block type selection
        this.blockMenu.querySelectorAll('[data-block-type]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const blockType = btn.dataset.blockType;
                
                // Check if we're inserting after a specific block
                if (this.insertAfterBlockId) {
                    this.insertBlockAfter(this.insertAfterBlockId, blockType);
                    this.insertAfterBlockId = null;
                } else {
                    this.addBlock(blockType);
                }
                
                this.blockMenu.classList.add('hidden');
                this.blockMenu.style.position = '';
                this.blockMenu.style.top = '';
                this.blockMenu.style.left = '';
            });
        });
        
        // Add author button
        // this.addAuthorBtn.addEventListener('click', () => this.addAuthor());
        
        // Clear blocks button
        this.clearBlocksBtn?.addEventListener('click', () => this.clearAllBlocks());
        
        // Mode switching
        this.blockModeBtn?.addEventListener('click', () => this.switchToBlockMode());
        this.markdownModeBtn?.addEventListener('click', () => this.switchToMarkdownMode());
        
        // Setup formatting toolbar
        this.setupFormattingToolbar();
        
        // Listen for markdown import events
        window.addEventListener('markdown-import', (e) => this.handleMarkdownImport(e));
        
        // Form submission
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Load existing article if editing
        if (this.articleId) {
            this.loadArticle(this.articleId);
        }
        
        // Initialize slug display
        this.updateSlugDisplay();
    }

    autoGenerateSlug() {
        if (!this.slugInput.value || this.slugInput.dataset.autoGenerated === 'true') {
            const slug = this.titleInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            this.slugInput.value = slug;
            this.slugInput.dataset.autoGenerated = 'true';
            this.updateSlugDisplay();
        }
    }

    autoGenerateSeoTitle() {
        // Auto-generate SEO title if empty or matches previous title
        if (!this.seoTitleInput.value || this.seoTitleInput.dataset.autoGenerated === 'true') {
            this.seoTitleInput.value = this.titleInput.value;
            this.seoTitleInput.dataset.autoGenerated = 'true';
        }
    }

    // async fetchAuthors() {
    //     try {
    //         const response = await fetch('/api/v1/authors');
    //         const result = await response.json();
    //         if (response.ok && result.data) {
    //             this.availableAuthors = result.data;
    //         }
    //     } catch (error) {
    //         console.error('Error fetching authors:', error);
    //     }
    // }

    updateSlugDisplay() {
        const slug = this.slugInput.value || 'untitled';
        this.slugDisplay.textContent = `/${slug}`;
    }

    copySlug() {
        const slug = this.slugInput.value;
        const fullUrl = `${window.location.origin}/${slug}`;
        
        navigator.clipboard.writeText(fullUrl).then(() => {
            const originalHtml = this.copySlugBtn.innerHTML;
            this.copySlugBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            setTimeout(() => {
                this.copySlugBtn.innerHTML = originalHtml;
            }, 2000);
        });
    }

    setupCoverImageUpload() {
        const input = this.coverImageInput;
        const dropzone = this.coverImageDropzone;
        const preview = document.getElementById('cover-image-preview');
        const previewImg = document.getElementById('cover-image-preview-img');
        const placeholder = document.getElementById('cover-image-placeholder');
        const removeBtn = document.getElementById('remove-cover-image');
        
        // Click to upload
        dropzone.addEventListener('click', () => input.click());
        
        // File selection
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                this.displayImagePreview(file, previewImg, preview, placeholder);
            }
        });
        
        // Remove image
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            input.value = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            
            // Clear the hidden input as well
            const coverImageUrlInput = document.getElementById('cover_image_url');
            if (coverImageUrlInput) {
                coverImageUrlInput.value = '';
            }
        });
        
        // Drag and drop
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-blue-400', 'bg-blue-50');
        });
        
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
        });
        
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                input.files = e.dataTransfer.files;
                this.displayImagePreview(file, previewImg, preview, placeholder);
            }
        });
    }

    displayImagePreview(file, imgElement, previewDiv, placeholderDiv) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const base64Data = e.target.result;
            imgElement.src = base64Data;
            previewDiv.classList.remove('hidden');
            placeholderDiv.classList.add('hidden');
            
            // Store the base64 data in the hidden input for submission
            const coverImageUrlInput = document.getElementById('cover_image_url');
            if (coverImageUrlInput) {
                coverImageUrlInput.value = base64Data;
            }
        };
        reader.readAsDataURL(file);
    }

    setupFormattingToolbar() {
        // Handle text selection to show/hide toolbar
        document.addEventListener('mouseup', () => this.handleTextSelection());
        document.addEventListener('keyup', () => this.handleTextSelection());
        
        // Handle toolbar buttons
        this.formatToolbar.querySelectorAll('.format-btn').forEach(btn => {
            btn.addEventListener('mousedown', (e) => {
                e.preventDefault(); // Prevent losing selection
                const format = btn.dataset.format;
                this.applyFormat(format);
            });
        });
        
        // Handle keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                if (e.key === 'b') {
                    e.preventDefault();
                    this.applyFormat('bold');
                } else if (e.key === 'i') {
                    e.preventDefault();
                    this.applyFormat('italic');
                } else if (e.key === 'u') {
                    e.preventDefault();
                    this.applyFormat('underline');
                }
            }
        });
    }

    handleTextSelection() {
        const selection = window.getSelection();
        const selectedText = selection.toString().trim();
        
        // Check if selection is within a paragraph block
        if (selectedText && selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const paragraphBlock = container.nodeType === 3 
                ? container.parentElement.closest('.paragraph-content')
                : container.closest('.paragraph-content');
            
            if (paragraphBlock) {
                this.showFormattingToolbar(range);
                return;
            }
        }
        
        this.hideFormattingToolbar();
    }

    showFormattingToolbar(range) {
        const rect = range.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        
        this.formatToolbar.style.top = `${rect.top + scrollTop - 45}px`;
        this.formatToolbar.style.left = `${rect.left + scrollLeft + (rect.width / 2) - 100}px`;
        this.formatToolbar.classList.add('show');
        
        // Update button states
        this.updateToolbarStates();
    }

    hideFormattingToolbar() {
        this.formatToolbar.classList.remove('show');
    }

    updateToolbarStates() {
        const formats = ['bold', 'italic', 'underline'];
        formats.forEach(format => {
            const btn = this.formatToolbar.querySelector(`[data-format="${format}"]`);
            if (btn) {
                btn.classList.toggle('active', document.queryCommandState(format));
            }
        });
    }

    applyFormat(format) {
        const selection = window.getSelection();
        if (!selection.rangeCount) return;
        
        switch(format) {
            case 'bold':
                document.execCommand('bold', false, null);
                break;
            case 'italic':
                document.execCommand('italic', false, null);
                break;
            case 'underline':
                document.execCommand('underline', false, null);
                break;
            case 'code':
                this.wrapSelection('code');
                break;
            case 'insertUnorderedList':
                document.execCommand('insertUnorderedList', false, null);
                break;
            case 'insertOrderedList':
                document.execCommand('insertOrderedList', false, null);
                break;
            case 'indent':
                document.execCommand('indent', false, null);
                break;
            case 'outdent':
                document.execCommand('outdent', false, null);
                break;
            case 'link':
                const url = prompt('Enter URL:');
                if (url) {
                    document.execCommand('createLink', false, url);
                }
                break;
        }
        
        this.updateToolbarStates();
    }

    wrapSelection(tag) {
        const selection = window.getSelection();
        if (!selection.rangeCount) return;
        
        const range = selection.getRangeAt(0);
        const selectedText = range.toString();
        
        if (!selectedText) return;
        
        const wrapper = document.createElement(tag);
        wrapper.textContent = selectedText;
        
        range.deleteContents();
        range.insertNode(wrapper);
        
        // Clear selection
        selection.removeAllRanges();
    }

    handleMarkdownImport(event) {
        const blocks = event.detail.blocks;
        
        if (!blocks || blocks.length === 0) {
            alert('No content to import.');
            return;
        }

        // Clear existing blocks if any (optional - can be modified to append instead)
        const shouldReplace = this.blocks.length > 0 
            ? confirm(`This will replace ${this.blocks.length} existing block(s). Continue?`)
            : true;

        if (!shouldReplace) return;

        // Clear existing blocks
        this.blocks.forEach(block => block.element.remove());
        this.blocks = [];

        // Add imported blocks
        blocks.forEach(blockData => {
            this.addBlock(blockData.type, blockData);
        });

        alert(`Successfully imported ${blocks.length} block(s) from markdown.`);
    }

    async clearAllBlocks() {
        if (this.blocks.length === 0) {
            alert('No blocks to clear.');
            return;
        }

        const confirmed = confirm(`Are you sure you want to clear all ${this.blocks.length} block(s)? This action cannot be undone.`);
        
        if (!confirmed) return;

        try {
            // Clear on server if article exists
            if (this.articleId) {
                const response = await fetch(`/api/v1/articles/${this.articleId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        blocks: []
                    })
                });

                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.message || 'Failed to clear blocks on server');
                }
            }

            // Clear blocks from DOM
            this.blocks.forEach(block => block.element.remove());
            this.blocks = [];

            alert('All blocks cleared successfully.');
            
        } catch (error) {
            console.error('Error clearing blocks:', error);
            alert('Failed to clear blocks: ' + error.message);
        }
    }

    handlePublishedChange() {
        const isPublished = this.publishedSelect.value === 'true';
        
        if (isPublished && this.articleId) {
            // When changing to published in edit mode, update via API immediately
            const confirmed = confirm('Are you sure you want to publish this article? It will be visible to the public.');
            
            if (confirmed) {
                this.updatePublishStatus(true);
            } else {
                // Revert the dropdown
                this.publishedSelect.value = 'false';
            }
        } else if (!isPublished && this.articleId) {
            // When unpublishing
            const confirmed = confirm('Are you sure you want to unpublish this article? It will no longer be visible to the public.');
            
            if (confirmed) {
                this.updatePublishStatus(false);
            } else {
                // Revert the dropdown
                this.publishedSelect.value = 'true';
            }
        }
    }

    async updatePublishStatus(published) {
        try {
            const response = await fetch(`/api/v1/articles/${this.articleId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    published: published,
                    published_at: published ? new Date().toISOString() : null
                })
            });
            
            const result = await response.json();
            
            if (response.ok) {
                const status = published ? 'published' : 'unpublished';
                alert(`Article ${status} successfully!`);
            } else {
                alert('Error: ' + (result.message || 'Failed to update publish status'));
                // Revert the dropdown on error
                this.publishedSelect.value = published ? 'false' : 'true';
            }
        } catch (error) {
            console.error('Error updating publish status:', error);
            alert('An error occurred while updating the publish status.');
            // Revert the dropdown on error
            this.publishedSelect.value = published ? 'false' : 'true';
        }
    }

    addBlock(blockType, data = {}) {
        const blockId = `block-${this.blockCounter++}`;
        const blockOrder = this.blocks.length;
        
        const blockElement = this.createBlockElement(blockId, blockType, blockOrder, data);
        this.blocksContainer.appendChild(blockElement);
        
        this.blocks.push({
            id: blockId,
            type: blockType,
            order: blockOrder,
            element: blockElement
        });
        
        // Focus on the new block's input
        const input = blockElement.querySelector('input, textarea, [contenteditable="true"]');
        if (input) input.focus();
    }

    createBlockElement(blockId, blockType, blockOrder, data = {}) {
        const div = document.createElement('div');
        div.className = 'block-item';
        div.dataset.blockId = blockId;
        div.dataset.blockType = blockType;
        div.dataset.blockOrder = blockOrder;

        const typeLabel = this.getBlockTypeLabel(blockType);
        
        let inputHtml = '';
        
        switch(blockType) {
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
                inputHtml = `<input type="text" class="block-content w-full px-0 py-2 border-0 focus:outline-none ${this.getHeadingClass(blockType)} placeholder-gray-300" placeholder="${typeLabel}" value="${data.content || ''}">`;
                break;
            case 'paragraph':
                inputHtml = `<div class="block-content paragraph-content w-full px-0 py-2 border-0 focus:outline-none text-lg leading-relaxed" contenteditable="true" data-placeholder="Tell your story...">${data.content || ''}</div>`;
                break;
            case 'image':
                const imageId = `block-image-${blockId}`;
                inputHtml = `
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer" data-image-dropzone>
                        <input type="file" class="block-image-file hidden" accept="image/*" data-image-input="${imageId}">
                        <div class="block-image-preview hidden" data-image-preview="${imageId}">
                            <img class="block-image-preview-img max-h-96 mx-auto rounded-lg" src="" alt="Block image">
                        </div>
                        <div class="block-image-placeholder" data-image-placeholder="${imageId}">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Click to upload image</p>
                        </div>
                    </div>
                    <input type="text" class="block-caption w-full px-0 py-2 mt-2 border-0 focus:outline-none text-sm text-center text-gray-600 placeholder-gray-300" placeholder="Add a caption (optional)" value="${data.caption || ''}">
                    <input type="hidden" class="block-media-url" value="${data.media_url || ''}">
                `;
                break;
            case 'video':
                inputHtml = `
                    <input type="url" class="block-media-url w-full px-0 py-3 border-0 border-b border-gray-200 focus:outline-none focus:border-blue-500 placeholder-gray-400" placeholder="Video URL (YouTube, Vimeo, etc.)" value="${data.media_url || ''}">
                    <input type="text" class="block-caption w-full px-0 py-2 mt-2 border-0 focus:outline-none text-sm text-center text-gray-600 placeholder-gray-300" placeholder="Add a caption (optional)" value="${data.caption || ''}">
                `;
                break;
            case 'code':
                inputHtml = `
                    <input type="text" class="block-language w-full px-0 py-2 border-0 border-b border-gray-200 focus:outline-none focus:border-blue-500 mb-2 text-sm placeholder-gray-400" placeholder="Language (e.g., javascript, python)" value="${data.language || ''}">
                    <textarea class="block-content w-full px-4 py-3 mt-2 border-0 bg-gray-50 rounded-lg focus:outline-none font-mono text-sm leading-relaxed placeholder-gray-400 resize-none" rows="8" placeholder="// Enter your code here">${data.content || ''}</textarea>
                `;
                break;
        }

        div.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <span class="block-type-label text-xs font-medium text-gray-400 uppercase tracking-wide">${typeLabel}</span>
                <div class="block-controls flex gap-3">
                    <button type="button" class="move-up-btn text-gray-400 hover:text-gray-600 transition-colors" title="Move up">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                    </button>
                    <button type="button" class="move-down-btn text-gray-400 hover:text-gray-600 transition-colors" title="Move down">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <button type="button" class="delete-btn text-red-400 hover:text-red-600 transition-colors" title="Delete">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            <button type="button" class="add-block-floating" title="Add block after this">+</button>
            ${inputHtml}
        `;

        // Attach event listeners
        div.querySelector('.delete-btn').addEventListener('click', () => this.deleteBlock(blockId));
        div.querySelector('.move-up-btn').addEventListener('click', () => this.moveBlock(blockId, -1));
        div.querySelector('.move-down-btn').addEventListener('click', () => this.moveBlock(blockId, 1));
        div.querySelector('.add-block-floating').addEventListener('click', (e) => {
            e.stopPropagation();
            this.showBlockMenuForInsertion(blockId);
        });

        // Setup image upload for image blocks
        if (blockType === 'image') {
            this.setupBlockImageUpload(div, blockId);
            
            // If there's existing image data, display it
            if (data.media_url) {
                const preview = div.querySelector(`[data-image-preview="block-image-${blockId}"]`);
                const previewImg = div.querySelector('.block-image-preview-img');
                const placeholder = div.querySelector(`[data-image-placeholder="block-image-${blockId}"]`);
                
                if (preview && previewImg && placeholder) {
                    previewImg.src = data.media_url;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
            }
        }

        return div;
    }

    showBlockMenuForInsertion(afterBlockId) {
        // Store the target block ID
        this.insertAfterBlockId = afterBlockId;
        
        // Show the menu near the clicked button
        const blockElement = this.blocks.find(b => b.id === afterBlockId)?.element;
        if (!blockElement) return;
        
        const floatingBtn = blockElement.querySelector('.add-block-floating');
        const rect = floatingBtn.getBoundingClientRect();
        
        // Position and show menu
        this.blockMenu.style.position = 'fixed';
        this.blockMenu.style.top = `${rect.bottom + 5}px`;
        this.blockMenu.style.left = `${rect.left - 150}px`;
        this.blockMenu.classList.remove('hidden');
        
        // Prevent menu from closing immediately
        setTimeout(() => {
            document.addEventListener('click', this.handleMenuClick, { once: true });
        }, 10);
    }

    insertBlockAfter(afterBlockId, blockType, data = {}) {
        const afterIndex = this.blocks.findIndex(b => b.id === afterBlockId);
        if (afterIndex === -1) {
            // Fallback to appending
            this.addBlock(blockType, data);
            return;
        }
        
        const blockId = `block-${this.blockCounter++}`;
        const blockElement = this.createBlockElement(blockId, blockType, 0, data);
        
        // Insert after the target block
        const afterElement = this.blocks[afterIndex].element;
        afterElement.insertAdjacentElement('afterend', blockElement);
        
        // Insert into blocks array
        this.blocks.splice(afterIndex + 1, 0, {
            id: blockId,
            type: blockType,
            order: 0,
            element: blockElement
        });
        
        // Reorder all blocks
        this.reorderBlocks();
        
        // Focus on the new block's input
        const input = blockElement.querySelector('input, textarea, [contenteditable="true"]');
        if (input) input.focus();
    }

    setupBlockImageUpload(blockElement, blockId) {
        const dropzone = blockElement.querySelector('[data-image-dropzone]');
        const input = blockElement.querySelector('.block-image-file');
        const preview = blockElement.querySelector(`[data-image-preview="block-image-${blockId}"]`);
        const previewImg = blockElement.querySelector('.block-image-preview-img');
        const placeholder = blockElement.querySelector(`[data-image-placeholder="block-image-${blockId}"]`);
        const mediaUrlInput = blockElement.querySelector('.block-media-url');
        
        // Click to upload
        dropzone.addEventListener('click', (e) => {
            if (e.target.tagName !== 'INPUT') {
                input.click();
            }
        });
        
        // File selection
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const base64Data = event.target.result;
                    previewImg.src = base64Data;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    
                    // Store the base64 data in the hidden input for submission
                    if (mediaUrlInput) {
                        mediaUrlInput.value = base64Data;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Drag and drop
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-blue-400', 'bg-blue-50');
        });
        
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
        });
        
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-400', 'bg-blue-50');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                input.files = e.dataTransfer.files;
                const reader = new FileReader();
                reader.onload = (event) => {
                    const base64Data = event.target.result;
                    previewImg.src = base64Data;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    
                    // Store the base64 data in the hidden input for submission
                    if (mediaUrlInput) {
                        mediaUrlInput.value = base64Data;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    getBlockTypeLabel(blockType) {
        const labels = {
            h1: 'Heading 1',
            h2: 'Heading 2',
            h3: 'Heading 3',
            h4: 'Heading 4',
            paragraph: 'Paragraph',
            image: 'Image',
            video: 'Video',
            code: 'Code Block'
        };
        return labels[blockType] || blockType;
    }

    getHeadingClass(blockType) {
        const classes = {
            h1: 'text-4xl font-bold leading-tight',
            h2: 'text-3xl font-bold leading-tight',
            h3: 'text-2xl font-semibold leading-snug',
            h4: 'text-xl font-semibold leading-snug'
        };
        return classes[blockType] || '';
    }

    // Author Management Methods
    addAuthor(data = {}) {
        const authorId = `author-${this.authorCounter++}`;
        const position = this.authors.length + 1;
        
        const authorElement = this.createAuthorElement(authorId, position, data);
        this.authorsContainer.appendChild(authorElement);
        
        this.authors.push({
            id: authorId,
            position: position,
            element: authorElement
        });
    }

    createAuthorElement(authorId, position, data = {}) {
        const div = document.createElement('div');
        div.className = 'author-item border border-gray-200 rounded-lg p-3';
        div.dataset.authorId = authorId;
        div.dataset.position = position;

        // Build options for author select
        let authorOptions = '<option value="">Select an author</option>';
        this.availableAuthors.forEach(author => {
            const selected = (data.author_id && data.author_id === author.id) ? 'selected' : '';
            authorOptions += `<option value="${author.id}" ${selected}>${author.name}</option>`;
        });

        div.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs font-medium text-gray-500">Author #${position}</span>
                <button type="button" class="remove-author-btn text-red-400 hover:text-red-600 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-2">
                <select 
                    class="author-select w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    ${authorOptions}
                </select>
                <select 
                    class="author-role w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="author" ${!data.role || data.role === 'author' ? 'selected' : ''}>Author</option>
                    <option value="co_author" ${data.role === 'co_author' ? 'selected' : ''}>Co-Author</option>
                </select>
            </div>
        `;

        // Attach remove listener
        div.querySelector('.remove-author-btn').addEventListener('click', () => this.removeAuthor(authorId));

        return div;
    }

    removeAuthor(authorId) {
        const authorIndex = this.authors.findIndex(a => a.id === authorId);
        if (authorIndex !== -1) {
            this.authors[authorIndex].element.remove();
            this.authors.splice(authorIndex, 1);
            this.reorderAuthors();
        }
    }

    reorderAuthors() {
        this.authors.forEach((author, index) => {
            author.position = index + 1;
            author.element.dataset.position = index + 1;
            const posLabel = author.element.querySelector('.text-xs');
            if (posLabel) {
                posLabel.textContent = `Author #${index + 1}`;
            }
        });
    }

    collectAuthorsData() {
        const authorsData = [];
        
        this.authors.forEach((author, index) => {
            const element = author.element;
            const authorSelect = element.querySelector('.author-select');
            const roleSelect = element.querySelector('.author-role');
            
            if (authorSelect && authorSelect.value) {
                authorsData.push({
                    author_id: parseInt(authorSelect.value),
                    role: roleSelect.value,
                    position: index + 1
                });
            }
        });
        
        return authorsData;
    }


    deleteBlock(blockId) {
        const blockIndex = this.blocks.findIndex(b => b.id === blockId);
        if (blockIndex !== -1) {
            this.blocks[blockIndex].element.remove();
            this.blocks.splice(blockIndex, 1);
            this.reorderBlocks();
        }
    }

    moveBlock(blockId, direction) {
        const blockIndex = this.blocks.findIndex(b => b.id === blockId);
        const newIndex = blockIndex + direction;
        
        if (newIndex >= 0 && newIndex < this.blocks.length) {
            // Swap blocks
            [this.blocks[blockIndex], this.blocks[newIndex]] = [this.blocks[newIndex], this.blocks[blockIndex]];
            this.reorderBlocks();
        }
    }

    reorderBlocks() {
        this.blocksContainer.innerHTML = '';
        this.blocks.forEach((block, index) => {
            block.order = index;
            block.element.dataset.blockOrder = index;
            this.blocksContainer.appendChild(block.element);
        });
    }

    collectBlockData() {
        // If in markdown mode, convert markdown to blocks first
        if (this.currentMode === 'markdown') {
            const markdown = this.markdownEditor.value.trim();
            if (markdown) {
                // Temporarily switch to block mode to get the data
                this.convertMarkdownToBlocks(markdown);
            }
        }
        
        const blockData = [];
        
        this.blocks.forEach((block, index) => {
            const element = block.element;
            const blockType = element.dataset.blockType;
            
            let data = {
                block_type: blockType,
                block_order: index
            };
            
            const contentInput = element.querySelector('.block-content');
            const mediaUrlInput = element.querySelector('.block-media-url');
            const captionInput = element.querySelector('.block-caption');
            const languageInput = element.querySelector('.block-language');
            
            if (contentInput) {
                // For paragraph blocks with contenteditable, get innerHTML to preserve formatting
                if (blockType === 'paragraph' && contentInput.hasAttribute('contenteditable')) {
                    data.content = contentInput.innerHTML.trim();
                } else {
                    data.content = contentInput.value;
                }
            }
            if (mediaUrlInput) {
                data.media_url = mediaUrlInput.value;
            }
            if (captionInput) {
                data.caption = captionInput.value;
            }
            if (languageInput) {
                data.language = languageInput.value;
            }
            
            blockData.push(data);
        });
        
        return blockData;
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(this.form);
        
        // Get type and published from their elements (they're outside the form)
        const typeSelect = document.getElementById('type');
        const publishedSelect = document.getElementById('published');
        
        const articleData = {
            title: formData.get('title'),
            slug: formData.get('slug'),
            type: typeSelect ? typeSelect.value : 'blog',
            excerpt: formData.get('excerpt') || null,
            cover_image_url: formData.get('cover_image_url') || null,
            seo_title: formData.get('seo_title') || null,
            seo_description: formData.get('seo_description') || null,
            seo_keywords: formData.get('seo_keywords') || null,
            published: publishedSelect ? (publishedSelect.value === 'true') : false,
            blocks: this.collectBlockData(),
            authors: this.collectAuthorsData()
        };
        
        try {
            let response;
            if (this.articleId) {
                // Update existing article
                response = await fetch(`/api/v1/articles/${this.articleId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(articleData)
                });
            } else {
                // Create new article
                response = await fetch('/api/v1/articles', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(articleData)
                });
            }
            
            const result = await response.json();
            
            if (response.ok) {
                alert(this.articleId ? 'Article updated successfully!' : 'Article created successfully!');
                window.location.href = '/admin/articles';
            } else {
                alert('Error: ' + (result.message || 'Failed to save article'));
            }
        } catch (error) {
            console.error('Error saving article:', error);
            alert('An error occurred while saving the article.');
        }
    }

    async loadArticle(articleId) {
        try {
            const response = await fetch(`/api/v1/articles/${articleId}`);
            const result = await response.json();
            
            if (response.ok && result.data) {
                const article = result.data;
                
                console.log('Loading article:', article);
                
                // Load blocks
                if (article.blocks && article.blocks.length > 0) {
                    article.blocks
                        .sort((a, b) => a.block_order - b.block_order)
                        .forEach(block => {
                            console.log('Loading block:', block.block_type, 'media_url:', block.media_url);
                            this.addBlock(block.block_type, block);
                        });
                }
                
                // Load authors
                if (article.authors && article.authors.length > 0) {
                    article.authors
                        .sort((a, b) => (a.pivot?.position || 1) - (b.pivot?.position || 1))
                        .forEach(author => {
                            this.addAuthor({
                                author_id: author.id,
                                role: author.pivot?.role || 'author'
                            });
                        });
                }
                
                // Load cover image
                if (article.cover_image_url) {
                    const coverImageUrlInput = document.getElementById('cover_image_url');
                    const coverImagePreview = document.getElementById('cover-image-preview');
                    const coverImagePreviewImg = document.getElementById('cover-image-preview-img');
                    const coverImagePlaceholder = document.getElementById('cover-image-placeholder');
                    
                    if (coverImageUrlInput && coverImagePreview && coverImagePreviewImg) {
                        coverImageUrlInput.value = article.cover_image_url;
                        coverImagePreviewImg.src = article.cover_image_url;
                        coverImagePreview.classList.remove('hidden');
                        coverImagePlaceholder.classList.add('hidden');
                    }
                }
            } else {
                console.error('Failed to load article:', result.message);
            }
        } catch (error) {
            console.error('Error loading article:', error);
        }
    }
    
    switchToMarkdownMode() {
        if (this.currentMode === 'markdown') return;
        
        // Convert blocks to markdown
        const markdown = this.convertBlocksToMarkdown();
        this.markdownEditor.value = markdown;
        
        // Switch UI
        this.blocksContainer.classList.add('hidden');
        this.markdownContainer.classList.remove('hidden');
        this.blockModeBtn.classList.remove('active');
        this.markdownModeBtn.classList.add('active');
        
        this.currentMode = 'markdown';
    }
    
    switchToBlockMode() {
        if (this.currentMode === 'block') return;
        
        // Convert markdown back to blocks
        const markdown = this.markdownEditor.value.trim();
        if (markdown) {
            this.convertMarkdownToBlocks(markdown);
        }
        
        // Switch UI
        this.markdownContainer.classList.add('hidden');
        this.blocksContainer.classList.remove('hidden');
        this.markdownModeBtn.classList.remove('active');
        this.blockModeBtn.classList.add('active');
        
        this.currentMode = 'block';
    }
    
    convertBlocksToMarkdown() {
        let markdown = '';
        
        this.blocks.forEach(block => {
            const blockElement = document.querySelector(`[data-block-id="${block.id}"]`);
            if (!blockElement) return;
            
            const type = block.type;
            const content = blockElement.querySelector('.paragraph-content, .block-input, textarea, input[type="text"]');
            
            switch(type) {
                case 'h2':
                    markdown += `## ${content?.value || content?.textContent || ''}\n\n`;
                    break;
                case 'h3':
                    markdown += `### ${content?.value || content?.textContent || ''}\n\n`;
                    break;
                case 'h4':
                    markdown += `#### ${content?.value || content?.textContent || ''}\n\n`;
                    break;
                case 'paragraph':
                    if (content) {
                        // Get HTML content and convert to markdown
                        const html = content.innerHTML;
                        const paragraphMarkdown = this.htmlToMarkdown(html);
                        markdown += `${paragraphMarkdown}\n\n`;
                    }
                    break;
                case 'code':
                    const language = blockElement.querySelector('.code-language')?.value || '';
                    const codeContent = blockElement.querySelector('textarea')?.value || '';
                    markdown += `\`\`\`${language}\n${codeContent}\n\`\`\`\n\n`;
                    break;
                case 'image':
                    const imageUrl = blockElement.querySelector('input[placeholder*="URL"]')?.value || '';
                    const imageCaption = blockElement.querySelector('input[placeholder*="Caption"]')?.value || '';
                    if (imageUrl) {
                        markdown += `![${imageCaption}](${imageUrl})\n\n`;
                    }
                    break;
                case 'video':
                    const videoUrl = blockElement.querySelector('input[placeholder*="URL"]')?.value || '';
                    const videoCaption = blockElement.querySelector('input[placeholder*="Caption"]')?.value || '';
                    if (videoUrl) {
                        markdown += `[Video: ${videoCaption || 'Video'}](${videoUrl})\n\n`;
                    }
                    break;
            }
        });
        
        return markdown.trim();
    }
    
    htmlToMarkdown(html) {
        let text = html;
        
        // Convert lists
        text = text.replace(/<ul[^>]*>/gi, '\n');
        text = text.replace(/<\/ul>/gi, '\n');
        text = text.replace(/<ol[^>]*>/gi, '\n');
        text = text.replace(/<\/ol>/gi, '\n');
        text = text.replace(/<li[^>]*>/gi, '- ');
        text = text.replace(/<\/li>/gi, '\n');
        
        // Convert formatting
        text = text.replace(/<b[^>]*>(.*?)<\/b>/gi, '**$1**');
        text = text.replace(/<strong[^>]*>(.*?)<\/strong>/gi, '**$1**');
        text = text.replace(/<i[^>]*>(.*?)<\/i>/gi, '*$1*');
        text = text.replace(/<em[^>]*>(.*?)<\/em>/gi, '*$1*');
        text = text.replace(/<u[^>]*>(.*?)<\/u>/gi, '<u>$1</u>');
        text = text.replace(/<code[^>]*>(.*?)<\/code>/gi, '`$1`');
        text = text.replace(/<a[^>]*href=["']([^"']*)["'][^>]*>(.*?)<\/a>/gi, '[$2]($1)');
        
        // Remove other HTML tags
        text = text.replace(/<br\s*\/?>/gi, '\n');
        text = text.replace(/<[^>]+>/g, '');
        
        // Clean up
        text = text.replace(/&nbsp;/g, ' ');
        text = text.replace(/&lt;/g, '<');
        text = text.replace(/&gt;/g, '>');
        text = text.replace(/&amp;/g, '&');
        
        return text.trim();
    }
    
    convertMarkdownToBlocks(markdown) {
        // Clear existing blocks
        this.blocks = [];
        this.blocksContainer.innerHTML = '';
        this.blockCounter = 0;
        
        // Use the existing markdown parser logic
        const lines = markdown.split('\n');
        let i = 0;
        
        while (i < lines.length) {
            const line = lines[i];
            
            // Skip empty lines
            if (!line.trim()) {
                i++;
                continue;
            }
            
            // Check for code block
            if (line.startsWith('```')) {
                const language = line.substring(3).trim();
                let code = '';
                i++;
                while (i < lines.length && !lines[i].startsWith('```')) {
                    code += lines[i] + '\n';
                    i++;
                }
                this.addBlock('code', { content: code.trim(), language });
                i++;
                continue;
            }
            
            // Check for headings
            if (line.startsWith('#### ')) {
                this.addBlock('h4', { content: line.substring(5) });
                i++;
                continue;
            }
            if (line.startsWith('### ')) {
                this.addBlock('h3', { content: line.substring(4) });
                i++;
                continue;
            }
            if (line.startsWith('## ')) {
                this.addBlock('h2', { content: line.substring(3) });
                i++;
                continue;
            }
            
            // Check for images
            const imageMatch = line.match(/^!\[([^\]]*)\]\(([^\)]+)\)/);
            if (imageMatch) {
                this.addBlock('image', {
                    media_url: imageMatch[2],
                    caption: imageMatch[1]
                });
                i++;
                continue;
            }
            
            // Paragraph - collect consecutive lines
            let paragraph = '';
            while (i < lines.length && lines[i].trim() && 
                   !lines[i].startsWith('#') && 
                   !lines[i].startsWith('```') && 
                   !lines[i].match(/^!\[/)) {
                paragraph += lines[i] + ' ';
                i++;
            }
            
            if (paragraph.trim()) {
                // Convert markdown formatting to HTML
                let html = paragraph.trim();
                html = html.replace(/\*\*(.+?)\*\*/g, '<b>$1</b>');
                html = html.replace(/\*(.+?)\*/g, '<i>$1</i>');
                html = html.replace(/`(.+?)`/g, '<code>$1</code>');
                html = html.replace(/\[(.+?)\]\((.+?)\)/g, '<a href="$2">$1</a>');
                
                this.addBlock('paragraph', { content: html });
            }
        }
    }
}

// Initialize editor when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ArticleEditor();
    });
} else {
    new ArticleEditor();
}