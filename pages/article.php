<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

$type = isset($_GET['type']) ? $_GET['type'] : null;
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if(!$type || !$slug) {
    header('Location: ' . url('404', false));
    exit;
}

$article = blogGet($type, $slug);

if(!$article) {
    header('Location: ' . url('404', false));
    exit;
}

// SEO configuration for the article page
$page_url = '';

if($type === 'project') {
    $page_url = url('projects/' . $article['urlname'], false);
} elseif($type === 'blog') {
    $page_url = url('stories/' . $article['urlname'], false);
}

$SEO = [
    'title' =>  ($type === 'project' ? 'Project: ' : 'Story: ') . htmlspecialchars($article['title']) . ' | Gulger Mallik',
    'description' => htmlspecialchars($article['seo_desc']),
    'keywords' => $article['seo_keyword'] ? htmlspecialchars($article['seo_keyword']) : 'gulger mallik, mr mallik, gulger, mallik, software engineer, fullstack developer',
    'image' => !empty($article['image']) ? url($article['image'], false) : url('assets/images/article-footer-light.png', false),
    'image_alt' => htmlspecialchars($article['title']),
    'url' => $page_url,
];

require_once __DIR__ . '/../partials/header.php'; # config file

?>
<article class="min-h-screen">
    <!-- Hero Banner Section -->
    <section class="relative w-full h-64 sm:h-80 md:h-96 lg:h-[500px] overflow-hidden">
        <img src="<?= !empty($article['banner_image']) ? url($article['banner_image']) : (!empty($article['image']) ? url($article['image']) : url('assets/images/projects.jpeg')); ?>"
             alt="<?= htmlspecialchars($article['title']); ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        <div class="absolute bottom-4 sm:bottom-8 left-1/2 transform -translate-x-1/2 text-center text-white px-4 w-full max-w-4xl">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-2 sm:mb-4 leading-tight">
                <?= htmlspecialchars($article['title']); ?>
            </h1>
            <p class="text-sm sm:text-base md:text-lg lg:text-xl opacity-90 max-w-2xl mx-auto">
                <?= htmlspecialchars($article['seo_desc']); ?>
            </p>
        </div>
    </section>

    <!-- Article Content -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Article Meta -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-6 border-b border-gray-200 dark:border-gray-700 gap-4">
            <div class="flex items-center space-x-4">
                <img src="<?= url('assets/images/gulger-mallik@1x1.jpg'); ?>" 
                     alt="Gulger Mallik" 
                     class="w-15 h-15 sm:w-18 sm:h-18 rounded-full object-cover">
                <div class="flex flex-col">
                    <!-- Author Info -->
                    <div class="mb-2">
                        <h2 class="font-semibold text-gray-900 dark:text-white text-base sm:text-lg">
                            Gulger Mallik
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Software Engineer & AI Researcher
                        </p>
                    </div>

                    <!-- Publication Date -->
                    <?php if(!empty($article['published_date'])): ?>
                    <div class="flex items-center gap-1 text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Published:</span>
                        <time datetime="<?= date('Y-m-d', strtotime($article['published_date'])); ?>" 
                              class="font-medium text-gray-900 dark:text-white">
                            <?= date('F j, Y', strtotime($article['published_date'])); ?>
                        </time>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Action Icons -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <?php if(!empty($article['github'])): ?>
                <a href="<?= htmlspecialchars($article['github']); ?>" target="_blank" 
                   class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-colors duration-300"
                   title="View on GitHub">
                    <i class="fab fa-github text-lg sm:text-xl text-gray-600 dark:text-gray-400"></i>
                </a>
                <?php endif; ?>
                
                <?php if(!empty($article['online'])): ?>
                <a href="<?= htmlspecialchars(!empty($article['online']) ? $article['online'] : $article['online']); ?>" target="_blank" 
                   class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-colors duration-300"
                   title="View Live Demo">
                    <i class="fas fa-external-link-alt text-lg sm:text-xl text-gray-600 dark:text-gray-400"></i>
                </a>
                <?php endif; ?>
                
                <button id="shareButton" 
                        class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-colors duration-300"
                        title="Share this <?= $type === 'project' ? 'project' : 'story' ?>">
                    <i class="fas fa-share-alt text-lg sm:text-xl text-gray-600 dark:text-gray-400"></i>
                </button>
            </div>
        </div>

        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 sm:mb-6 leading-tight text-gray-900 dark:text-white"><?= htmlspecialchars($article['title']); ?></h1>

        <?php if(!empty($article['details'])): ?>
            <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none">
                <?php foreach($article['details'] as $content): ?>

                    <?php if(!empty($content['title'])): ?>
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 sm:mb-6 text-gray-900 dark:text-white">
                            <?= htmlspecialchars($content['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if(!empty($content['description'])): ?>
                        <div class="text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 text-gray-700 dark:text-gray-300">
                            <?= $content['description']; ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <?php if(!empty($article['short_description'])): ?>
                <div class="text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 text-gray-700 dark:text-gray-300">
                    <?= $article['short_description']; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($article['overview'])): ?>
                <div class="text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 text-gray-700 dark:text-gray-300">
                    <?= $article['overview']; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </section>

    <!-- Footer Image Section -->
    <section class="w-full">
        <!-- Content Below Image -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-8 sm:py-12 lg:py-16">
            <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-xl shadow-lg">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 sm:mb-6 text-gray-900 dark:text-white">
                    Ready to Build Something Amazing?
                </h3>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 mb-6 sm:mb-8 max-w-2xl mx-auto">
                    Let's collaborate on your next project and create solutions that make a difference.
                </p>
                <div class="mt-6 sm:mt-8">
                    <a href="<?= url('contact'); ?>" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-6 sm:px-8 py-3 rounded-lg font-semibold transition-colors duration-300 text-sm sm:text-base">
                        Get In Touch
                    </a>
                </div>
            </div>
        </div>
    </section>
</article>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Share this <?= $type === 'project' ? 'project' : 'story' ?></h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Copy Link -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Copy Link</label>
            <div class="flex">
                <input type="text" id="shareUrl" readonly 
                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                       value="<?= htmlspecialchars($page_url); ?>">
                <button id="copyButton" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg transition-colors duration-300">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p id="copyFeedback" class="text-sm text-green-600 dark:text-green-400 mt-1 hidden">Link copied to clipboard!</p>
        </div>
        
        <!-- Social Share Buttons -->
        <div class="space-y-3">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Share on social media</h4>
            
            <div class="grid grid-cols-2 gap-3">
                <a id="whatsappShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-whatsapp mr-2"></i>
                    WhatsApp
                </a>
                
                <a id="facebookShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-facebook-f mr-2"></i>
                    Facebook
                </a>
                
                <a id="twitterShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-twitter mr-2"></i>
                    Twitter
                </a>
                
                <a id="linkedinShare" target="_blank"
                   class="flex items-center justify-center px-4 py-3 bg-blue-800 hover:bg-blue-900 text-white rounded-lg transition-colors duration-300">
                    <i class="fab fa-linkedin-in mr-2"></i>
                    LinkedIn
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const shareButton = document.getElementById('shareButton');
    const shareModal = document.getElementById('shareModal');
    const closeModal = document.getElementById('closeModal');
    const copyButton = document.getElementById('copyButton');
    const shareUrl = document.getElementById('shareUrl');
    const copyFeedback = document.getElementById('copyFeedback');
    
    // Article data for sharing
    const articleTitle = <?= json_encode(htmlspecialchars($article['title'])); ?>;
    const articleDescription = <?= json_encode(htmlspecialchars($article['seo_desc'])); ?>;
    const articleUrl = <?= json_encode($page_url); ?>;
    
    // Share button click handler
    shareButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Check if Web Share API is supported (mobile devices)
        if (navigator.share && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            navigator.share({
                title: articleTitle,
                text: articleDescription,
                url: articleUrl
            }).catch(err => {
                console.log('Error sharing:', err);
                showShareModal();
            });
        } else {
            showShareModal();
        }
    });
    
    function showShareModal() {
        shareModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Update share URLs
        const encodedTitle = encodeURIComponent(articleTitle);
        const encodedUrl = encodeURIComponent(articleUrl);
        const encodedText = encodeURIComponent(articleDescription);
        
        document.getElementById('whatsappShare').href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;
        document.getElementById('facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
        document.getElementById('twitterShare').href = `https://twitter.com/intent/tweet?text=${encodedTitle}&url=${encodedUrl}`;
        document.getElementById('linkedinShare').href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;
    }
    
    // Close modal handlers
    closeModal.addEventListener('click', hideShareModal);
    shareModal.addEventListener('click', function(e) {
        if (e.target === shareModal) {
            hideShareModal();
        }
    });
    
    function hideShareModal() {
        shareModal.classList.add('hidden');
        document.body.style.overflow = '';
        copyFeedback.classList.add('hidden');
    }
    
    // Copy to clipboard
    copyButton.addEventListener('click', function() {
        shareUrl.select();
        shareUrl.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            copyFeedback.classList.remove('hidden');
            setTimeout(() => {
                copyFeedback.classList.add('hidden');
            }, 3000);
        } catch (err) {
            console.error('Failed to copy: ', err);
        }
    });
    
    // ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !shareModal.classList.contains('hidden')) {
            hideShareModal();
        }
    });
});
</script>

<?php
require_once __DIR__ . '/../partials/footer.php'; # config file
?>