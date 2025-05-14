<?php
require_once __DIR__ . '/../partials/header.php';
?>

<!-- Banner Section -->
<div class="relative h-[400px] w-full">
    <img src="/assets/images/contact-banner.jpg" alt="Contact Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <h1 class="text-white text-6xl font-bold" data-aos="fade-up">Let's Connect</h1>
    </div>
</div>

<!-- Contact Info Section -->
<section class="container mx-auto py-16 px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-6 shadow-lg rounded-lg" data-aos="fade-right">
            <i class="fas fa-phone text-3xl text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Phone</h3>
            <p><a class="hover:underline" href='tel:<?= CONTACT_PHONE; ?>'><?= CONTACT_PHONE2; ?></a></p>
        </div>
        <div class="text-center p-6 shadow-lg rounded-lg" data-aos="fade-up">
            <i class="fas fa-map-marker-alt text-3xl text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Office Address</h3>
            <p><?= nl2br(CONTACT_ADDRESS_2); ?></p>
        </div>
        <div class="text-center p-6 shadow-lg rounded-lg" data-aos="fade-left">
            <i class="fas fa-envelope text-3xl text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Email</h3>
            <p>
                <a class="hover:underline" href='mailto:<?= CONTACT_EMAIL; ?>'><?= CONTACT_EMAIL; ?></a>
                <br/>
                <a class="hover:underline" href='mailto:<?= CONTACT_EMAIL2; ?>'><?= CONTACT_EMAIL2; ?></a>
            </p>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="container mx-auto py-16 px-4">
    <h2 class="text-3xl font-semibold mb-8 text-center" data-aos="fade-up">Drop a Line</h2>
    <div class="flex flex-col lg:flex-row gap-8 items-center">
        <div class="w-full lg:w-1/2">
            <form class="max-w-2xl mx-auto" data-aos="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <input type="text" placeholder="Your Name" class="w-full p-3 border rounded">
                    <input type="email" placeholder="Your Email" class="w-full p-3 border rounded">
                </div>
                <input type="text" placeholder="Subject" class="w-full p-3 border rounded mb-6">
                <textarea placeholder="Your Message" rows="6" class="w-full p-3 border rounded mb-6"></textarea>
                <button type="submit" class="bg-gray-600 text-white px-8 py-3 rounded hover:bg-brand hover:text-black hover:font-bold transition">Send Message</button>
            </form>
        </div>
        <div class="card hidden lg:block w-full lg:w-1/2" data-aos="fade-left">
            <img src="<?php url('assets/images/contact-me.jpg');?>" alt="Contact Illustration" class="w-full filter grayscale">
        </div>
    </div>
</section>

<!-- Social Links Section -->
<section class="container mx-auto py-16 px-4 text-center">
    <h2 class="text-3xl font-semibold mb-8" data-aos="fade-up">Connect With Me</h2>
    <div class="flex justify-center space-x-6" data-aos="fade-up">
        <a target="_blank" href="<?= SOCIAL_LINKEDIN; ?>" class="text-4xl text-gray-600 hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
        <a target="_blank" href="<?= SOCIAL_GITHUB; ?>" class="text-4xl text-gray-600 hover:text-gray-900"><i class="fab fa-github"></i></a>
        <a target="_blank" href="<?= SOCIAL_MEDIUM; ?>" class="text-4xl text-gray-600 hover:text-gray-900"><i class="fab fa-medium"></i></a>
        <a target="_blank" href="<?= SOCIAL_INSTAGRAM; ?>" class="text-4xl text-gray-600 hover:text-pink-600"><i class="fab fa-instagram"></i></a>
        <a target="_blank" href="<?= SOCIAL_FACEBOOK; ?>" class="text-4xl text-gray-600 hover:text-blue-600"><i class="fab fa-facebook"></i></a>
    </div>
</section>

<!-- Google Maps Section -->
<section class="container mx-auto py-16 px-4">
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
</section>

<!-- Signature Section -->
<section class="container mx-auto py-16 px-4 text-center">
    <div class="relative inline-block">
        <span class="absolute -top-4 -left-4 text-4xl font-mono">The</span>
        <span class="signature px-8 py-4 ">mr mallik</span>
        <span class="absolute -bottom-4 -right-4 text-4xl font-mono">way</span>
    </div>
</section>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>