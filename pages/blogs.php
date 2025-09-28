<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the blogs page
$SEO = [
    'title' => 'Blog & Stories | Gulger Mallik | Software Engineering Journey | Mr Mallik',
    'description' => 'Follow Gulger Mallik\'s software engineering journey through insightful blogs and stories. Learn about experiences at University of Huddersfield, CosmoKode, and the tech industry.',
    'keywords' => 'gulger mallik blog, mr mallik stories, software engineering blog, tech journey, university huddersfield experience, cosmokode stories, developer blog uk',
    'url' => url('blogs', false),
];

require_once __DIR__ . '/../partials/header.php';

$stories = [];
$columns = 4; // Default number of columns
$resume = blogList('AND type="blog" AND status="A"');
$stories = array_merge($stories, $resume);

// if no stories found, show a message
if (empty($stories)) {
    echo '<p class="text-center text-gray-500 dark:text-gray-400">No stories found.</p>';
    require_once __DIR__ . '/../partials/footer.php';
    exit;
}

// Calculate number of columns based on screen size
$totalColumns = array_chunk($stories, ceil(count($stories) / $columns));
?>

<section id="projects">
    <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold py-4 sm:py-6 lg:py-8 px-4 text-gray-900 dark:text-white">My Journey Log</h2>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($stories as $story) : ?>
                <div class="w-full" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-bg-radial rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 h-full flex flex-col">
                        <div class="aspect-video overflow-hidden rounded-t-lg">
                            <img src="<?= image_src($story['image'], true, 'assets/stories/default.png') ?>" 
                                 alt="<?= $story['title'] ?>" 
                                 class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4 sm:p-6 flex flex-col flex-grow">
                            <h3 class="text-lg sm:text-xl font-semibold mb-2 text-gray-900 dark:text-white">
                                <?= cutwords($story['title'], 60) ?>
                            </h3>
                            
                            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 mb-4 flex-grow">
                                <?= cutwords($story['short_description'], 120) ?>
                            </p>

                            <a class="text-right text-sm sm:text-base text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 font-medium" 
                               href="<?php url('blogs/'.$story['urlname']); ?>">
                               Read more →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>