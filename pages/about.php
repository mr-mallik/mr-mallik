<?php
require_once __DIR__ . '/../includes/common.php';

$SEO = [
    'title'       => 'About Gulger Mallik | Software Engineer | Mr Mallik',
    'description' => 'Software Engineer & Full Stack Developer. Master\'s from University of Huddersfield. Co-founder of Cosmokode.',
    'keywords'    => 'gulger mallik about, mr mallik biography, software engineer uk, university of huddersfield graduate, cosmokode co-founder, team inertia technologies, trellissoft inc, crowther accountants developer, tierrasphere engineer, master computing huddersfield, fullstack developer england',
    'image'       => url('assets/images/og-image.png', false),
    'url'         => url('about', false),
];

require_once __DIR__ . '/../partials/header.php';

$clients    = json_decode(file_get_contents(__DIR__ . '/../data/clients.json'), true) ?? [];
$timeline   = json_decode(file_get_contents(__DIR__ . '/../data/edu-exp.json'), true) ?? [];
$experience = dateDiff('2019-05-27', date('Y-m-d'));
$skills     = getSkills(['tech', 'frame', 'db']);

// Latest articles from CMS (4 projects + 4 blogs)
$projects = [];
$stories  = [];
$articles = cmsoneArticleList(null, null, 20, 1);
foreach ($articles as $article) {
    foreach ($article['categories'] ?? [] as $cat) {
        if ($cat['slug'] === 'project' && count($projects) < 4) { $projects[] = $article; break; }
        if ($cat['slug'] === 'blog'    && count($stories)  < 4) { $stories[]  = $article; break; }
    }
    if (count($projects) >= 4 && count($stories) >= 4) break;
}

function logoClass(int $color): string {
    if ($color === 1)  return 'invert dark:invert-0';    // white logo
    if ($color === -1) return 'invert-0 dark:invert';    // black logo
    return '';                                            // coloured – no filter
}

function articleCard(array $a, string $urlBase): string {
    $img     = htmlspecialchars($a['featuredImage']    ?? '');
    $imgAlt  = htmlspecialchars($a['featuredImageAlt'] ?? $a['title']);
    $title   = htmlspecialchars(cutwords($a['title'],   60));
    $excerpt = htmlspecialchars(cutwords($a['excerpt'], 100));
    $href    = htmlspecialchars($urlBase . '/' . $a['slug']);
    return <<<HTML
        <div class="card-bg-radial rounded-lg shadow hover:shadow-lg transition-shadow duration-300 flex flex-col h-full" data-aos="fade-up" data-aos-delay="100">
            <div class="aspect-[40/21] overflow-hidden rounded-t-lg">
                <img src="{$img}" alt="{$imgAlt}" loading="lazy"
                     class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-4 flex flex-col flex-grow gap-2">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white leading-snug">{$title}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 flex-grow">{$excerpt}</p>
                <a href="{$href}" class="text-sm font-medium text-right text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Read more →</a>
            </div>
        </div>
HTML;
}
?>

<section id="about" class="container mx-auto px-4 sm:px-6 lg:px-8 pt-8 space-y-10 pb-10">

    <h1 class="text-center text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold px-4 text-gray-900 dark:text-white">About Me</h1>

    <div class="rounded-2xl bg-black text-white relative overflow-hidden" data-aos="zoom-in">
        <div class="absolute hidden lg:block portrait inset-0 bg-cover bg-top rounded-2xl opacity-80"></div>

        <div class="relative z-10 flex flex-col lg:flex-row gap-6 p-6 sm:p-8 lg:p-10 h-full">

            <!-- Left: Bio + Contact + Services -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6">
                <div>
                    <p class="text-xs uppercase tracking-widest text-cyan-400 mb-1">Biography</p>
                    <p class="text-sm sm:text-base leading-relaxed text-gray-200">
                        Software engineer and fullstack developer with a Master's in Computing from the University of Huddersfield.
                        Co-founder of <a href="https://www.cosmokode.com" target="_blank" rel="noopener noreferrer"
                            class="text-cyan-300 hover:underline">Cosmokode Ltd</a>,
                        specialising in web development, AI/ML solutions, and research-driven innovation.
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-blue-400 mb-2">Contact</p>
                    <div class="flex flex-col gap-1 text-sm text-gray-300">
                        <span><i class="fa fa-location-dot text-gray-500 w-4"></i> Huddersfield, UK</span>
                        <a href="mailto:<?= htmlspecialchars(CONTACT_EMAIL) ?>" class="hover:text-cyan-300 transition-colors">
                            <i class="fa fa-envelope text-gray-500 w-4"></i> <?= htmlspecialchars(CONTACT_EMAIL) ?>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-orange-400 mb-2">Services</p>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li><i class="fa fa-code text-orange-400 w-4"></i> Web Development</li>
                        <li><i class="fa fa-brain text-orange-400 w-4"></i> AI &amp; Machine Learning</li>
                        <li><i class="fa fa-flask text-orange-400 w-4"></i> Research &amp; Development</li>
                    </ul>
                </div>
            </div>

            <!-- Middle: Portrait space -->
            <div class="hidden lg:block lg:w-1/3"></div>

            <!-- Right: Stats + Skills -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6">
                <div>
                    <p class="text-xs uppercase tracking-widest text-green-400 mb-3">Credibility</p>
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap gap-x-6 gap-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold font-mono">02</span>
                                <span class="text-xs text-gray-400 uppercase leading-tight">Professional<br>Degrees</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold font-mono">4+</span>
                                <span class="text-xs text-gray-400 uppercase leading-tight">Professional<br>Certifications</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-4xl font-bold font-mono"><?= str_pad($experience['years'],  2, '0', STR_PAD_LEFT) ?></span>
                            <span class="text-xs text-gray-400 uppercase">yrs</span>
                            <span class="text-4xl font-bold font-mono"><?= str_pad($experience['months'], 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="text-xs text-gray-400 uppercase">mo</span>
                            <span class="text-4xl font-bold font-mono"><?= str_pad($experience['days'],   2, '0', STR_PAD_LEFT) ?></span>
                            <span class="text-xs text-gray-400 uppercase">d</span>
                        </div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">of professional experience</p>
                    </div>
                </div>

                <?php if (!empty($skills)) : ?>
                <div>
                    <p class="text-xs uppercase tracking-widest text-yellow-400 mb-3">Technical Skills</p>
                    <div class="flex flex-wrap gap-3">
                        <?php foreach ($skills as $skill) : ?>
                        <div class="flex flex-col items-center gap-1 group" title="<?= htmlspecialchars($skill['title']) ?>">
                            <img src="<?= htmlspecialchars($skill['icon']) ?>"
                                 alt="<?= htmlspecialchars($skill['title']) ?>"
                                 class="w-7 h-7 object-contain group-hover:scale-110 transition-transform duration-200">
                            <span class="hidden xl:block text-[10px] text-gray-400"><?= htmlspecialchars($skill['title']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <div data-aos="fade-up">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold py-4 sm:py-6 lg:py-8 px-4 text-gray-900 dark:text-white">Showcase</h2>
        <div class="flex flex-row flex-wrap justify-center items-center gap-6 sm:gap-10">
            <?php foreach ($clients as $client) : ?>
            <a href="<?= htmlspecialchars($client['url']) ?>" target="_blank" rel="noopener noreferrer"
               title="<?= htmlspecialchars($client['name']) ?>"
               class="transition-opacity duration-200 hover:opacity-75">
                <img src="<?= image_src($client['logo'], false) ?>"
                     alt="<?= htmlspecialchars($client['name']) ?>"
                     class="h-8 sm:h-10 w-auto object-contain <?= logoClass((int) $client['color']) ?>">
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="edu-experience">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold py-4 sm:py-6 lg:py-8 px-4 text-gray-900 dark:text-white" data-aos="fade-up">
            Education &amp; Experience
        </h2>

        <div class="relative max-w-2xl mx-auto">
            <!-- Line: mobile = left-4 (dot centre), sm+ = date-col(w-16=64) + gap-4(16) + half-dot(16) = left-24 (96px) -->
            <div class="absolute left-4 sm:left-24 top-0 bottom-0 w-px bg-gray-300 dark:bg-gray-700"></div>

            <div class="space-y-3">
                <?php foreach ($timeline as $i => $item) :
                    $isWork  = ($item['type'] === 'work');
                    $bgDot   = $isWork ? 'bg-cyan-500' : 'bg-purple-500';
                    $dotIcon = $isWork ? 'fa-briefcase' : 'fa-graduation-cap';
                    $bullet  = $isWork ? 'text-cyan-700 dark:text-cyan-500' : 'text-purple-700 dark:text-purple-500';
                    $delay   = $i * 40;
                    [$mon, $yr] = array_pad(explode(' ', explode(' – ', $item['period'])[0] ?? ''), 2, '');
                ?>
                <div class="relative flex gap-4 items-start" data-aos="fade-up" data-aos-delay="<?= $delay ?>">

                    <!-- Date column: hidden on mobile, visible sm+ -->
                    <div class="hidden sm:flex w-16 flex-col items-end justify-start pt-2 shrink-0">
                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-400 leading-none"><?= htmlspecialchars($mon) ?></span>
                        <span class="text-xs text-gray-500 dark:text-gray-500 mt-0.5 leading-none"><?= htmlspecialchars($yr) ?></span>
                    </div>

                    <!-- Dot -->
                    <div class="relative z-10 flex-shrink-0 w-8 h-8 rounded-full <?= $bgDot ?> flex items-center justify-center shadow-sm">
                        <i class="fa <?= $dotIcon ?> text-white text-xs"></i>
                    </div>

                    <!-- Card -->
                    <details class="card-bg-radial rounded-lg flex-1 group min-w-0">
                        <summary class="p-3.5 cursor-pointer list-none flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900 dark:text-white leading-tight"><?= htmlspecialchars($item['role']) ?></p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5"><?= htmlspecialchars($item['org']) ?></p>
                                <!-- Period shown on mobile (date col hidden); hidden on sm+ (date col visible) -->
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-0.5 sm:hidden"><?= htmlspecialchars($item['period']) ?></p>
                            </div>
                            <i class="fa fa-chevron-right text-gray-500 dark:text-gray-500 mt-1 shrink-0 text-xs transition-transform duration-200 group-open:rotate-90"></i>
                        </summary>

                        <div class="px-3.5 pb-3.5 pt-2 border-t border-gray-200 dark:border-gray-700/50">
                            <p class="text-[11px] text-gray-500 dark:text-gray-500 mb-2"><?= htmlspecialchars($item['period']) ?></p>
                            <p class="text-xs text-gray-700 dark:text-gray-400 leading-relaxed mb-2.5"><?= htmlspecialchars($item['summary']) ?></p>
                            <p class="text-[11px] font-semibold text-gray-600 dark:text-gray-500 uppercase tracking-wide mb-1.5"><?= htmlspecialchars($item['detail_title']) ?></p>
                            <ul class="space-y-1.5">
                                <?php foreach ($item['details'] as $detail) : ?>
                                <li class="flex gap-2 text-xs text-gray-700 dark:text-gray-400 leading-relaxed">
                                    <span class="<?= $bullet ?> shrink-0">•</span>
                                    <?= htmlspecialchars($detail) ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </details>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($projects)) : ?>
    <div>
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-gray-200 dark:border-gray-700" data-aos="fade-right">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-white">
                <i class="fa fa-laptop-code text-cyan-500 mr-2"></i> Latest Work
            </h3>
            <a href="<?= url('projects', false) ?>" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                View all →
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($projects as $project) : ?>
            <?= articleCard($project, url('projects', false)) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($stories)) : ?>
    <div class="card-bg-linear rounded-2xl p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-gray-200 dark:border-gray-700" data-aos="fade-right">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-white">
                <i class="fa fa-book-open text-purple-500 mr-2"></i> Latest Stories
            </h3>
            <a href="<?= url('blogs', false) ?>" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                View all →
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php foreach ($stories as $story) : ?>
            <?= articleCard($story, url('blogs', false)) ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>