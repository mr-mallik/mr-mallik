<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the projects page
$SEO = [
    'title' => 'Projects | Gulger Mallik',
    'description' => 'Explore the projects by Gulger Mallik, showcasing expertise in software development and design.',
    'keywords' => 'gulger mallik, projects, software development, web design',
    'url' => url('projects', false),
];

require_once __DIR__ . '/../partials/header.php';
$projects = blogList("AND type='project'");

// Calculate number of columns based on screen size
$columns = 4; // Default number of columns
$projectColumns = array_chunk($projects, ceil(count($projects) / $columns));
?>

<section id="projects">
    <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">The Grind Zone</h2>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-4 gap-4">
            <?php foreach ($projectColumns as $column) : ?>
                <div class="grid gap-4">
                    <?php foreach ($column as $project) : ?>
                        <div data-aos="fade-up" data-aos-delay="100">
                            <div class="card-bg-radial rounded-lg shadow-lg max-w-[400px]">
                                <img src="<?= url($project['image']) ?>" 
                                     alt="<?= $project['title'] ?>" 
                                     class="h-auto max-w-full rounded-t-lg  object-cover w-full">
                                <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($project['title']) ?></h3>
                                
                                <p class="px-4 text-sm text-gray-700 dark:text-gray-300">
                                    <span class="hidden xl:block"><?= $project['short_description'] ?></span>
                                    <span class="hidden lg:block xl:hidden"><?= cutwords($project['short_description']) ?></span>
                                    <span class="block lg:hidden"><?= cutwords($project['short_description'], 100) ?></span>
                                </p>

                                <a class="p-4 text-right block mt-2 text-gray-600 dark:text-gray-400 hover:text-brand" 
                                   href="<?php url('projects/'.$project['urlname']); ?>">
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