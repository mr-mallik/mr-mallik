<?php
require_once __DIR__ . '/../partials/header.php'; # config file

$clients = [
    [
        'name' => 'Tierrasphere',
        'logo' => image_src('assets/images/showcase/TierraSphere.png', false),
        'url' => 'https://tierrasphere.cosmokode.com/'
    ],
    [
        'name' => 'Crowther Accountants',
        'logo' => image_src('assets/images/showcase/crowther.svg', false),
        'url' => 'https://www.crowther.accountants/'
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
        'url' => 'https://www.ramjaninteriors.com/'
    ],
    [
        'name' => 'University of Huddersfield',
        'logo' => image_src('assets/images/showcase/universityofhuddersfield.svg', false),
        'url' => 'https://www.hud.ac.uk/'
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

$projects = blogList("AND type='project'", 4);
$stories = blogList("AND type='blog'", 4);
$skills = getSkills($type=['tech', 'frame', 'db']);
?>

<section id="about" class="container mx-auto">
    
    <h1 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">The Blueprint </h1>

    <div class="flex flex-row card-bg-radial rounded-b-xl p-4 py-8 mb-4" data-aos="zoom-in">

        <div class="flex flex-col w-1/3 gap-4 text-left p-4">
            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-user text-cyan-500"></i>
                Biography
                <hr>
            </span>

            <p class="text-justify">
                I am a software engineer and fullstack developer with a passion for AI and machine learning. I have a Master's degree in Computing from the University of Huddersfield, UK. I have worked as a software engineer in India and the UK. I have experience in developing web applications, mobile applications, and AI models.
            </p>

            <span class="text-gray-500 text-lg font-semibold text-right">
                <i class="fa fa-envelope text-blue-500"></i>
                Contact
                <hr>
            </span>

            <div class="about-contact">
                <p>
                    Huddersfield, UK
                </p>

                <p>
                    <a href="mailto:gulgermallik@gmail.com">gulgermallik@gmail.com</a>
                </p>

            </div>

            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-gears text-orange-500"></i>
                Services
                <hr>
            </span>

            <p class="text-justify">
                Web Development <br/>
                Mobile Development <br/>
                AI and Machine Learning <br/>
                Research and Development <br/>
                Software Engineering
            </p>
        </div>

        <div class="flex flex-col w-1/3 text-center items-center justify-center">
            <img src="<?= url('assets/images/about-me-grad.jpg'); ?>" 
                alt="Gulger Mallik in graduation gown" 
                class="max-h-[600px] rounded-full">
        </div>

        <div class="flex flex-col w-1/3 gap-6 text-right">
            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-clock text-green-500"></i>
                Credibility
                <hr>
            </span>

            <div class="flex flex-col gap-4 justify-center">

                <div class="flex flex-row gap-2 justify-center">
                    <div class="flex items-center">
                        <span class="text-6xl font-bold font-mono">02</span> 
                        <span class="uppercase text-xs px-4 text-left text-gray-400">professional degrees</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-6xl font-bold font-mono">4+</span> 
                        <span class="uppercase text-xs px-4 text-left text-gray-400">professional certifications</span>
                    </div>
                </div>

                <div class="flex flex-row gap-2 items-center">
                    <span class="text-6xl font-bold font-mono"><?= str_pad($experience['years'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-xs text-gray-400">years</span>
                    <span class="text-6xl font-bold font-mono"><?= str_pad($experience['months'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-xs text-gray-400"><?= $experience['months'] > 1 ? 'months' : 'month'; ?></span>
                    <span class="text-6xl font-bold font-mono"><?= str_pad($experience['days'], 2, '0', STR_PAD_LEFT); ?></span> 
                    <span class="uppercase text-xs text-gray-400"><?= $experience['days'] > 1 ? 'days' : 'day'; ?></span>
                </div>
                
                <span class="text-upper text-gray-400 text-sm">of professional experience</span>

            </div>

            <span class="text-left text-gray-500 text-lg font-semibold">
                <i class="fa fa-chart-simple text-yellow-500"></i>
                Technical Skills
                <hr>
            </span>

            <div class="flex flex-row flex-wrap gap-4 text-left">
                <?php foreach ($skills as $skill) : ?>
                    <div class="flex flex-col gap-2 text-center justify-center items-center">
                        <img src="<?= $skill['icon']; ?>" alt="<?= $skill['title'] ?>" title="<?= $skill['title'] ?>" 
                            class="w-8 h-8 object-contain hover:cursor-pointer hover:scale-110 transition-transform duration-300 ease-in-out">
                        <span class="text-xs"><?= $skill['title'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-heart text-red-500"></i>
                Likes &amp; Interests
                <hr>
            </span>

            <div class="flex flex-row gap-6 justify-start text-left items-center">
                <div class="flex flex-col gap-2">
                    <p>
                        <i class="fa fa-music"></i>
                        Music
                    </p>
                    <p>
                        <i class="fa fa-dumbbell"></i>
                        Health and Fitness
                    </p>
                    <p>
                        <i class="fa fa-plane"></i>
                        Travel
                    </p>
                </div>
                <div class="flex flex-col gap-2">
                    <p>
                        <i class="fa fa-code"></i>
                        Code
                    </p>
                    <p>
                        <i class="fa fa-camera"></i>
                        Photography
                    </p>
                    <p>
                        <i class="fa fa-film"></i>
                        Movies
                    </p>
                </div>
            </div>


        </div>
    </div>

    <div class="flex flex-col justify-center py-8">
        
        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Showcase </h2>

        <div class="flex flex-row flex-wrap justify-center gap-8 py-6 my-4" data-aos="flip-down">
            <?php 
            $count = 0;
            foreach ($clients as $client) : 
            if ($count > 0 && $count % 5 == 0) {
                echo '</div><div class="flex flex-row flex-wrap justify-center gap-8 py-6 my-4" data-aos="flip-down">';
            }
            ?>
            <a href="javascript:;" title="<?= $client['name']; ?>" class="flex items-center justify-center filter grayscale <?php echo isset($client['invert']) ? 'invert' : '' ?> hover:grayscale-0 transition duration-300 ease-in-out">
                <img src="<?= $client['logo'] ?>" alt="<?= $client['name'] ?>" class="w-40 object-contain">
            </a>
            <?php 
            $count++;
            endforeach; 
            ?>
        </div>
    </div>
    
    <div class="card-bg-radial rounded-t-xl p-8 mb-4">

        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Education &amp; Experience </h2>
        
        <div class="experience flex justify-between py-8">
            <div class="flex flex-row" data-aos="fade-right">
                <div class="flex flex-col gap-6 text-left">
                    <h3>2019 - 2021</h3>

                    <p>
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

            <div class="flex flex-row" data-aos="fade-up-right">
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

            <div class="flex flex-row" data-aos="fade-up-right">
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
        </div>

        <!-- <hr class="py-5 w-sm items-center border-gray-600" /> -->

        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Latest Work </h2>

        <div class="flex flex-col justify-center py-8">
            <div class="flex flex-row justify-center gap-8 py-6 my-4">
                <?php foreach ($projects as $project) : ?>
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="card-bg-radial rounded-lg">
                            <img src="<?= image_src('assets/projects/'.$project['urlname'].'/'.$project['image']) ?>" 
                                    alt="<?= $project['title'] ?>" 
                                    class="h-auto max-w-full rounded-t-lg  object-cover w-full">
                            <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($project['title']) ?></h3>
                            
                            <p class="px-4 text-sm text-gray-300">
                                <span class="hidden lg:block"><?= $project['short_description'] ?></span>
                                <span class="hidden md:block lg:hidden"><?= cutwords($project['short_description']) ?></span>
                                <span class="block md:hidden"><?= cutwords($project['short_description'], 100) ?></span>
                            </p>

                            <a class="p-4 text-right block mt-2 text-gray-400 hover:text-brand" 
                                href="<?php url('projects/'.$project['urlname']); ?>">
                                Read more →
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center">
                <a href="<?php url('projects'); ?>" class="text-center font-mono text-2xl font-semibold py-4 underline transition ease-in-out">View all projects </a>
            </div>

        </div>

    </div>

    <?php if (count($stories) > 0) : ?>
        <!-- <hr class="py-5 border-gray-600" /> -->

        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Latest Stories </h2>

        <div class="flex flex-col justify-center py-8">
            <div class="flex flex-row justify-center gap-8 py-6 my-4">
                <?php foreach ($stories as $story) : ?>
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="card-bg-radial rounded-lg">
                            <img src="<?= image_src('assets/stories/'.$story['urlname'].'/'.$story['image'], true, 'assets/stories/default.png') ?>" 
                                    alt="<?= $story['title'] ?>" 
                                    class="h-auto w-full max-w-[400px] rounded-t-lg object-cover">
                            <h3 class="px-4 py-2 text-xl font-semibold py-3"><?= cutwords($story['title']) ?></h3>
                            
                            <p class="px-4 text-sm text-gray-300">
                                <span class="hidden lg:block"><?= $story['short_description'] ?></span>
                                <span class="hidden md:block lg:hidden"><?= cutwords($story['short_description']) ?></span>
                                <span class="block md:hidden"><?= cutwords($story['short_description']) ?></span>
                            </p>

                            <a class="p-4 text-right block mt-2 text-gray-400 hover:text-brand" 
                                href="<?php url('stories/'.$story['urlname']); ?>">
                                Read more →
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center">
                <a href="<?php url('stories'); ?>" class="text-center font-mono text-2xl font-semibold py-4 underline transition ease-in-out">View all stories </a>
            </div>

        </div>
    <?php endif; ?>

    <!-- <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Testimonials </h2> -->

</section>

<?php
require_once __DIR__ . '/../partials/footer.php'; # config file
?>