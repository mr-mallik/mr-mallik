<?php
require_once __DIR__ . '/../partials/header.php';
$projects = projectList();

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
                        <div data-aos="fade-up">
                            <div class="card-bg-radial rounded-lg">
                                <img src="<?= url('assets/projects/'.$project['urlname'].'/'.$project['image']) ?>" 
                                     alt="<?= $project['title'] ?>" 
                                     class="h-auto max-w-full rounded-lg object-cover w-full">
                                <h3 class="p-4 text-xl font-semibold py-3"><?= cutwords($project['title']) ?></h3>
                                <p class=" p-4 text-sm text-gray-300"><?= $project['short_description'] ?></p>
                                <a class=" p-4 text-right block mt-2 text-gray-400 hover:text-brand" 
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