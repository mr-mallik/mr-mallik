// Markdown Import Handler
class MarkdownImporter {
    constructor() {
        this.modal = document.getElementById('markdown-modal');
        this.importBtn = document.getElementById('import-markdown-btn');
        this.closeBtn = document.getElementById('close-markdown-modal');
        this.cancelBtn = document.getElementById('cancel-markdown-import');
        this.confirmBtn = document.getElementById('import-markdown-confirm');
        this.fileInput = document.getElementById('markdown-file-input');
        this.textInput = document.getElementById('markdown-text-input');
        
        this.init();
    }

    init() {
        // Open modal
        this.importBtn?.addEventListener('click', () => this.openModal());
        
        // Close modal
        this.closeBtn?.addEventListener('click', () => this.closeModal());
        this.cancelBtn?.addEventListener('click', () => this.closeModal());
        this.modal?.addEventListener('click', (e) => {
            if (e.target === this.modal) this.closeModal();
        });
        
        // Handle file upload
        this.fileInput?.addEventListener('change', (e) => this.handleFileUpload(e));
        
        // Handle import
        this.confirmBtn?.addEventListener('click', () => this.handleImport());
    }

    openModal() {
        this.modal?.classList.remove('hidden');
        this.textInput.value = '';
        this.fileInput.value = '';
    }

    closeModal() {
        this.modal?.classList.add('hidden');
    }

    async handleFileUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        try {
            const text = await file.text();
            this.textInput.value = text;
        } catch (error) {
            console.error('Error reading file:', error);
            alert('Failed to read file. Please try again.');
        }
    }

    handleImport() {
        const markdownText = this.textInput.value.trim();
        
        if (!markdownText) {
            alert('Please upload a file or paste markdown content.');
            return;
        }

        try {
            const blocks = this.parseMarkdown(markdownText);
            
            // Dispatch custom event with parsed blocks
            window.dispatchEvent(new CustomEvent('markdown-import', {
                detail: { blocks }
            }));
            
            this.closeModal();
        } catch (error) {
            console.error('Error parsing markdown:', error);
            alert('Failed to parse markdown. Please check the format and try again.');
        }
    }

    parseMarkdown(markdown) {
        const blocks = [];
        const lines = markdown.split('\n');
        let i = 0;

        while (i < lines.length) {
            const line = lines[i];
            
            // Skip empty lines
            if (!line.trim()) {
                i++;
                continue;
            }

            // Skip horizontal rules (---)
            if (line.trim().match(/^-{3,}$/)) {
                i++;
                continue;
            }

            // Code blocks (```)
            if (line.trim().startsWith('```')) {
                const codeBlock = this.parseCodeBlock(lines, i);
                if (codeBlock) {
                    blocks.push(codeBlock.block);
                    i = codeBlock.nextIndex;
                    continue;
                }
            }

            // Headings
            if (line.startsWith('#')) {
                const heading = this.parseHeading(line);
                if (heading) {
                    blocks.push(heading);
                    i++;
                    continue;
                }
            }

            // Images
            if (line.trim().startsWith('![')) {
                const image = this.parseImage(line);
                if (image) {
                    blocks.push(image);
                    i++;
                    continue;
                }
            }

            // Lists (bullets and numbered)
            if (this.isListItem(line)) {
                const list = this.parseList(lines, i);
                if (list) {
                    blocks.push(list.block);
                    i = list.nextIndex;
                    continue;
                }
            }

            // Regular paragraph - collect consecutive lines
            const paragraph = this.parseParagraph(lines, i);
            if (paragraph) {
                blocks.push(paragraph.block);
                i = paragraph.nextIndex;
                continue;
            }

            i++;
        }

        return blocks;
    }

    parseHeading(line) {
        const match = line.match(/^(#{1,4})\s+(.+)$/);
        if (!match) return null;

        const level = match[1].length;
        let content = match[2].trim();
        
        // Strip bold markdown from headings (** or __) since headings are already bold
        content = content.replace(/\*\*(.+?)\*\*/g, '$1');
        content = content.replace(/__(.+?)__/g, '$1');
        
        // Parse remaining inline formatting
        content = this.parseInlineFormatting(content);

        return {
            type: `h${Math.min(level + 1, 4)}`, // h1 -> h2, h2 -> h3, h3 -> h4, h4 -> h4
            content: content
        };
    }

    parseCodeBlock(lines, startIndex) {
        const firstLine = lines[startIndex].trim();
        const languageMatch = firstLine.match(/^```(\w+)?$/);
        
        if (!languageMatch) return null;

        const language = languageMatch[1] || '';
        const codeLines = [];
        let i = startIndex + 1;

        // Collect code lines until closing ```
        while (i < lines.length && !lines[i].trim().startsWith('```')) {
            codeLines.push(lines[i]);
            i++;
        }

        return {
            block: {
                type: 'code',
                content: codeLines.join('\n'),
                language: language
            },
            nextIndex: i + 1
        };
    }

    parseImage(line) {
        const match = line.match(/!\[([^\]]*)\]\(([^)]+)\)/);
        if (!match) return null;

        return {
            type: 'image',
            media_url: match[2],
            caption: match[1] || ''
        };
    }

    isListItem(line) {
        // Check for unordered list (- or *)
        if (line.trim().match(/^[-*]\s+/)) return true;
        // Check for ordered list (1., 2., etc.)
        if (line.trim().match(/^\d+\.\s+/)) return true;
        // Check for indented list items (sub-bullets)
        if (line.match(/^\s+([-*]|\d+\.)\s+/)) return true;
        return false;
    }

    parseList(lines, startIndex) {
        const listItems = [];
        let i = startIndex;
        let listType = null; // 'ul' or 'ol'

        // Determine list type from first item
        const firstLine = lines[i].trim();
        if (firstLine.match(/^[-*]\s+/)) {
            listType = 'ul';
        } else if (firstLine.match(/^\d+\.\s+/)) {
            listType = 'ol';
        }

        // Collect all consecutive list items
        while (i < lines.length) {
            const line = lines[i];
            
            // Stop at empty lines
            if (!line.trim()) break;
            
            // Stop at non-list items
            if (!this.isListItem(line)) break;

            // Parse the list item
            const indent = line.match(/^(\s*)/)[1].length;
            const content = line.trim().replace(/^([-*]|\d+\.)\s+/, '');
            const formattedContent = this.parseInlineFormatting(content);
            
            listItems.push({
                content: formattedContent,
                indent: indent
            });

            i++;
        }

        if (listItems.length === 0) return null;

        // Build nested HTML structure
        const html = this.buildNestedList(listItems, listType);

        return {
            block: {
                type: 'paragraph',
                content: html
            },
            nextIndex: i
        };
    }

    buildNestedList(items, defaultType) {
        if (items.length === 0) return '';

        let html = '';
        let currentIndent = 0;
        const stack = []; // Stack to keep track of open tags
        
        // Determine the type of list based on first item's marker
        let currentType = defaultType || 'ul';
        html += `<${currentType}>`;
        stack.push(currentType);

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const nextIndent = item.indent;

            if (nextIndent > currentIndent) {
                // Start nested list
                const nestType = defaultType || 'ul';
                html += `<${nestType}>`;
                stack.push(nestType);
                currentIndent = nextIndent;
            } else if (nextIndent < currentIndent) {
                // Close nested lists
                while (currentIndent > nextIndent && stack.length > 1) {
                    const closingTag = stack.pop();
                    html += `</li></${closingTag}>`;
                    currentIndent -= 2; // Assume 2-space indentation
                }
                html += '</li>';
            } else if (i > 0) {
                // Same level, close previous item
                html += '</li>';
            }

            html += `<li>${item.content}`;
        }

        // Close remaining open tags
        html += '</li>';
        while (stack.length > 0) {
            const closingTag = stack.pop();
            html += `</${closingTag}>`;
        }

        return html;
    }

    parseParagraph(lines, startIndex) {
        const paragraphLines = [];
        let i = startIndex;

        // Collect consecutive non-empty lines that aren't special blocks
        while (i < lines.length) {
            const line = lines[i];
            
            // Stop at empty lines
            if (!line.trim()) break;
            
            // Stop at headings
            if (line.startsWith('#')) break;
            
            // Stop at code blocks
            if (line.trim().startsWith('```')) break;
            
            // Stop at images
            if (line.trim().startsWith('![')) break;

            // Stop at list items
            if (this.isListItem(line)) break;

            paragraphLines.push(line);
            i++;
        }

        if (paragraphLines.length === 0) return null;

        const content = this.parseInlineFormatting(paragraphLines.join(' '));

        return {
            block: {
                type: 'paragraph',
                content: content
            },
            nextIndex: i
        };
    }

    parseInlineFormatting(text) {
        let html = text;

        // Escape HTML first
        html = html
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Bold (**text** or __text__) - only if not already stripped
        html = html.replace(/\*\*(.+?)\*\*/g, '<b>$1</b>');
        html = html.replace(/__(.+?)__/g, '<b>$1</b>');

        // Italic (*text* or _text_) - be careful not to match bold markers
        html = html.replace(/(?<!\*)\*(?!\*)(.+?)\*(?!\*)/g, '<i>$1</i>');
        html = html.replace(/(?<!_)_(?!_)(.+?)_(?!_)/g, '<i>$1</i>');

        // Inline code (`code`)
        html = html.replace(/`(.+?)`/g, '<code>$1</code>');

        // Links [text](url)
        html = html.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2">$1</a>');

        return html;
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new MarkdownImporter();
    });
} else {
    new MarkdownImporter();
}
