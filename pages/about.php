<?php
require_once __DIR__ . '/../includes/common.php'; # config file
// META TAGS
$SEO = [
    'title' => 'About Gulger Mallik',
    'description' => 'Gulger Mallik is a Software Engineer and a Fullstack developer.',
    'keywords' => 'gulger mallik, mr mallik, gulger, mallik, software engineer, fullstack developer',
    'image' => url('assets/images/gulger-mallik@1x1.jpg', false),
    'url' => url('about', false),
];


require_once __DIR__ . '/../partials/header.php'; # config file

$clients = [
    [
        'name' => 'Tierrasphere',
        'logo' => image_src('assets/images/showcase/TierraSphere.png', false),
        'url' => 'https://tierrasphere.cosmokode.com/',
    ],
    [
        'name' => 'Crowther Accountants',
        'logo' => image_src('assets/images/showcase/crowther.svg', false),
        'url' => 'https://www.crowther.accountants/',
        'invert' => false
    ],
    [
        'name' => 'Muscle Mind Stories',
        'logo' => image_src('assets/images/showcase/musclemindstories.png', false),
        'url' => 'https://musclemindstories.com/',
        'invert' => true
    ],
    [
        'name' => 'Ramjan Interiors',
        'logo' => image_src('assets/images/showcase/ramjaninteriors.png', false),
        'url' => 'https://www.ramjaninteriors.com/',
        'invert' => false
    ],
    [
        'name' => 'University of Huddersfield',
        'logo' => image_src('assets/images/showcase/universityofhuddersfield.svg', false),
        'url' => 'https://www.hud.ac.uk/',
        'invert' => false
    ],
    [
        'name' => 'Fitplanex',
        'logo' => image_src('assets/images/showcase/fitplanex.png', false),
        'url' => 'https://www.fitplanex.com/'
    ],
    [
        'name' => 'CosmoKode',
        'logo' => image_src('assets/images/showcase/cosmokode.png', false),
        'url' => 'https://www.cosmokode.com/'
    ],
    [
        'name' => 'Personnel Skills Matrix',
        'logo' => image_src('assets/images/showcase/psm.png', false),
        'url' => 'https://www.psm.cosmokode.com/'
    ]
];

$experience = dateDiff('2019-05-27', date('Y-m-d'));

$projects = blogList("AND type='project' AND status='A'", 4);
$stories = blogList("AND type='blog' AND status='A'", 4);
$skills = getSkills($type=['tech', 'frame', 'db']);
?>

<section id="about" class="container mx-auto px-4 sm:px-6 lg:px-8">
    
    <h1 class="text-center text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-semibold py-4 sm:py-6 lg:py-8 px-4 text-gray-900 dark:text-white">The Blueprint</h1>

    <div class="flex flex-col lg:flex-row card-bg-radial rounded-xl p-4 sm:p-6 lg:p-8 mb-6 gap-6" data-aos="zoom-in">

        <div class="w-full lg:w-1/3 flex flex-col gap-4 sm:gap-6 text-left">
            <span class="text-gray-500 dark:text-gray-400 text-sm sm:text-base lg:text-lg font-semibold">
                <i class="fa fa-user text-cyan-500"></i>
                Biography
                <hr class="mt-1">
            </span>

            <p class="text-sm sm:text-base lg:text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                I am a software engineer and fullstack developer with a passion for AI and machine learning. I have a Master's degree in Computing from the University of Huddersfield, UK. I have worked as a software engineer in India and the UK. I have experience in developing web applications, mobile applications, and AI models.
            </p>

            <span class="text-gray-500 dark:text-gray-400 text-sm sm:text-base lg:text-lg font-semibold text-right">
                <i class="fa fa-envelope text-blue-500"></i>
                Contact
                <hr class="mt-1">
            </span>

            <div class="about-contact text-sm sm:text-base lg:text-lg text-gray-700 dark:text-gray-300">
                <p>
                    Huddersfield, UK
                </p>

                <p>
                    <a href="mailto:gulgermallik@gmail.com" class="hover:underline brand-text">gulgermallik@gmail.com</a>
                </p>

            </div>

            <span class="text-gray-500 text-md xl:text-lg font-semibold">
                <i class="fa fa-gears text-orange-500"></i>
                Services
                <hr>
            </span>

            <p class="text-sm sm:text-base lg:text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                Web Development <br/>
                Mobile Development <br/>
                AI and Machine Learning <br/>
                Research and Development <br/>
                Software Engineering
            </p>
        </div>

        <div class="flex flex-col hidden lg:block lg:w-1/3 text-center items-center justify-center">
            <img src="<?= url('assets/images/about-me-grad.jpg'); ?>" 
                alt="Gulger Mallik in graduation gown" 
                class="max-h-[800px] rounded-full">
        </div>

        <div class="flex flex-col w-2/2 lg:w-1/3 gap-6 p-4 text-right">
            <span class="text-gray-500 text-md xl:text-lg font-semibold">
                <i class="fa fa-clock text-green-500"></i>
                Credibility
                <hr>
            </span>

            <div class="flex flex-col gap-4 justify-center">

                <div class="flex flex-col sm:flex-row gap-2 justify-center">
                    <div class="flex items-center">
                        <span class="text-2xl sm:text-3xl xl:text-6xl font-bold font-mono">02</span> 
                        <span class="uppercase text-[12px] sm:text-xs px-2 sm:px-4 text-left text-gray-400">professional degrees</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-2xl sm:text-3xl xl:text-6xl font-bold font-mono">4+</span> 
                        <span class="uppercase text-[12px] sm:text-xs px-2 sm:px-4 text-left text-gray-400">professional certifications</span>
                    </div>
                </div>

                <div class="flex flex-row gap-1 sm:gap-2 items-center">
                    <span class="text-2xl sm:text-3xl xl:text-6xl font-bold font-mono"><?= str_pad($experience['years'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-[12px] sm:text-xs text-gray-400">years</span>
                    <span class="text-2xl sm:text-3xl xl:text-6xl font-bold font-mono"><?= str_pad($experience['months'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-[12px] sm:text-xs text-gray-400"><?= $experience['months'] > 1 ? 'months' : 'month'; ?></span>
                    <span class="text-2xl sm:text-3xl xl:text-6xl font-bold font-mono"><?= str_pad($experience['days'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-[12px] sm:text-xs text-gray-400"><?= $experience['days'] > 1 ? 'days' : 'day'; ?></span>
                </div>
                
                <span class="text-upper text-gray-400 text-xs sm:text-sm">of professional experience</span>

            </div>

            <span class="text-left text-gray-500 text-md xl:text-lg font-semibold">
                <i class="fa fa-chart-simple text-yellow-500"></i>
                Technical Skills
                <hr>
            </span>

            <div class="flex flex-row flex-wrap gap-4 text-left">
                <?php foreach ($skills as $skill) : ?>
                    <div class="flex flex-col gap-1 xl:gap-2 text-center justify-center items-center">
                        <img src="<?= $skill['icon']; ?>" alt="<?= $skill['title'] ?>" title="<?= $skill['title'] ?>" 
                            class="w-6 h-6 xl:w-8 xl:h-8 object-contain hover:cursor-pointer hover:scale-110 transition-transform duration-300 ease-in-out">
                        <span class="hidden xl:block text-xs"><?= $skill['title'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <span class="text-gray-500 text-md xl:text-lg font-semibold">
                <i class="fa fa-heart text-red-500"></i>
                Likes &amp; Interests
                <hr>
            </span>

            <div class="flex flex-row gap-6 justify-start text-left items-center">
                <div class="flex flex-col gap-2">
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-music "></i>
                        Music
                    </p>
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-dumbbell"></i>
                        Health and Fitness
                    </p>
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-plane"></i>
                        Travel
                    </p>
                </div>
                <div class="flex flex-col gap-2">
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-code"></i>
                        Code
                    </p>
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-camera"></i>
                        Photography
                    </p>
                    <p class="text-[13px] lg:text-lg text-gray-700 dark:text-gray-300 text-nowrap">
                        <i class="fa fa-film"></i>
                        Movies
                    </p>
                </div>
            </div>


        </div>
    </div>

    <div class="flex flex-col justify-center py-8">
        
        <h2 class="text-center text-3xl xl:text-5xl xl:p-8 p-3 font-semibold" data-aos="fade-top">Showcase </h2>

        <div class="flex flex-row flex-wrap justify-center gap-4 xl:gap-8 py-3 xl:py-6 my-2 xl:my-4" data-aos="flip-down">
            <?php 
            $count = 0;
            foreach ($clients as $client) : 
            if ($count > 0 && $count % 5 == 0) {
                echo '</div><div class="flex flex-row flex-wrap justify-center gap-4 xl:gap-8 py-3 xl:py-6 my-2 xl:my-4" data-aos="flip-down">';
            }
            ?>
            <a href="javascript:;" title="<?= $client['name']; ?>" class="flex items-center justify-center transition duration-300 ease-in-out">
                <img src="<?= $client['logo'] ?>" alt="<?= $client['name'] ?>" 
                    class="w-30 xl:w-40 object-contain grayscale <?php echo isset($client['invert']) && $client['invert'] == true ? 'invert-0 dark:invert' : 'invert dark:invert-0' ?> hover:grayscale-0">
            </a>
            <?php 
            $count++;
            endforeach; 
            ?>
        </div>
    </div>
    
    <div class="card-bg-radial rounded-t-xl p-4 xl:p-8 mb-2 xl:mb-4 shadow-lg" id='edu-experience'>

        <h2 class="text-center text-3xl xl:text-5xl p-4 xl:p-8 font-semibold" data-aos="fade-top">Education &amp; Experience </h2>

        <div class="experience flex flex-col md:flex-row justify-between p-4 xl:p-8 shadow-lg gap-8">
            <!-- 2024-Present Section -->
            <div class="flex flex-col md:w-1/3" data-aos="fade-up">
                <div class="flex flex-col gap-6 text-left">
                    <h3>2024 - Present</h3>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Research Assistant in Applied AI <br/>
                        <span>University of Huddersfield, UK</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Software Engineer <br/>
                        <span>CosmoKode Ltd, UK</span>
                    </p>
                </div>
            </div>

            <!-- 2022-2023 Section -->
            <div class="flex flex-col md:w-1/3" data-aos="fade-up">
                <div class="flex flex-col gap-6 text-left">
                    <h3>2022 - 2023</h3>

                    <p>
                        <i class="fa fa-graduation-cap"></i>
                        Master of Science in Computing <br/>
                        <span>University of Huddersfield, UK</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Software Engineer <br/>
                        <span>Shop &amp; Bakery Equipment Ltd, UK</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        R &amp; D Software Engineer <br/>
                        <span>University of Huddersfield, UK</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Research Technician <br/>
                        <span>University of Huddersfield, UK</span>
                    </p>
                </div>
            </div>

            <!-- 2019-2021 Section -->
            <div class="flex flex-col md:w-1/3" data-aos="fade-up">
                <div class="flex flex-col gap-6 text-left">
                    <h3>2019 - 2021</h3>

                    <p class="text-xs">
                        <i class="fa fa-graduation-cap"></i>
                        Bachelor of Computer Applications <br/>
                        <span>St. Xaviers College, India</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Software Engineer <br/>
                        <span>Team Inertia Technologies, India</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Trellissoft Technologies <br/>
                        <span>Trellissoft Inc, India</span>
                    </p>
                </div>
            </div>
        </div>

        <h2 class="text-center text-3xl xl:text-5xl xl:p-8 p-3 font-semibold" data-aos="fade-top">Latest Work </h2>

        <div class="flex flex-col justify-center p-4 xl:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 xl:gap-8 py-3 xl:py-6 my-2 xl:my-4">
                <?php foreach ($projects as $project) : ?>
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="card-bg-radial shadow-lg rounded-lg max-w-[400px]">
                            <img src="<?= image_src($project['image']) ?>" 
                                    alt="<?= $project['title'] ?>" 
                                    class="h-auto max-w-full rounded-t-lg  object-cover w-full">
                            <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($project['title']) ?></h3>
                            
                            <p class="px-4 text-sm text-gray-700 dark:text-gray-300">
                                <span class="hidden xl:block"><?= $project['short_description'] ?></span>
                                <span class="hidden lg:block xl:hidden"><?= cutwords($project['short_description']) ?></span>
                                <span class="block lg:hidden"><?= cutwords($project['short_description'], 100) ?></span>
                            </p>

                            <a class="p-2 xl:p-4 text-right block mt-1 xl:mt-2 text-gray-600 dark:text-gray-400 hover:text-brand" 
                                href="<?php url('projects/'.$project['urlname']); ?>">
                                Read more →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center">
                <a href="<?php url('projects'); ?>" class="text-center font-mono text-lg xl:text-2xl font-semibold py-2 xl:py-4 underline transition ease-in-out">View all projects </a>
            </div>
        </div>
    </div>

    <?php if (count($stories) > 0) : ?>
        <!-- <hr class="py-5 border-gray-600" /> -->

        <h2 class="text-center text-3xl xl:text-5xl xl:p-8 p-3 font-semibold" data-aos="fade-top">Latest Stories </h2>

        <div class="flex flex-col justify-center p-4 xl:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 xl:gap-8 py-3 xl:py-6 my-2 xl:my-4">
                <?php foreach ($stories as $story) : ?>
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="card-bg-radial shadow-lg rounded-lg max-w-[400px]">
                            <img src="<?= image_src($story['image'], true, 'assets/stories/default.png') ?>" 
                                    alt="<?= $story['title'] ?>" 
                                    class="h-auto w-full max-w-[400px] rounded-t-lg object-cover">
                            <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($story['title']) ?></h3>

                            <p class="px-4 text-sm text-gray-700 dark:text-gray-300">
                                <span class="hidden xl:block"><?= $story['short_description'] ?></span>
                                <span class="hidden lg:block xl:hidden"><?= cutwords($story['short_description']) ?></span>
                                <span class="block lg:hidden"><?= cutwords($story['short_description'], 100) ?></span>
                            </p>

                            <a class="p-2 xl:p-4 text-right block mt-1 xl:mt-2 text-gray-600 dark:text-gray-400 hover:text-brand" 
                                href="<?php url('stories/'.$story['urlname']); ?>">
                                Read more →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center">
                <a href="<?php url('stories'); ?>" class="text-center font-mono text-lg xl:text-2xl font-semibold py-2 xl:py-4 underline transition ease-in-out">View all stories </a>
            </div>

        </div>
    <?php endif; ?>

    <!-- <h2 class="text-center text-3xl xl:text-5xl xl:p-8 p-3 font-semibold" data-aos="fade-top">Testimonials </h2> -->

</section>

<?php
require_once __DIR__ . '/../partials/footer.php'; # config file
?>