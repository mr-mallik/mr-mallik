<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(403);

// Set SEO data for the 403 page
$SEO = [
    'title' => '403 - Access Forbidden | Gulger Mallik',
    'description' => 'Access to this resource is forbidden. Please check your permissions.',
    'keywords' => 'gulger mallik, mr mallik, 403, forbidden, access denied',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('403', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(220, 38, 38, 0.3);
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code pulse mb-8">403</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Access Forbidden</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                You don't have permission to access this resource. This could be due to insufficient privileges 
                or the content being restricted.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">Return to the homepage where you have full access</p>
                <a href="<?= url(''); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-user-lock text-red-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Check Permissions</h3>
                <p class="text-gray-400 text-sm mb-4">You might need to log in or have different permissions</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Request Access
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-code text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">View Public Work</h3>
                <p class="text-gray-400 text-sm mb-4">Check out my public projects and portfolio</p>
                <a href="<?= url('projects'); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    See Projects
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">Need Help?</h3>
            <p class="text-gray-400 mb-6">
                If you believe you should have access to this resource, please contact me. 
                I'm happy to help resolve any access issues.
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
                <i class="fas fa-shield-alt mr-2"></i>
                Fun Fact: HTTP 403 errors help protect sensitive resources from unauthorized access. 
                Security first!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
