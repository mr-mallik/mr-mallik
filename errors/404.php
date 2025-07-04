<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(404);

// Set SEO data for the 404 page
$SEO = [
    'title' => '404 - Page Not Found | Gulger Mallik',
    'description' => 'Sorry, the page you are looking for cannot be found. Return to Gulger Mallik\'s portfolio.',
    'keywords' => 'gulger mallik, mr mallik, 404, page not found, error',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('404', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #64748b, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(100, 116, 139, 0.3);
    }
    
    .glitch {
        animation: glitch 2s infinite;
    }
    
    @keyframes glitch {
        0%, 100% { transform: translate(0); }
        20% { transform: translate(-2px, 2px); }
        40% { transform: translate(-2px, -2px); }
        60% { transform: translate(2px, 2px); }
        80% { transform: translate(2px, -2px); }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Error Code -->
        <div class="error-code glitch mb-8">404</div>
        
        <!-- Error Message -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Page Not Found</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                Oops! The page you're looking for seems to have vanished into the digital void. 
                Don't worry, even the best developers encounter 404s.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-home text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Go Home</h3>
                <p class="text-gray-400 text-sm mb-4">Return to the homepage and explore my portfolio</p>
                <a href="<?= url(''); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Take Me Home
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-code text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">View Projects</h3>
                <p class="text-gray-400 text-sm mb-4">Check out my latest development projects</p>
                <a href="<?= url('projects'); ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    See Projects
                </a>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-envelope text-yellow-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Contact Me</h3>
                <p class="text-gray-400 text-sm mb-4">Get in touch for collaboration opportunities</p>
                <a href="<?= url('contact'); ?>" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Let's Connect
                </a>
            </div>
        </div>

        <!-- Additional Help -->
        <div class="card-bg-linear rounded-xl p-8 text-center">
            <h3 class="text-xl font-semibold mb-4">Still Lost?</h3>
            <p class="text-gray-400 mb-6">
                If you believe this is a mistake or you were looking for something specific, 
                feel free to reach out. I'm always happy to help!
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
                <i class="fas fa-lightbulb mr-2"></i>
                Fun Fact: HTTP 404 errors have been around since the early days of the web. 
                At least you're part of internet history!
            </p>
        </div>
    </div>
</section>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>
