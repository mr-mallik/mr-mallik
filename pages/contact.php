<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the contact page
$SEO = [
    'title' => 'Contact Gulger Mallik | Software Engineer | Mr Mallik',
    'description' => 'Get in touch for software development projects, collaborations, or consulting. Co-founder of CosmoKode with web & AI/ML expertise.',
    'keywords' => 'contact gulger mallik, mr mallik contact, hire software engineer uk, cosmokode contact, gulger mallik email, software development consultant',
    'image' => url('assets/images/og-image.png', false),
    'url' => url('contact', false),
];

require_once __DIR__ . '/../partials/header.php';
?>

<!-- Page Header -->
<section class="container mx-auto pt-8 lg:pt-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 lg:mb-8 text-center">Contact</h1>
    <div class="w-full mb-8 lg:mb-12">
        <img src="<?= url('assets/images/article-footer-light.png', false); ?>" 
             alt="Contact Banner" 
             class="w-full h-auto object-contain block dark:hidden"
             id="banner-light">
        <img src="<?= url('assets/images/article-footer-dark.png', false); ?>" 
             alt="Contact Banner" 
             class="w-full h-auto object-contain hidden dark:block"
             id="banner-dark">
    </div>
</section>

<!-- Contact Info Section -->
<section class="container mx-auto py-4 lg:py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
            <div class="flex justify-center mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="office-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#830eae;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#fe952d;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path d="M3 21h18M5 21V7l8-4v18M19 21V10l-6-3M9 9h.01M9 12h.01M9 15h.01M9 18h.01" stroke="url(#office-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Location</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base"><?= nl2br(CONTACT_ADDRESS_2); ?></p>
        </div>
        
        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
            <div class="flex justify-center mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8" viewBox="0 0 256 193" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                    <path d="M58.182 192.05V93.14L27.507 65.077 0 49.504v125.091c0 9.658 7.825 17.455 17.455 17.455h40.727Z" fill="#4285F4"/>
                    <path d="M197.818 192.05h40.727c9.659 0 17.455-7.826 17.455-17.455V49.504l-31.156 17.837-27.026 25.798v98.91Z" fill="#34A853"/>
                    <path d="m58.182 93.14-4.174-38.647 4.174-36.989L128 69.868l69.818-52.364 4.669 34.992-4.669 40.644L128 145.504z" fill="#EA4335"/>
                    <path d="M197.818 17.504V93.14L256 49.504V26.231c0-21.585-24.64-33.89-41.89-20.945l-16.292 12.218Z" fill="#FBBC04"/>
                    <path d="m0 49.504 26.759 20.07L58.182 93.14V17.504L41.89 5.286C24.61-7.66 0 4.646 0 26.23v23.273Z" fill="#C5221F"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                Drop me a line at
            </p>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                <a class="hover:underline brand-text" href='mailto:<?= CONTACT_EMAIL; ?>'><?= CONTACT_EMAIL; ?></a>
            </p>
        </div>

        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 md:col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="200">
            <div class="flex justify-center space-x-3 lg:space-x-4 mb-4">
                <!-- LinkedIn -->
                <a target="_blank" href="<?= SOCIAL_LINKEDIN; ?>" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 hover:scale-110 transition-transform duration-300" title="LinkedIn">
                    <svg viewBox="0 0 24 24" fill="#0077B5" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                
                <!-- GitHub -->
                <a target="_blank" href="<?= SOCIAL_GITHUB; ?>" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 hover:scale-110 transition-transform duration-300" title="GitHub">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="text-gray-900 dark:text-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                
                <!-- Medium -->
                <a target="_blank" href="<?= SOCIAL_MEDIUM; ?>" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 hover:scale-110 transition-transform duration-300" title="Medium">
                    <svg viewBox="0 0 24 24" fill="#00AB6C" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/>
                    </svg>
                </a>
                
                <!-- Instagram -->
                <a target="_blank" href="<?= SOCIAL_INSTAGRAM; ?>" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 hover:scale-110 transition-transform duration-300" title="Instagram">
                    <svg viewBox="0 0 24 24" fill="url(#instagram-gradient)" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="instagram-gradient" x1="0%" y1="100%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#F77737;stop-opacity:1" />
                                <stop offset="50%" style="stop-color:#FD1D1D;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#833AB4;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                
                <!-- Facebook -->
                <a target="_blank" href="<?= SOCIAL_FACEBOOK; ?>" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-8 lg:h-8 hover:scale-110 transition-transform duration-300" title="Facebook">
                    <svg viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Social Links</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                Interested in collaborating?<br/>
                <a class="hover:underline brand-text" href="mailto:<?= CONTACT_EMAIL; ?>">Let's talk!</a>
            </p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<!-- <section class="container mx-auto py-16 px-4">
    <div class="flex flex-col lg:flex-row gap-8 items-center">
        <div class="w-full lg:w-1/2">
            <form class="max-w-2xl mx-auto" data-aos="fade-up">
                <h2 class="text-4xl font-semibold pb-16" data-aos="fade-top">Drop a Line</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <input type="text" placeholder="Your Name" class="w-full p-3 border rounded">
                    <input type="email" placeholder="Your Email" class="w-full p-3 border rounded">
                </div>
                <input type="text" placeholder="Subject" class="w-full p-3 border rounded mb-6">
                <textarea placeholder="Your Message" rows="6" class="w-full p-3 border rounded mb-6"></textarea>
                <button type="submit" class="bg-gray-600 text-white px-8 py-3 rounded hover:bg-brand hover:text-black hover:font-bold transition">Send Message</button>
            </form>
        </div>
        <div class="card hidden lg:block w-full lg:w-1/2" data-aos="fade-top">
            <img src="" alt="Contact Illustration" 
                class="grayscale max-h-[600px] w-full object-cover rounded-lg shadow-lg">
        </div>
    </div>
</section> -->

<!-- Social Links Section -->
<!-- <section class="container mx-auto py-16 px-4 text-center">
    <div class="flex justify-center space-x-6" data-aos="fade-up">
        <a target="_blank" href="<?= SOCIAL_LINKEDIN; ?>" class="text-4xl text-gray-600"><i class="fab fa-linkedin"></i></a>
        <a target="_blank" href="<?= SOCIAL_GITHUB; ?>" class="text-4xl text-gray-600"><i class="fab fa-github"></i></a>
        <a target="_blank" href="<?= SOCIAL_MEDIUM; ?>" class="text-4xl text-gray-600"><i class="fab fa-medium"></i></a>
        <a target="_blank" href="<?= SOCIAL_INSTAGRAM; ?>" class="text-4xl text-gray-600"><i class="fab fa-instagram"></i></a>
        <a target="_blank" href="<?= SOCIAL_FACEBOOK; ?>" class="text-4xl text-gray-600"><i class="fab fa-facebook"></i></a>
    </div>
</section> -->

<!-- Google Maps Section -->
<!-- <section class="container mx-auto py-16 px-4">
    <div class="w-full h-[400px] rounded-lg overflow-hidden" data-aos="fade-up">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1000!2d-73.9857!3d40.7484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1234567890"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>
</section> -->

<!-- Signature Section -->
<!-- <section class="container mx-auto py-16 px-4 text-center">
    <div class="relative inline-block">
        <span class="absolute -top-4 -left-4 text-4xl font-mono">The</span>
        <span class="signature px-8 py-4 ">mr mallik</span>
        <span class="absolute -bottom-4 -right-4 text-4xl font-mono">way</span>
    </div>
</section> -->

<?php
require_once __DIR__ . '/../partials/footer.php';
?>