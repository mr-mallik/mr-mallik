<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(503);

// Set SEO data for the 503 page
$SEO = [
    'title' => '503 - Service Unavailable | Gulger Mallik',
    'description' => 'The service is temporarily unavailable. Please try again later.',
    'keywords' => 'gulger mallik, mr mallik, 503, service unavailable, maintenance',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('503', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #8b5cf6, #a855f7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(139, 92, 246, 0.3);
    }
    
    .bounce {
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code bounce mb-8">503</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Service Unavailable</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                The service is temporarily unavailable due to maintenance or overload. 
                Please try again in a few minutes.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-clock text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Wait a Moment</h3>
                <p class="text-gray-400 text-sm mb-4">Try refreshing the page in a few minutes</p>
                <button onclick="setTimeout(() => location.reload(), 5000)" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Auto Refresh (5s)
                </button>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">The homepage might still be accessible</p>
                <a href="<?= url(''); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-envelope text-purple-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Contact Me</h3>
                <p class="text-gray-400 text-sm mb-4">Let me know if this persists</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Get In Touch
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">What's Happening?</h3>
            <p class="text-gray-400 mb-6">
                The server is temporarily unable to handle your request due to maintenance, 
                updates, or high traffic. This is usually temporary.
            </p>
            <div class="flex justify-center gap-4">
                <a href="mailto:<?= strtolower(CONTACT_EMAIL); ?>" class="text-blue-400 hover:text-blue-300 transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Email Me
                </a>
                <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors">
                    <i class="fab fa-linkedin mr-2"></i>LinkedIn
                </a>
                <a href="<?= SOCIAL_GITHUB; ?>" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors">
                    <i class="fab fa-github mr-2"></i>GitHub
                </a>
            </div>
        </div>

        <!-- Fun Fact -->
        <div class="mt-12 text-center">
            <p class="text-gray-500 text-sm">
                <i class="fas fa-tools mr-2"></i>
                Fun Fact: HTTP 503 errors are often used during planned maintenance. 
                Good things are coming!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
