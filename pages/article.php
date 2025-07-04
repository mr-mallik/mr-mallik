<?php
require_once __DIR__ . '/../partials/header.php'; # config file

$type = isset($_GET['type']) ? $_GET['type'] : null;
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if(!$type || !$slug) {
    header('Location: ' . url('404'));
    exit;
}

$article = blogGet($type, $slug);

if(!$article) {
    header('Location: ' . url('404'));
    exit;
}

?>
<article class="min-h-screen">
    <!-- Hero Banner Section -->
    <section class="relative w-full h-96 md:h-[500px] overflow-hidden">
        <img src="<?= !empty($article['image']) ? url($article['image']) : url('assets/images/projects.jpeg'); ?>" 
             alt="<?= htmlspecialchars($article['title']); ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-center text-white px-4">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
                <?= htmlspecialchars($article['title']); ?>
            </h1>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl">
                <?= htmlspecialchars($article['seo_desc']); ?>
            </p>
        </div>
    </section>

    <!-- Article Content -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Article Meta -->
        <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <img src="<?= url('assets/images/gulger-mallik@1x1.jpg'); ?>" 
                     alt="Gulger Mallik" 
                     class="w-12 h-12 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Gulger Mallik</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Software Engineer & AI Researcher</p>
                </div>
            </div>
            <?php if(!empty($article['published_date'])): ?>
            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">Published on</p>
                <p class="font-medium text-gray-900 dark:text-white"><?php echo date('F j, Y', strtotime($article['published_date'])); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <?php if(!empty($article['details'])): ?>
            <div class="prose prose-lg max-w-none">
                <?php foreach($article['details'] as $content): ?>

                    <?php if(!empty($content['title'])): ?>
                        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                            <?= htmlspecialchars($content['title']); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if(!empty($content['description'])): ?>
                        <div class="text-lg leading-relaxed mb-6 text-gray-700 dark:text-gray-400">
                            <?= $content['description']; ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <?php if(!empty($article['short_description'])): ?>
                <p class="text-lg leading-relaxed mb-6 text-gray-700 dark:text-gray-400">
                    <?= htmlspecialchars($article['short_description']); ?>
                </p>
            <?php endif; ?>

        <?php endif; ?>

    </section>

    <!-- Footer Image Section -->
    <section class="w-full">
        <!-- Background Image -->
        <!-- <div class="w-full h-96 bg-center bg-cover article-footer-dark dark:article-footer-light"></div> -->
        
        <!-- Content Below Image -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-16">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg">
                <h3 class="text-2xl md:text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    Ready to Build Something Amazing?
                </h3>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto dark:text-gray-400">
                    Let's collaborate on your next project and create solutions that make a difference.
                </p>
                <div class="mt-8">
                    <a href="<?= url('contact'); ?>" 
                       class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
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