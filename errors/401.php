<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(401);

// Set SEO data for the 401 page
$SEO = [
    'title' => '401 - Unauthorized | Gulger Mallik',
    'description' => 'You need to authenticate to access this resource.',
    'keywords' => 'gulger mallik, mr mallik, 401, unauthorized, authentication required',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('401', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(6, 182, 212, 0.3);
    }
    
    .fade {
        animation: fade 3s infinite;
    }
    
    @keyframes fade {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code fade mb-8">401</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Authentication Required</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                You need to authenticate to access this resource. Please log in or provide 
                the necessary credentials to continue.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-sign-in-alt text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Login</h3>
                <p class="text-gray-400 text-sm mb-4">Access your account to view protected content</p>
                <a href="<?= url('login'); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Sign In
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">Return to the public areas of the site</p>
                <a href="<?= url(''); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-question-circle text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Need Help?</h3>
                <p class="text-gray-400 text-sm mb-4">Contact me if you need access or have questions</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Get Help
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">Authentication Required</h3>
            <p class="text-gray-400 mb-6">
                This resource requires authentication. If you believe you should have access, 
                please contact me or try logging in with your credentials.
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
                <i class="fas fa-key mr-2"></i>
                Fun Fact: HTTP 401 errors indicate that authentication is required. 
                Security is important!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
