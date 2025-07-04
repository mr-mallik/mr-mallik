<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(502);

// Set SEO data for the 502 page
$SEO = [
    'title' => '502 - Bad Gateway | Gulger Mallik',
    'description' => 'The server received an invalid response from the upstream server.',
    'keywords' => 'gulger mallik, mr mallik, 502, bad gateway, server error',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('502', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #e11d48, #f43f5e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(225, 29, 72, 0.3);
    }
    
    .flicker {
        animation: flicker 1.5s infinite;
    }
    
    @keyframes flicker {
        0%, 100% { opacity: 1; }
        25% { opacity: 0.8; }
        50% { opacity: 0.3; }
        75% { opacity: 0.9; }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code flicker mb-8">502</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Bad Gateway</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                The server received an invalid response from the upstream server. 
                This is usually a temporary issue with the server configuration.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-redo text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Try Again</h3>
                <p class="text-gray-400 text-sm mb-4">Refresh the page to try connecting again</p>
                <button onclick="location.reload()" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Refresh Page
                </button>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">Return to the homepage which should be working</p>
                <a href="<?= url(''); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-exclamation-triangle text-orange-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Report Issue</h3>
                <p class="text-gray-400 text-sm mb-4">Let me know if this problem persists</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Report Problem
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">What's a Bad Gateway?</h3>
            <p class="text-gray-400 mb-6">
                A bad gateway error occurs when one server receives an invalid response from another server. 
                This is typically temporary and resolves itself quickly.
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
                <i class="fas fa-network-wired mr-2"></i>
                Fun Fact: HTTP 502 errors often occur in load-balanced environments. 
                Modern web architecture at work!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
