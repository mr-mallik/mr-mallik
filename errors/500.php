<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(500);

// Set SEO data for the 500 page
$SEO = [
    'title' => '500 - Internal Server Error | Gulger Mallik',
    'description' => 'Something went wrong on our end. We\'re working to fix the issue.',
    'keywords' => 'gulger mallik, mr mallik, 500, server error, internal error',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('500', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(245, 158, 11, 0.3);
    }
    
    .shake {
        animation: shake 0.5s infinite;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code shake mb-8">500</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Internal Server Error</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                Oops! Something went wrong on our end. Don't worry, it's not your fault. 
                We're aware of the issue and working to fix it.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">Return to the homepage, which should be working fine</p>
                <a href="<?= url(''); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-redo text-yellow-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Try Again</h3>
                <p class="text-gray-400 text-sm mb-4">Sometimes a simple refresh can solve the problem</p>
                <button onclick="location.reload()" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Refresh Page
                </button>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-bug text-red-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Report Issue</h3>
                <p class="text-gray-400 text-sm mb-4">Let me know about this error so I can fix it</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Report Bug
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">What Happened?</h3>
            <p class="text-gray-400 mb-6">
                The server encountered an unexpected condition that prevented it from fulfilling your request. 
                This is temporary and we're working to resolve it quickly.
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
                <i class="fas fa-server mr-2"></i>
                Fun Fact: HTTP 500 errors are often caused by server misconfigurations or code issues. 
                Time to debug!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
