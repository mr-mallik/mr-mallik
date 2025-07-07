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
        <img src="<?= !empty($article['image']) ? url($article['image']) : url('assets/images/projects.jpeg'); ?>" 
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
                     class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">Gulger Mallik</p>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Software Engineer & AI Researcher</p>
                </div>
            </div>
            <?php if(!empty($article['published_date'])): ?>
            <div class="text-left sm:text-right">
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Published on</p>
                <p class="font-medium text-gray-900 dark:text-white text-sm sm:text-base"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></p>
            </div>
            <?php endif; ?>
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
                <p class="text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 text-gray-700 dark:text-gray-300">
                    <?= htmlspecialchars($article['short_description']); ?>
                </p>
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

<?php
require_once __DIR__ . '/../partials/footer.php'; # config file
?>