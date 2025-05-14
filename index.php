<?php
require_once __DIR__ . '/partials/header.php'; # config file
?>

    <section id="home" class="container mx-auto">
        <div class="flex gap-4 mb-4">
            <div class="flex justify-between items-center w-1/2 p-4 bg-gray-900 rounded-xl">
                <img src="https://media.licdn.com/dms/image/v2/D4E03AQElfwqbY508Og/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1729591268715?e=1747267200&v=beta&t=BUkiMNHgLPC1KYCTcfRrrfpHoBx-logWw3Xfc8GFga0" alt="Gulger Mallik" 
                    class="h-52 rounded-tl-xl rounded-br-xl">
                
                <div class="flex flex-col pl-4">
                    <p>Hi, I'm</p>
                    <h1 class="py-2 text-4xl font-bold flex-nowrap">Gulger Mallik.</h1>
                    <p class="text-gray-400">I am a Software Engineer and a Fullstack developer.</p>
                </div>
            </div>

            <div class="flex flex-col gap-4 w-1/2">
                <div class="p-4 card-bg-linear rounded-xl">
                    <p class="text-gray-500 text-sm"> 
                        <span class="text-gray-200">
                            💼
                            <a href="" class="hover:underline" target="_blank">University of Huddersfield</a>
                        </span> England, United Kingdom
                    </p>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <div class="p-4 bg-gray-900 rounded-xl">
                            <div class="flex flex-col gap-2">
                                <div class="h-32">
                                    <img src="<?= url('/assets/images/about-me.jpeg'); ?>" alt="About Me" class="h-full w-full object-cover">
                                </div>
                                <p class="text-gray-500 text-xs font uppercase"> More About Me </p>
                                <h2 class="text-lg font-semibold tracking-wider" >About Me</h2>
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="p-4 bg-gray-900 rounded-xl">
                            <div class="flex flex-col gap-2">
                                <div class="h-32">
                                    <img src="<?= url('/assets/images/projects.jpeg'); ?>" alt="Projects" class="h-full w-full object-cover">
                                </div>
                                <p class="text-gray-500 text-xs uppercase"> Showcase </p>
                                <h2 class="text-lg font-semibold tracking-wider" >Projects</h2>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex flex-row gap-4 mb-4">
            <!-- 2 divs below 20%, 60%, 20% -->
            <div class="w-1/4">
                <div class="p-4 bg-gray-900 rounded-xl">
                    <div class="flex flex-col gap-2">
                        <div class="h-32">
                            <img src="<?= url('/assets/images/stories.jpeg'); ?>" alt="Blogs" class="h-full w-full object-cover">
                        </div>
                        <p class="text-gray-500 text-xs uppercase"> Blog </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Stories</h2>
                    </div>
                </div>
            </div>

            <div class="w-2/4">
                <div class="p-4 bg-gray-900 rounded-xl">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 flex">
                            <div class="flex flex-col justify-center items-center p-4">
                                <img src="<?= url('/assets/images/coding.png'); ?>" alt="Web Development" class="dark:filter dark:invert h-full w-full object-cover">
                                <span>Web Development</span>
                            </div>

                            <div class="flex flex-col justify-center items-center p-4">
                                <img src="<?= url('/assets/images/mobile-development.png'); ?>" alt="Mobile Development" class="dark:filter dark:invert h-full w-full object-cover">
                                <span>Mobile Development</span>
                            </div>

                            <div class="flex flex-col justify-center items-center p-4">
                                <img src="<?= url('/assets/images/artificial-intelligence.png'); ?>" alt="AI and ML" class="dark:filter dark:invert h-full w-full object-cover">
                                <span>AI &amp; ML</span>
                            </div>

                            <div class="flex flex-col justify-center items-center p-4">
                                <img src="<?= url('/assets/images/research-and-development.png'); ?>" alt="Research and Development" class="dark:filter dark:invert h-full w-full object-cover">
                                <span>Research &amp; Development</span>
                            </div>

                            <div class="flex flex-col justify-center items-center p-4">
                                <img src="<?= url('/assets/images/software-development.png'); ?>" alt="Software Engineering" class="dark:filter dark:invert h-full w-full object-cover">
                                <span>Software Engineering</span>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs uppercase"> Services </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Professional Servies Offered</h2>
                    </div>
                </div>
            </div>

            <div class="w-1/4">
                <div class="p-4 card-bg-radial rounded-xl">
                    <div class="flex flex-col gap-2">
                        <div class="h-32 flex flex-col justify-center items-center p-4">
                            <div class="flex flex-row gap-2">
                                <div class="rounded-full bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="https://linkedin.com/in/mrmallik" title="LinkedIn" target="_blank" class="text-gray-200 text-3xl">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>

                                <div class="rounded-full bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="https://github.com/mr-mallik" title="GitHub" target="_blank" class="text-gray-200 text-3xl">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            
                                <div class="rounded-full bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="https://mrmallik.medium.com/" title="Instagram" target="_blank" class="text-gray-200 text-3xl">
                                        <i class="fab fa-medium"></i>
                                    </a>
                                </div>
                                <div class="rounded-full bg-gray-800 w-12 h-12 flex justify-center items-center">
                                    <a href="https://instagram.com/its_mrmallik" title="Instagram" target="_blank" class="text-gray-200 text-3xl">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 text-xs uppercase"> Let's Connect </p>
                        <h2 class="text-lg font-semibold tracking-wider" >Socials</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-row gap-4 mb-4">
            <div class="w-1/2">
                <div class="p-4 card-bg-linear rounded-xl">
                    <div class="flex flex-row gap-4 p-2 h-44">
                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-4xl">
                                <?php echo str_pad(date('Y') - 2019, 2, 0, STR_PAD_LEFT); ?>
                            </span>
                            <span class="text-gray-300">Years <br/>Experience</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-4xl">100%</span>
                            <span class="text-gray-300">Client <br/>Satisfaction</span>
                        </div>

                        <div class="flex flex-col gap-2 items-center text-center justify-center w-1/3 card-bg-radial rounded-xl">
                            <span class="dark:text-white font-bold text-4xl">+100</span>
                            <span class="text-gray-300">Hours <br/>Coded</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/2">
                <div class="p-4 bg-gray-900 rounded-xl">
                    <div class="flex flex-col gap-2">
                        <div class="h-44 px-4 py-2">
                            <!-- <p class="text-sm text-gray-500 p-1">Enter your message with contact details</p>
                            <form action="#" class="flex flex-row pb-4" method="POST" autocomplete="off">
                                <input type="text" class="w-4/5 p-2 bg-gray-800 text-gray-200 rounded-l-xl" placeholder="Your Message, Email or Mobile Number" />
                                <button type="button" class="w-1/5 py-2 px-6 bg-gray-800 dark:text-white rounded-r-xl cursor-pointer border-l border-gray-600 font-semibold">Send</button>
                            </form> -->
                            <p class="text-gray-500 text-3xl font-bold">
                                Let's <br/>
                                talk about your <span class="text-brand">next</span> project.
                                <br/> <br/>
                                <span class="text-lg text-gray-400 font-mono font-light">
                                    Send your ideas to <a href="mailto:gulgermallik@gmail.com" class="text-brand">gulgermallik@gmail.com</a>
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