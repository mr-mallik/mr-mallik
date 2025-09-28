<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the contact page
$SEO = [
    'title' => 'Contact Gulger Mallik | Software Engineer & Developer | Mr Mallik',
    'description' => 'Get in touch with Gulger Mallik (Mr Mallik) for software development projects, collaborations, or consulting. Co-founder of CosmoKode, experienced with web development and AI/ML solutions.',
    'keywords' => 'contact gulger mallik, mr mallik contact, hire software engineer uk, cosmokode contact, gulger mallik email, software development consultant',
    'url' => url('contact', false),
];

require_once __DIR__ . '/../partials/header.php';
?>

<!-- Banner Section -->
<div class="relative h-[250px] sm:h-[300px] lg:h-[400px] w-full overflow-hidden">
    <img src="<?php url('assets/images/article-footer-light.png'); ?>" alt="Contact Banner" 
         class="absolute inset-0 w-full h-full object-contain">
    
    <!-- Responsive overlay for readability -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-black/50 dark:from-black/60 dark:via-black/70 dark:to-black/80"></div>
    
    <!-- Content with proper z-index and text shadow -->
    <div class="relative z-10 flex items-center justify-center h-full px-4">
        <h1 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-center drop-shadow-2xl leading-tight max-w-4xl" data-aos="fade-up">
            Let's Connect
        </h1>
    </div>
</div>

<!-- Contact Info Section -->
<section class="container mx-auto py-8 lg:py-16 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
            <i class="fas fa-map-marker-alt text-2xl sm:text-3xl lg:text-4xl text-gray-600 dark:text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Location</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base"><?= nl2br(CONTACT_ADDRESS_2); ?></p>
        </div>
        
        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-envelope text-2xl sm:text-3xl lg:text-4xl text-gray-600 dark:text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                <a class="hover:underline brand-text" href='mailto:<?= CONTACT_EMAIL; ?>'><?= CONTACT_EMAIL; ?></a>
            </p>
        </div>

        <div class="text-center p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 md:col-span-2 lg:col-span-1" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Social Media</h3>
            <div class="flex justify-center space-x-3 lg:space-x-4 mb-4">
                <a target="_blank" href="<?= SOCIAL_LINKEDIN; ?>" class="text-xl sm:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a target="_blank" href="<?= SOCIAL_GITHUB; ?>" class="text-xl sm:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition-colors duration-300">
                    <i class="fab fa-github"></i>
                </a>
                <a target="_blank" href="<?= SOCIAL_MEDIUM; ?>" class="text-xl sm:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors duration-300">
                    <i class="fab fa-medium"></i>
                </a>
                <a target="_blank" href="<?= SOCIAL_INSTAGRAM; ?>" class="text-xl sm:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a target="_blank" href="<?= SOCIAL_FACEBOOK; ?>" class="text-xl sm:text-2xl lg:text-3xl text-gray-600 dark:text-gray-400 hover:text-blue-800 dark:hover:text-blue-500 transition-colors duration-300">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>

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