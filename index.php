<?php
require_once __DIR__ . '/partials/header.php'; # config file
?>

    <section id="home" class="container mx-auto px-10">
        <div class="flex flex-col lg:flex-row gap-4 mb-4">
            <div class="w-full lg:w-1/2">
                <div class="flex items-center w-full p-4 gap-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <img src="<?= url('/assets/images/gulger-mallik@1x1.jpg'); ?>" 
                    alt="Gulger Mallik" 
                    class="h-55 xl:h-65 rounded-tl-xl rounded-br-xl hover:grayscale transition-all duration-300 ease-in-out">
                    
                    <div class="flex flex-col pl-4">
                        <p class='text-gray-800 dark:text-gray-400'>Hello, I'm</p>
                        <h1 class="py-2 text-2xl xl:text-4xl font-bold flex-nowrap text-gray-900 dark:text-white">Gulger Mallik.</h1>
                        <p class="text-gray-800 dark:text-gray-400">I am a Software Engineer <br/>and a Fullstack developer.</p>
                        <p class="text-gray-800 dark:text-gray-400 text-xs mt-4 text-justify block lg:hidden xl:block">
                            Passionate about building
                            scalable web and mobile applications, enthusiastic about
                            learning new technologies, and committed to delivering high-quality software solutions. 
                            Techenthusiast with a keen interest in AI and machine learning, always eager to explore innovative solutions to complex problems.
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col gap-4">
                <div class="hidden lg:block p-4 card-bg-linear rounded-xl shadow-lg">
                    <p class="text-gray-800 dark:text-gray-500 text-sm flex items-center gap-2"> 
                        <i class="fas fa-briefcase"></i>
                        <a href="<?= url('about#edu-experience'); ?>" class="hover:underline text-gray-900 dark:text-gray-200">University of Huddersfield</a>
                        <span class='text-gray-500 dark:text-gray-400'>England, United Kingdom</span>
                    </p>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <a href="<?= url('about'); ?>">
                            <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                                <div class="flex flex-col gap-2">
                                    <div class="h-32 overflow-hidden">
                                        <img src="<?= url('/assets/images/about-me.jpeg'); ?>" alt="About Me" class="dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-500 text-xs font uppercase"> More About Me </p>
                                    <h2 class="text-lg font-semibold tracking-wider" >About Me</h2>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="w-1/2">
                        <a href="<?= url('projects'); ?>">
                            <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                                <div class="flex flex-col gap-2">
                                    <div class="h-32 overflow-hidden">
                                        <img src="<?= url('/assets/images/projects.jpeg'); ?>" alt="Projects" class="dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-500 text-xs uppercase"> Showcase </p>
                                    <h2 class="text-lg font-semibold tracking-wider" >Projects</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row gap-4 mb-4">
            <!-- 2 divs below 20%, 60%, 20% -->
            <div class="w-2/2 lg:w-1/4">
                <a href="<?= url('stories'); ?>">
                <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 overflow-hidden">
                            <img src="<?= url('/assets/images/stories.jpeg'); ?>" alt="Blogs" class="dark:grayscale hover:grayscale-0 transition-all duration-300 ease-in-out">
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase"> Blog </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Stories</h2>
                    </div>
                </div>
                </a>
            </div>

            <div class="hidden lg:block lg:w-2/4">
                <div class="p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 flex">
                            <div class="flex flex-row justify-between items-center w-full">
                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/coding.png'); ?>" alt="Web Development" class="dark:invert opacity-60 w-8 sm:w-12 md:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1'>Web Development</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/mobile-development.png'); ?>" alt="Mobile Development" class="dark:invert opacity-60 w-8 sm:w-12 md:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1'>Mobile Development</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/artificial-intelligence.png'); ?>" alt="AI and ML" class="dark:invert opacity-60 w-8 sm:w-12 md:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1'>AI &amp; ML</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/research-and-development.png'); ?>" alt="Research and Development" class="dark:invert opacity-60 w-8 sm:w-12 md:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1'>R&amp;D</span>
                                </div>

                                <div class="flex flex-col justify-center items-center p-2 text-center flex-1">
                                    <img src="<?= url('/assets/images/software-development.png'); ?>" alt="Software Engineering" class="dark:invert opacity-60 w-8 sm:w-12 md:w-16">
                                    <span class='text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 pt-1'>Software Engineering</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase"> Services </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Professional Servies Offered</h2>
                    </div>
                </div>
            </div>

            <div class="w-2/2 lg:w-1/4">
                <div class="p-4 card-bg-radial rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 flex flex-col justify-center items-center p-4">
                            <div class="flex flex-row gap-2">
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_LINKEDIN ?>" title="LinkedIn" target="_blank" class="text-gray-900 dark:text-gray-200 text-3xl">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>

                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_GITHUB ?>" title="GitHub" target="_blank" class="text-gray-900 dark:text-gray-200 text-3xl">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_MEDIUM ?>" title="Medium" target="_blank" class="text-gray-900 dark:text-gray-200 text-3xl">
                                        <i class="fab fa-medium"></i>
                                    </a>
                                </div>
                                <div class="rounded-full bg-gray-300 shadow-lg dark:bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="<?= SOCIAL_INSTAGRAM ?>" title="Instagram" target="_blank" class="text-gray-900 dark:text-gray-200 text-3xl">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-500 text-xs uppercase"> Let's Connect </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Socials</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 mb-4">
            <div class="w-full lg:w-1/2">
                <div class="p-4 card-bg-linear rounded-xl shadow-lg">
                    <div class="flex flex-row gap-4 p-2 h-44">
                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-3xl xl:text-4xl" id="years">
                                <?php 
                                $years = date('Y') - 2019;
                                echo str_pad($years, 2, 0, STR_PAD_LEFT); ?>+
                            </span>
                            <span class="text-gray-700 dark:text-gray-300">Years of <br/>Experience</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-3xl xl:text-4xl" id="happyClients">100%</span>
                            <span class="text-gray-700 dark:text-gray-300">Happy <br/>Clients</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-3xl xl:text-4xl" id="codingHours">
                                <?php 
                                $codingHours = $years * 365 * 5; // years * days in a year * daily coding hours
                                echo '+' . $codingHours ?>
                            </span>
                            <span class="text-gray-700 dark:text-gray-300">Coding <br/>Hours</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="p-2 lg:p-4 bg-gray-300 dark:bg-gray-900 rounded-xl shadow-lg">
                    <div class="flex flex-col gap-2">
                        <div class="lg:h-44 px-4 lg:py-2">
                            <p class="text-gray-700 dark:text-gray-500 text-xl xl:text-3xl font-bold">
                                Let's <br/>
                                talk about your <span class="brand-text">next</span> project.
                                <br/> <br/>
                                <span class="text-lg text-gray-600 dark:text-gray-400 font-mono font-light">
                                    Send your ideas to <a href="mailto:gulgermallik@gmail.com" class="brand-text">gulgermallik@gmail.com</a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

<?php
require_once __DIR__ . '/partials/footer.php'; # config file
?>