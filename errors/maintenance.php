<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// Set HTTP status code
http_response_code(503);

// Set SEO data for the maintenance page
$SEO = [
    'title' => 'Site Under Maintenance | Gulger Mallik',
    'description' => 'The site is currently under maintenance. We will be back shortly.',
    'keywords' => 'gulger mallik, mr mallik, maintenance, under maintenance, site down',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('maintenance', false),
];

// Include the header
require_once __DIR__ . '/../partials/header.php';
?>

<style>
    .error-code {
        font-size: 12rem;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 30px rgba(245, 158, 11, 0.3);
    }
    
    .maintenance-icon {
        animation: spin 4s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<section class="container mx-auto min-h-screen flex items-center justify-center">
    <div class="text-center max-w-4xl mx-auto px-4" data-aos="fade-up">
        <!-- Maintenance Icon -->
        <div class="mb-8">
            <div class="maintenance-icon text-8xl text-yellow-500 mb-6">
                <i class="fas fa-tools"></i>
            </div>
        </div>
        
        <!-- Main Title -->
        <div class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Site Under Maintenance</h1>
            <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                We're currently performing scheduled maintenance to improve your experience. 
                Please check back in a few minutes.
            </p>
        </div>

        <!-- Status Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-clock text-yellow-400 pulse"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Estimated Time</h3>
                <p class="text-gray-400 text-sm mb-4">We'll be back within 30 minutes</p>
                <div class="text-yellow-400 font-bold text-lg">
                    <span id="countdown">-- : --</span>
                </div>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-wrench text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">What's Happening</h3>
                <p class="text-gray-400 text-sm mb-4">System updates and performance improvements</p>
                <div class="text-blue-400 font-semibold">
                    Upgrading Server
                </div>
            </div>

            <div class="p-6 bg-gray-900 rounded-xl hover:bg-gray-800 transition-colors duration-300">
                <div class="text-3xl mb-4">
                    <i class="fas fa-envelope text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                <p class="text-gray-400 text-sm mb-4">Get notified when we're back online</p>
                <a href="mailto:<?= strtolower(CONTACT_EMAIL); ?>" class="inline-block bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Contact Me
                </a>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-12">
            <div class="card-bg-linear rounded-xl p-8">
                <h3 class="text-xl font-semibold mb-4">Maintenance Progress</h3>
                <div class="w-full bg-gray-700 rounded-full h-4 mb-4">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-4 rounded-full animate-pulse" style="width: 75%"></div>
                </div>
                <p class="text-gray-400">
                    <i class="fas fa-cog mr-2"></i>
                    Optimizing database and updating security patches...
                </p>
            </div>
        </div>

        <!-- Social Links -->
        <div class="card-bg-linear rounded-xl p-8 text-center mb-12">
            <h3 class="text-xl font-semibold mb-4">Connect With Me</h3>
            <p class="text-gray-400 mb-6">
                While you wait, feel free to connect with me on social media or check out my work.
            </p>
            <div class="flex justify-center gap-6">
                <a href="mailto:<?= strtolower(CONTACT_EMAIL); ?>" class="text-blue-400 hover:text-blue-300 transition-colors text-lg">
                    <i class="fas fa-envelope mr-2"></i>Email
                </a>
                <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors text-lg">
                    <i class="fab fa-linkedin mr-2"></i>LinkedIn
                </a>
                <a href="<?= SOCIAL_GITHUB; ?>" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors text-lg">
                    <i class="fab fa-github mr-2"></i>GitHub
                </a>
            </div>
        </div>

        <!-- Fun Fact -->
        <div class="text-center">
            <p class="text-gray-500 text-sm">
                <i class="fas fa-lightbulb mr-2"></i>
                Fun Fact: Regular maintenance keeps websites running smoothly and securely. 
                Thanks for your patience!
            </p>
        </div>
    </div>
</section>

<script>
// Simple countdown timer (optional - can be customized)
function updateCountdown() {
    const now = new Date().getTime();
    const maintenanceEnd = now + (30 * 60 * 1000); // 30 minutes from now
    
    const distance = maintenanceEnd - now;
    
    if (distance > 0) {
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('countdown').innerHTML = 
            String(minutes).padStart(2, '0') + ' : ' + String(seconds).padStart(2, '0');
    } else {
        document.getElementById('countdown').innerHTML = 'Almost Done!';
    }
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown();

// Auto-refresh page every 5 minutes
setTimeout(function() {
    location.reload();
}, 300000);
</script>

<?php
// Include the footer
require_once __DIR__ . '/../partials/footer.php';
?>