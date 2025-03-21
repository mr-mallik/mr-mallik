<?php
require_once __DIR__ . '/../partials/header.php'; # config file

$clients = [
    [
        'name' => 'Tierrasphere',
        'logo' => 'https://tierrasphere.cosmokode.com/assets/images/logo.png',
        'url' => 'https://tierrasphere.cosmokode.com/'
    ],
    [
        'name' => 'Crowther Accountants',
        'logo' => 'https://www.crowther.accountants/wp-content/themes/crowther/public/images/logo.svg',
        'url' => 'https://www.crowther.accountants/'
    ],
    [
        'name' => 'Muscle Mind Stories',
        'logo' => 'https://musclemindstories.com/assets/images/mms-large-side.png',
        'url' => 'https://musclemindstories.com/',
        'invert' => true
    ],
    [
        'name' => 'Ramjan Interiors',
        'logo' => 'https://www.ramjaninteriors.com/assets/img/logo/ri-logo-large-white.png',
        'url' => 'https://www.ramjaninteriors.com/'
    ],
    [
        'name' => 'University of Huddersfield',
        'logo' => 'https://www.hud.ac.uk/media/universityofhuddersfield/styleassets/images/2016homepageimages/uoh-logo-2019-white.svg',
        'url' => 'https://www.hud.ac.uk/'
    ]
];

$experience = dateDiff('2019-05-27', date('Y-m-d'));

$projects = projectList(4);
$stories = [];
$skills = getSkills($type=['tech', 'frame', 'db']);
// $stories = getMediumRssFeed();
// dfa($stories);
// exit;
?>

<section id="about" class="container mx-auto">
    
    <h1 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">About Me </h1>

    <div class="flex flex-row card-bg-radial rounded-b-xl p-4 py-8 mb-4" data-aos="zoom-in">

        <div class="flex flex-col w-1/4 gap-4 text-left p-4">
            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-user"></i>
                Biography
                <hr>
            </span>

            <p class="text-justify">
                I am a software engineer and fullstack developer with a passion for AI and machine learning. I have a Master's degree in Computing from the University of Huddersfield, UK. I have worked as a software engineer in India and the UK. I have experience in developing web applications, mobile applications, and AI models.
            </p>

            <span class="text-gray-500 text-lg font-semibold text-right">
                <i class="fa fa-envelope"></i>
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

                <p>
                    <a href="tel:07767924720">07767924720</a>
                </p>
            </div>

            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-gears"></i>
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

        <div class="flex flex-col w-2/4 text-center">

        </div>

        <div class="flex flex-col w-1/4 gap-6 text-right">
            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-clock"></i>
                Credibility
                <hr>
            </span>

            <div class="text-left">
                <span class="text-6xl font-bold pb-4 font-mono">2</span> <span class="uppercase text-xs text-gray-400">professionl degrees</span>
                <br/>
                <span class="text-6xl font-bold font-mono"><?= $experience['years']; ?></span> <span class="uppercase text-xs text-gray-400">years</span>
                <span class="text-6xl font-bold font-mono"><?= $experience['months']; ?></span> <span class="uppercase text-xs text-gray-400">months</span>
                <span class="text-6xl font-bold font-mono"><?= $experience['days']; ?></span> <span class="uppercase text-xs text-gray-400">days</span>
                <br/>
                <span class="text-upper text-gray-400 text-sm">of professional experience</span>
            </div>

            <span class="text-left text-gray-500 text-lg font-semibold">
                <i class="fa fa-chart-simple"></i>
                Skills
                <hr>
            </span>

            <div class="flex flex-row flex-wrap gap-4 text-left">
                <?php foreach ($skills as $skill) : ?>
                    <div class="flex flex-col gap-2 text-center justify-center items-center">
                        <img src="<?= $skill['icon']; ?>" alt="<?= $skill['title'] ?>" title="<?= $skill['title'] ?>" class="w-8 h-8 object-contain">
                        <span class="text-xs"><?= $skill['title'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <span class="text-gray-500 text-lg font-semibold">
                <i class="fa fa-heart"></i>
                Interests
                <hr>
            </span>

            <div class="flex flex-col gap-2 text-left">
                <p>
                    <i class="fa fa-music"></i>
                    Listening to music
                </p>

                <p>
                    <i class="fa fa-dumbbell"></i>
                    Health and fitness
                </p>

                <p>
                    <i class="fa fa-plane"></i>
                    Travelling
                </p>
            </div>


        </div>
    </div>

    <div class="flex flex-col justify-center py-8">
        
        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Showcase </h2>

        <div class="flex flex-row justify-center gap-8 py-6 my-4" data-aos="flip-down">
            <?php foreach ($clients as $client) : ?>
                <a href="javascript:;" title="<?= $client['name']; ?>" class="flex items-center justify-center filter grayscale <?php echo isset($client['invert']) ? 'invert' : '' ?> hover:grayscale-0 transition duration-300 ease-in-out">
                    <img src="<?= $client['logo'] ?>" alt="<?= $client['name'] ?>" class="w-40 object-contain">
                </a>
            <?php endforeach; ?>
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
                        Software Engineer and Fullstack developer <br/>
                        <span>Self Employed, mr. mallik</span>
                    </p>

                    <p>
                        <i class="fa fa-briefcase"></i>
                        Research Assistant in Applied AI <br/>
                        <span>University of Huddersfield, UK</span>
                    </p>
                    
                </div>
            </div>
        </div>

        <hr class="py-5" />

        <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Latest Work </h2>

        <div class="flex flex-col justify-center py-8">
            <div class="flex flex-row justify-center gap-8 py-6 my-4">
                <?php foreach ($projects as $project) : ?>
                    <div class="card-bg-radial flex flex-col w-1/4 p-4 rounded-3xl" data-aos="fade-up">
                        <div class="">
                            <img src="<?= url('assets/projects/'.$project['urlname'].'/'.$project['image']) ?>" alt="<?= $project['title'] ?>" class="object-cover rounded-xl w-full">
                        </div>
                        <h3 class="text-2xl font-semibold py-4"><?= $project['title'] ?></h3>
                        <p class="text-justify font-light"><?= cutwords($project['short_description']) ?></p>
                        <a class="text-right" href="<?php url('projects/'.$project['urlname']); ?>">Read more </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="flex justify-center">
                <a href="<?php url('projects'); ?>" class="text-center font-mono text-2xl font-semibold py-4 underline transition ease-in-out">View all projects </a>
            </div>

        </div>
        
        <?php if (count($stories) > 0) : ?>
            <hr class="py-5" />

            <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Latest Stories </h2>

            <div class="flex flex-col justify-center py-8">
                <div class="flex flex-row justify-center gap-8 py-6 my-4">
                    <?php foreach ($stories as $story) : ?>
                        <div class="card-bg-radial flex flex-col w-1/4 p-4 rounded-3xl" data-aos="fade-up">
                            <div class="">
                                <img src="<?= url('assets/projects/'.$project['urlname'].'/'.$project['image']) ?>" alt="<?= $project['title'] ?>" class="object-cover rounded-xl w-full">
                            </div>
                            <h3 class="text-2xl font-semibold py-4"><?= $project['title'] ?></h3>
                            <p class="text-justify font-light"><?= cutwords($project['short_description']) ?></p>
                            <a class="text-right text-mono hover:underline" href="<?php url('projects/'.$project['urlname']); ?>">Read more </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="flex justify-center">
                    <a href="<?php url('stories'); ?>" class="text-center font-mono text-2xl font-semibold py-4 underline transition ease-in-out">View all stories </a>
                </div>

            </div>
        <?php endif; ?>

    </div>

    <!-- <h2 class="text-center text-5xl p-8 font-semibold" data-aos="fade-left">Testimonials </h2> -->

</section>

<?php
require_once __DIR__ . '/../partials/footer.php'; # config file
?>