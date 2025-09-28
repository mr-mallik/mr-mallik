<?php
require_once __DIR__ . '/includes/common.php'; # config file

// SEO configuration for the homepage
$SEO = [
    'title' => 'Gulger Mallik | Software Engineer & Full Stack Developer | Mr Mallik',
    'description' => 'Gulger Mallik (Mr Mallik) is a Software Engineer and Full Stack Developer with expertise in web development, mobile apps, AI/ML. Based in UK, worked with University of Huddersfield, Crowther Accountants, Tierrasphere, CosmoKode.',
    'keywords' => 'gulger mallik, mr mallik, gulger mallik software engineer, mr mallik developer, full stack developer uk, web development, mobile development, ai machine learning, university of huddersfield, crowther accountants, tierrasphere, cosmokode, team inertia technologies, trellissoft',
    'image' => url('assets/images/gulger-mallik@1x1.jpg', false),
    'url' => url('', false),
];

require_once __DIR__ . '/partials/header.php'; # config file
?>

    <section id="home" class="container mx-auto px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col lg:flex-row gap-4 mb-4">
            <div class="w-full lg:w-1/2">
                <div class="flex flex-col sm:flex-row items-center w-full p-4 sm:p-6 gap-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <img src="<?= url('/assets/images/gulger-mallik@1x1.jpg'); ?>" 
                    alt="Gulger Mallik" 
                    class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 lg:w-40 lg:h-40 xl:w-52 xl:h-52 rounded-tl-xl rounded-br-xl hover:grayscale transition-all duration-300 ease-in-out object-cover">
                    
                    <div class="flex flex-col text-center sm:text-left sm:pl-4">
                        <p class='text-gray-800 dark:text-gray-400 text-sm sm:text-base'>Hello, I'm</p>
                        <h1 class="py-2 text-xl sm:text-2xl md:text-3xl xl:text-4xl font-bold text-gray-900 dark:text-white">Gulger Mallik.</h1>
                        <p class="text-gray-800 dark:text-gray-400 text-sm sm:text-base">I am a Software Engineer, Researcher <br class="hidden sm:block"/>and a Fullstack developer.</p>
                        <!-- <p class="text-gray-800 dark:text-gray-400 text-xs sm:text-sm mt-4 text-justify block md:hidden lg:block xl:hidden">
                            Passionate about building applications. Tech enthusiast with interest in AI/ML, always eager to solve complex problems.
                        </p> -->
                        <p class="text-gray-800 dark:text-gray-400 text-xs sm:text-sm mt-4 text-justify"> <!-- hidden md:block lg:hidden xl:block -->
                            Tech enthusiast with a keen interest in AI and machine learning, always eager to explore innovative solutions to complex problems.
                            Passionate about building solutions that make a difference.
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col gap-4">
                <div class="hidden lg:block p-4 card-bg-linear rounded-xl shadow-lg">
                    <p class="text-gray-800 dark:text-gray-500 text-sm flex items-center gap-2 flex-wrap"> 
                        <i class="fas fa-briefcase"></i>
                        <a href="<?= url('about#edu-experience'); ?>" class="hover:underline text-gray-900 dark:text-gray-200">University of Huddersfield</a>
                        <span class='text-gray-500 dark:text-gray-400'>England, United Kingdom</span>
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/2">
                        <a href="<?= url('about'); ?>">
                            <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex flex-col gap-2">
                                    <div class="h-24 sm:h-32 overflow-hidden rounded-lg">
                                        <img src="<?= url('/assets/images/about-me.jpeg'); ?>" alt="About Me" class="w-full object-cover dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-500 text-xs uppercase tracking-wide"> More About Me </p>
                                    <h2 class="text-base sm:text-lg font-semibold tracking-wider text-gray-900 dark:text-white">About Me</h2>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="w-full sm:w-1/2">
                        <a href="<?= url('projects'); ?>">
                            <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex flex-col gap-2">
                                    <div class="h-24 sm:h-32 overflow-hidden rounded-lg">
                                        <img src="<?= url('/assets/images/projects.jpeg'); ?>" alt="Projects" class="w-full object-cover dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-500 text-xs uppercase tracking-wide"> Showcase </p>
                                    <h2 class="text-base sm:text-lg font-semibold tracking-wider text-gray-900 dark:text-white">Projects</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-4">
            <!-- Stories Card -->
            <div class="w-full sm:w-1/2 lg:w-1/4">
                <a href="<?= url('blogs'); ?>">
                <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex flex-col gap-2">
                        <div class="h-24 sm:h-32 overflow-hidden rounded-lg">
                            <img src="<?= url('/assets/images/stories.jpeg'); ?>" alt="Blogs" class="w-full object-cover dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase tracking-wide"> Blog </p>
                        <h2 class="text-base sm:text-lg font-semibold tracking-wider text-gray-900 dark:text-white">Stories</h2>
                    </div>
                </div>
                </a>
            </div>

            <!-- Services Card - Hidden on mobile, shown on large screens -->
            <div class="hidden lg:block lg:w-2/4">
                <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 flex">
                            <div class="flex flex-row justify-between items-center w-full">
                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/coding.png'); ?>" alt="Web Development" class="dark:invert opacity-60 w-8 sm:w-10 lg:w-12 xl:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1 text-center'>Web Development</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/mobile-development.png'); ?>" alt="Mobile Development" class="dark:invert opacity-60 w-8 sm:w-10 lg:w-12 xl:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1 text-center'>Mobile Development</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/artificial-intelligence.png'); ?>" alt="AI and ML" class="dark:invert opacity-60 w-8 sm:w-10 lg:w-12 xl:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1 text-center'>AI &amp; ML</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/research-and-development.png'); ?>" alt="Research and Development" class="dark:invert opacity-60 w-8 sm:w-10 lg:w-12 xl:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1 text-center'>R&amp;D</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/software-development.png'); ?>" alt="Software Engineering" class="dark:invert opacity-60 w-8 sm:w-10 lg:w-12 xl:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1 text-center'>Software Engineering</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase tracking-wide"> Services </p>
                        <h2 class="text-base sm:text-lg font-semibold tracking-wider text-gray-900 dark:text-white">Professional Services Offered</h2>
                    </div>
                </div>
            </div>

            <!-- Social Links Card -->
            <div class="w-full sm:w-1/2 lg:w-1/4">
                <div class="p-4 card-bg-radial rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="h-24 sm:h-32 flex flex-col justify-center items-center p-2">
                            <div class="flex flex-row gap-2 justify-center">
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_LINKEDIN ?>" title="LinkedIn" target="_blank" class="text-gray-900 dark:text-gray-200 text-sm sm:text-base lg:text-xl xl:text-2xl">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>

                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_GITHUB ?>" title="GitHub" target="_blank" class="text-gray-900 dark:text-gray-200 text-sm sm:text-base lg:text-xl xl:text-2xl">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_MEDIUM ?>" title="Medium" target="_blank" class="text-gray-900 dark:text-gray-200 text-sm sm:text-base lg:text-xl xl:text-2xl">
                                        <i class="fab fa-medium"></i>
                                    </a>
                                </div>
                                
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_INSTAGRAM ?>" title="Instagram" target="_blank" class="text-gray-900 dark:text-gray-200 text-sm sm:text-base lg:text-xl xl:text-2xl">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase tracking-wide"> Let's Connect </p>
                        <h2 class="text-base sm:text-lg font-semibold tracking-wider text-gray-900 dark:text-white">Socials</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 mb-4">
            <div class="w-full lg:w-1/2">
                <div class="p-4 lg:p-6 card-bg-linear rounded-xl shadow-lg">
                    <div class="flex flex-col sm:flex-row gap-4 p-2 min-h-[160px] sm:min-h-[180px]">
                        <div class="flex flex-col gap-2 items-center text-center justify-center flex-1 card-bg-radial rounded-xl p-4">
                            <span class="text-gray-900 dark:text-white font-bold text-2xl sm:text-3xl xl:text-4xl" id="years">
                                <?php 
                                $years = date('Y') - 2019;
                                echo str_pad($years, 2, 0, STR_PAD_LEFT); ?>+
                            </span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm text-center">Years of <br/>Experience</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center flex-1 card-bg-radial rounded-xl p-4">
                            <span class="text-gray-900 dark:text-white font-bold text-2xl sm:text-3xl xl:text-4xl" id="happyClients">100%</span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm text-center">Happy <br/>Clients</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center flex-1 card-bg-radial rounded-xl p-4">
                            <span class="text-gray-900 dark:text-white font-bold text-2xl sm:text-3xl xl:text-4xl" id="codingHours">
                                <?php 
                                $codingHours = $years * 365 * 5; // years * days in a year * daily coding hours
                                echo '+' . number_format($codingHours); ?>
                            </span>
                            <span class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm text-center">Coding <br/>Hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="p-4 lg:p-6 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="min-h-[160px] sm:min-h-[180px] px-2 lg:px-4 py-4 flex flex-col justify-center">
                            <p class="text-gray-700 dark:text-gray-500 text-lg sm:text-xl xl:text-3xl font-bold leading-relaxed">
                                Let's <br/>
                                talk about your <span class="brand-text">next</span> project.
                            </p>
                            <div class="mt-4 lg:mt-6">
                                <span class="text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 font-mono font-light">
                                    Send your ideas to <br class="sm:hidden"/>
                                    <a href="mailto:gulgermallik@gmail.com" class="brand-text hover:underline">gulgermallik@gmail.com</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

<?php
require_once __DIR__ . '/partials/footer.php'; # config file
?>