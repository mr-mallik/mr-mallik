<?php
require_once __DIR__ . '/../includes/common.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : null;
$type = isset($_GET['type']) ? trim($_GET['type']) : null;

if (!$slug || !$type) {
    header('Location: ' . url('404', false));
    exit;
}

$article = cmsoneArticleGet($slug);

if (!$article) {
    header('Location: ' . url('404', false));
    exit;
}

$listingPage = $type === 'project' ? 'projects' : 'blogs';
$seoTitle    = !empty($article['seo']['metaTitle'])       ? $article['seo']['metaTitle']       : $article['title'];
$seoDesc     = !empty($article['seo']['metaDescription']) ? $article['seo']['metaDescription'] : ($article['excerpt'] ?? '');
$seoKeywords = implode(', ', array_column($article['tags'] ?? [], 'name'));
$page_url    = url($listingPage . '/' . $article['slug'], false);

// Estimate read time from content
$wordCount = str_word_count(strip_tags($article['content'] ?? $article['excerpt'] ?? ''));
$readTime  = max(1, ceil($wordCount / 200));

$SEO = [
    'title'       => htmlspecialchars($seoTitle) . ' | Gulger Mallik | Mr Mallik',
    'description' => htmlspecialchars($seoDesc),
    'keywords'    => $seoKeywords ?: 'gulger mallik, mr mallik, software engineer, fullstack developer',
    'image'       => !empty($article['featuredImage']) ? $article['featuredImage'] : url('assets/images/og-image.png', false),
    'image_alt'   => htmlspecialchars($article['title']),
    'url'         => $page_url,
];

require_once __DIR__ . '/../partials/header.php';

?>

<style>
/* Gallery masonry layout */
#galleryGrid {
    column-count: 1;
    column-gap: 1rem;
}
@media (min-width: 640px) {
    #galleryGrid { column-count: 2; column-gap: 1.5rem; }
}
@media (min-width: 1024px) {
    #galleryGrid { column-count: 3; column-gap: 1.5rem; }
}
.gallery-item {
    break-inside: avoid;
    margin-bottom: 1rem;
    display: inline-block;
    width: 100%;
}
@media (min-width: 640px) {
    .gallery-item { margin-bottom: 1.5rem; }
}
.gallery-item img { width: 100%; height: auto; display: block; }

/* Lightbox */
#lightboxModal { backdrop-filter: blur(4px); transition: opacity 0.3s ease-in-out; }
#lightboxImage { transition: opacity 0.3s ease-in-out; max-width: 90vw; max-height: 90vh; }
.animate-spin { animation: spin 1s linear infinite; }
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

#prevImage, #nextImage, #closeLightbox {
    background: rgba(0,0,0,0.5);
    border-radius: 50%;
    width: 50px; height: 50px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.3s ease;
}
#prevImage:hover, #nextImage:hover, #closeLightbox:hover {
    background: rgba(0,0,0,0.8);
    transform: scale(1.1);
}
@media (max-width: 640px) {
    #prevImage, #nextImage, #closeLightbox { width: 44px; height: 44px; }
    #lightboxImage { max-width: 95vw; max-height: 85vh; }
}

/* Article prose overrides */
.prose-content > *:first-child { margin-top: 0 !important; }
</style>

<article class="min-h-screen">

    <!-- Hero Banner -->
    <section class="relative w-full h-56 sm:h-72 md:h-96 lg:h-[400px] overflow-hidden">
        <img src="<?= htmlspecialchars($article['featuredImage'] ?? '') ?>"
             alt="<?= htmlspecialchars($article['title']) ?>"
             class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 pb-6 sm:pb-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Back link inside hero -->
                <a href="<?= url($listingPage, false) ?>"
                   class="inline-flex items-center text-xs sm:text-sm text-white/80 hover:text-white mb-3 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to <?= $type === 'project' ? 'Projects' : 'Stories' ?>
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight drop-shadow-lg">
                    <?= htmlspecialchars($article['title']) ?>
                </h1>
            </div>
        </div>
    </section>

    <!-- Article body -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 bg-white dark:bg-transparent rounded-xl shadow-sm">

        <!-- Meta bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700 gap-4">
            <div class="flex items-center gap-3">
                <img src="<?= url('assets/images/gulger-mallik@1x1.jpg', false) ?>"
                     alt="Gulger Mallik"
                     class="w-11 h-11 rounded-full object-cover shrink-0">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base leading-tight">Gulger Mallik</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Software Engineer &amp; AI Researcher</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                <?php if (!empty($article['publishedAt'])): ?>
                <span class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt"></i>
                    <time datetime="<?= date('Y-m-d', strtotime($article['publishedAt'])) ?>">
                        <?= date('M j, Y', strtotime($article['publishedAt'])) ?>
                    </time>
                </span>
                <?php endif; ?>

                <span class="flex items-center gap-1.5" title="Read count">
                    <i class="far fa-eye"></i>
                    <?= number_format($article['readCount'] ?? 0) ?>
                    <?= ($article['readCount'] ?? 0) === 1 ? 'read' : 'reads' ?>
                </span>

                <span class="flex items-center gap-1.5" title="Estimated read time">
                    <i class="far fa-clock"></i>
                    <?= $readTime ?> min read
                </span>

                <?php if (!empty($article['likeCount'])): ?>
                <span class="flex items-center gap-1.5">
                    <i class="far fa-heart"></i>
                    <?= number_format($article['likeCount']) ?>
                </span>
                <?php endif; ?>

                <button id="shareButton"
                        class="flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        title="Share">
                    <i class="fas fa-share-alt"></i> Share
                </button>
            </div>
        </div>

        <!-- Categories & Tags -->
        <?php
        $categories = $article['categories'] ?? [];
        $tags       = $article['tags']       ?? [];
        if (!empty($categories) || !empty($tags)): ?>
        <div class="flex flex-wrap gap-2 mb-8">
            <?php foreach ($categories as $cat): ?>
            <a href="<?= url($listingPage . '?category=' . urlencode($cat['slug']), false) ?>"
               class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800/40 transition-colors">
                <i class="fas fa-folder-open text-xs"></i>
                <?= htmlspecialchars($cat['name']) ?>
            </a>
            <?php endforeach; ?>
            <?php foreach ($tags as $tag): ?>
            <a href="<?= url($listingPage . '?tag=' . urlencode($tag['slug']), false) ?>"
               class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-tag text-xs"></i>
                <?= htmlspecialchars($tag['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Addon Links -->
        <?php
        $addonLinks = $article['addonLinks'] ?? [];
        usort($addonLinks, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));
        $addonLinks = array_filter($addonLinks, fn($l) => !empty($l['url']));
        $addonMeta = [
            'demo'    => ['icon' => 'fas fa-external-link-alt', 'label' => 'Live Demo',        'class' => 'bg-blue-600 hover:bg-blue-700 text-white'],
            'github'  => ['icon' => 'fab fa-github',            'label' => 'View on GitHub',   'class' => 'bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white'],
            'article' => ['icon' => 'fas fa-newspaper',         'label' => 'Read Article',     'class' => 'bg-purple-600 hover:bg-purple-700 text-white'],
            'custom'  => ['icon' => 'fas fa-link',              'label' => 'Visit Link',       'class' => 'bg-gray-600 hover:bg-gray-700 text-white'],
        ];
        if (!empty($addonLinks)): ?>
        <div class="flex flex-wrap gap-3 mb-8">
            <?php foreach ($addonLinks as $link):
                $meta  = $addonMeta[$link['type']] ?? $addonMeta['custom'];
                $label = !empty($link['label']) ? htmlspecialchars($link['label']) : $meta['label'];
            ?>
            <a href="<?= htmlspecialchars($link['url']) ?>"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 <?= $meta['class'] ?>">
                <i class="<?= $meta['icon'] ?>"></i>
                <?= $label ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Excerpt / lede -->
        <?php if (!empty($article['excerpt'])): ?>
        <p class="text-lg sm:text-xl text-gray-700 dark:text-gray-400 leading-relaxed mb-8 pl-4 border-l-4 border-blue-500 dark:border-blue-400 font-light">
            <?= htmlspecialchars($article['excerpt']) ?>
        </p>
        <?php endif; ?>

        <!-- Main content -->
        <?php if (!empty($article['content'])): ?>
        <div class="prose-content mb-10">
            <?= renderTiptapBlocks($article['content']) ?>
        </div>
        <?php endif; ?>

        <!-- Gallery -->
        <?php
        $gallery = array_filter($article['gallery'] ?? [], function($img) {
            return !empty($img['src']) || !empty($img['url']);
        });
        if (!empty($gallery)): ?>
        <div class="mt-12 sm:mt-16">
            <h3 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-900 dark:text-white text-center">Gallery</h3>
            <div id="galleryGrid">
                <?php foreach (array_values($gallery) as $index => $image):
                    $imgSrc = htmlspecialchars($image['src'] ?? $image['url'] ?? '');
                    $imgAlt = htmlspecialchars($image['alt'] ?? '');
                    $imgCap = htmlspecialchars($image['caption'] ?? '');
                ?>
                <div class="gallery-item cursor-pointer group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300"
                     data-index="<?= $index ?>"
                     data-full="<?= $imgSrc ?>"
                     data-alt="<?= $imgAlt ?>"
                     data-caption="<?= $imgCap ?>">
                    <img src="<?= $imgSrc ?>" alt="<?= $imgAlt ?>"
                         class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105"
                         loading="lazy">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-expand-alt text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                    <?php if ($imgCap): ?>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white text-sm"><?= $imgCap ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Related Articles -->
        <?php $related = $article['related'] ?? []; if (!empty($related)): ?>
        <div class="mt-12 sm:mt-16 pt-8 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-xl sm:text-2xl font-bold mb-6 text-gray-900 dark:text-white">Related Articles</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <?php foreach ($related as $rel):
                    $relPage = 'blogs';
                    foreach ($rel['categories'] ?? [] as $rc) {
                        if ($rc['slug'] === 'project') { $relPage = 'projects'; break; }
                    }
                ?>
                <a href="<?= url($relPage . '/' . $rel['slug'], false) ?>"
                   class="group block card-bg-radial rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <?php if (!empty($rel['featuredImage'])): ?>
                    <div class="aspect-video overflow-hidden">
                        <img src="<?= htmlspecialchars($rel['featuredImage']) ?>"
                             alt="<?= htmlspecialchars($rel['featuredImageAlt'] ?? $rel['title']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                    </div>
                    <?php endif; ?>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-snug">
                            <?= htmlspecialchars($rel['title']) ?>
                        </h4>
                        <?php if (!empty($rel['excerpt'])): ?>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1.5 line-clamp-2">
                            <?= htmlspecialchars(cutwords($rel['excerpt'], 100)) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </section>

    <!-- CTA -->
    <section class="w-full">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-8 sm:py-12 lg:py-16">
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-xl shadow-lg">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-gray-900 dark:text-white">
                    Ready to Build Something Amazing?
                </h3>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
                    Let's collaborate on your next project and create solutions that make a difference.
                </p>
                <a href="<?= url('contact', false) ?>"
                   class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold transition-colors duration-300">
                    Get In Touch
                </a>
            </div>
        </div>
    </section>

</article>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Share this <?= $type === 'project' ? 'project' : 'story' ?>
            </h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Copy Link</label>
            <div class="flex">
                <input type="text" id="shareUrl" readonly
                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                       value="<?= htmlspecialchars($page_url) ?>">
                <button id="copyButton"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg transition-colors duration-300">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p id="copyFeedback" class="text-sm text-green-600 dark:text-green-400 mt-1 hidden">Link copied!</p>
        </div>

        <div class="space-y-3">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Share on social media</h4>
            <div class="grid grid-cols-2 gap-3">
                <a id="whatsappShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                </a>
                <a id="facebookShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-facebook-f mr-2"></i> Facebook
                </a>
                <a id="twitterShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-twitter mr-2"></i> Twitter
                </a>
                <a id="linkedinShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-blue-800 hover:bg-blue-900 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-linkedin-in mr-2"></i> LinkedIn
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Image Lightbox -->
<div id="lightboxModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="relative w-full h-full flex items-center justify-center p-4">
        <button id="closeLightbox" class="absolute top-4 right-4 z-10 text-white hover:text-gray-300 transition-colors duration-300">
            <i class="fas fa-times text-2xl sm:text-3xl"></i>
        </button>
        <button id="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors duration-300 z-10">
            <i class="fas fa-chevron-left text-2xl sm:text-3xl"></i>
        </button>
        <button id="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors duration-300 z-10">
            <i class="fas fa-chevron-right text-2xl sm:text-3xl"></i>
        </button>
        <div class="relative max-w-full max-h-full">
            <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full object-contain">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 text-center">
                <p id="lightboxCaption" class="text-white text-sm sm:text-base font-medium"></p>
                <p id="lightboxCounter" class="text-white text-xs sm:text-sm opacity-75 mt-1"></p>
            </div>
        </div>
        <div id="lightboxLoader" class="absolute inset-0 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white border-t-transparent"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shareButton  = document.getElementById('shareButton');
    const shareModal   = document.getElementById('shareModal');
    const closeModal   = document.getElementById('closeModal');
    const copyButton   = document.getElementById('copyButton');
    const shareUrl     = document.getElementById('shareUrl');
    const copyFeedback = document.getElementById('copyFeedback');

    const galleryItems   = document.querySelectorAll('.gallery-item');
    const lightboxModal  = document.getElementById('lightboxModal');
    const lightboxImage  = document.getElementById('lightboxImage');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const lightboxCounter = document.getElementById('lightboxCounter');
    const lightboxLoader  = document.getElementById('lightboxLoader');
    const closeLightbox   = document.getElementById('closeLightbox');
    const prevImage = document.getElementById('prevImage');
    const nextImage = document.getElementById('nextImage');

    let currentImageIndex = 0;
    let galleryData = [];

    galleryItems.forEach(function (item, index) {
        galleryData.push({
            full:    item.dataset.full,
            alt:     item.dataset.alt,
            caption: item.dataset.caption
        });
        item.addEventListener('click', function () { openLightbox(index); });
    });

    const articleTitle       = <?= json_encode(htmlspecialchars($article['title'])) ?>;
    const articleDescription = <?= json_encode(htmlspecialchars($article['excerpt'] ?? $seoDesc)) ?>;
    const articleUrl         = <?= json_encode($page_url) ?>;

    // Share
    if (shareButton) {
        shareButton.addEventListener('click', function (e) {
            e.preventDefault();
            if (navigator.share && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                navigator.share({ title: articleTitle, text: articleDescription, url: articleUrl })
                    .catch(function () { showShareModal(); });
            } else {
                showShareModal();
            }
        });
    }

    function showShareModal() {
        if (!shareModal) return;
        shareModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        var enc  = encodeURIComponent(articleUrl);
        var encT = encodeURIComponent(articleTitle);
        var encD = encodeURIComponent(articleDescription);
        var w = document.getElementById('whatsappShare');
        var f = document.getElementById('facebookShare');
        var t = document.getElementById('twitterShare');
        var l = document.getElementById('linkedinShare');
        if (w) w.href = 'https://wa.me/?text=' + encT + '%20' + enc;
        if (f) f.href = 'https://www.facebook.com/sharer/sharer.php?u=' + enc;
        if (t) t.href = 'https://twitter.com/intent/tweet?text=' + encT + '&url=' + enc;
        if (l) l.href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + enc;
    }

    function hideShareModal() {
        if (shareModal) { shareModal.classList.add('hidden'); document.body.style.overflow = ''; }
        if (copyFeedback) copyFeedback.classList.add('hidden');
    }

    if (closeModal)  closeModal.addEventListener('click', hideShareModal);
    if (shareModal)  shareModal.addEventListener('click', function (e) { if (e.target === shareModal) hideShareModal(); });

    if (copyButton) {
        copyButton.addEventListener('click', function () {
            if (!shareUrl) return;
            navigator.clipboard ? navigator.clipboard.writeText(shareUrl.value).then(showCopied).catch(legacyCopy) : legacyCopy();
            function showCopied() { if (copyFeedback) { copyFeedback.classList.remove('hidden'); setTimeout(function () { copyFeedback.classList.add('hidden'); }, 3000); } }
            function legacyCopy() { shareUrl.select(); shareUrl.setSelectionRange(0, 99999); try { document.execCommand('copy'); showCopied(); } catch(e) {} }
        });
    }

    // Lightbox
    function openLightbox(index) {
        currentImageIndex = index;
        lightboxModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        loadImage(index);
    }

    function closeLightboxModal() {
        lightboxModal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function loadImage(index) {
        if (index < 0 || index >= galleryData.length) return;
        var d = galleryData[index];
        lightboxLoader.classList.remove('hidden');
        lightboxImage.style.opacity = '0';
        var img = new Image();
        img.onload = function () {
            lightboxImage.src = d.full;
            lightboxImage.alt = d.alt;
            lightboxCaption.textContent = d.caption;
            lightboxCounter.textContent = (index + 1) + ' of ' + galleryData.length;
            lightboxLoader.classList.add('hidden');
            lightboxImage.style.opacity = '1';
        };
        img.onerror = function () {
            lightboxLoader.classList.add('hidden');
            lightboxCounter.textContent = (index + 1) + ' of ' + galleryData.length;
        };
        img.src = d.full;
    }

    if (closeLightbox) closeLightbox.addEventListener('click', closeLightboxModal);
    if (nextImage) nextImage.addEventListener('click', function () { currentImageIndex = (currentImageIndex + 1) % galleryData.length; loadImage(currentImageIndex); });
    if (prevImage) prevImage.addEventListener('click', function () { currentImageIndex = (currentImageIndex - 1 + galleryData.length) % galleryData.length; loadImage(currentImageIndex); });
    if (lightboxModal) lightboxModal.addEventListener('click', function (e) { if (e.target === lightboxModal) closeLightboxModal(); });

    document.addEventListener('keydown', function (e) {
        if (!lightboxModal.classList.contains('hidden')) {
            if (e.key === 'Escape') closeLightboxModal();
            else if (e.key === 'ArrowRight') { currentImageIndex = (currentImageIndex + 1) % galleryData.length; loadImage(currentImageIndex); }
            else if (e.key === 'ArrowLeft')  { currentImageIndex = (currentImageIndex - 1 + galleryData.length) % galleryData.length; loadImage(currentImageIndex); }
        }
        if (e.key === 'Escape' && shareModal && !shareModal.classList.contains('hidden')) hideShareModal();
    });

    // Swipe support
    var touchStartX = 0;
    if (lightboxModal) {
        lightboxModal.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].screenX; });
        lightboxModal.addEventListener('touchend',   function (e) {
            var diff = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) { currentImageIndex = (currentImageIndex + 1) % galleryData.length; }
                else          { currentImageIndex = (currentImageIndex - 1 + galleryData.length) % galleryData.length; }
                loadImage(currentImageIndex);
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>