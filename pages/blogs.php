<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the blogs page
$SEO = [
    'title' => 'My Journey Log | Gulger Mallik',
    'description' => 'Explore the journey of Gulger Mallik through various blogs and stories.',
    'keywords' => 'gulger mallik, blogs, stories, journey log',
    'url' => url('blogs', false),
];

require_once __DIR__ . '/../partials/header.php';

$stories = [];
$columns = 4; // Default number of columns
$resume = blogList('AND type="blog"');
$stories = array_merge($stories, $resume);

// Calculate number of columns based on screen size
$totalColumns = array_chunk($stories, ceil(count($stories) / $columns));
?>

<section id="projects">
    <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">My Journey Log</h2>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-4 gap-4">
            <?php foreach ($totalColumns as $column) : ?>
                <div class="grid gap-4">
                    <?php foreach ($column as $story) : ?>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <div class="card-bg-radial rounded-lg">
                                <img src="<?= image_src($story['image'], true, 'assets/stories/default.png') ?>" 
                                     alt="<?= $story['title'] ?>" 
                                     class="h-auto max-w-full rounded-t-lg  object-cover w-full">
                                <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($story['title']) ?></h3>
                                
                                <p class="px-4 text-sm text-gray-700 dark:text-gray-300">
                                    <span class="hidden lg:block"><?= $story['short_description'] ?></span>
                                    <span class="hidden md:block lg:hidden"><?= cutwords($story['short_description']) ?></span>
                                    <span class="block md:hidden"><?= cutwords($story['short_description'], 100) ?></span>
                                </p>

                                <a class="p-4 text-right block mt-2 text-gray-600 dark:text-gray-400 hover:brand-text" 
                                   href="<?php url('stories/'.$story['urlname']); ?>">
                                   Read more →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>