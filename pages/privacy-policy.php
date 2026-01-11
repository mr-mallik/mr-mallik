<?php
require_once '../includes/common.php';

$page_title = "Privacy Policy - Cookie Information";
$SEO = [
    'title' => 'Privacy Policy & Cookie Information | Gulger Mallik',
    'description' => 'Learn how we collect, use, and protect your personal data. Complete information about our cookie usage and GDPR compliance.',
    'keywords' => 'privacy policy, cookie policy, data protection, GDPR, gulger mallik, mr mallik',
    'image' => url('assets/images/og-image.png', false),
    'url' => url('privacy-policy', false),
];

require_once '../partials/header.php';
?>

<div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8 sm:px-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Privacy Policy & Cookie Information</h1>
                    <p class="text-gray-600 dark:text-gray-400">Last updated: <?= date('F j, Y') ?></p>
                </div>

                <div class="prose prose-lg max-w-none dark:prose-invert">
                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                            Data Protection Overview
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            This privacy policy explains how Gulger Mallik ("we", "us", or "our") collects, uses, and protects your personal information when you visit our website. We are committed to protecting your privacy and complying with applicable data protection laws, including the General Data Protection Regulation (GDPR).
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-cookie-bite text-orange-500 mr-2"></i>
                            Cookie Information
                        </h2>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6">
                            <p class="text-blue-800 dark:text-blue-200">
                                <strong>What are cookies?</strong> Cookies are small text files that are stored on your device when you visit a website. They help us provide you with a better browsing experience and allow certain features to work properly.
                            </p>
                        </div>

                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Types of Cookies We Use</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                    <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-2 py-1 rounded text-xs mr-2">Required</span>
                                    Necessary Cookies
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Essential for the website to function properly. These cannot be disabled.
                                </p>
                                <ul class="text-sm text-gray-500 dark:text-gray-400">
                                    <li>• Session management</li>
                                    <li>• Security features</li>
                                    <li>• Cookie consent preferences</li>
                                </ul>
                            </div>
                            
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded text-xs mr-2">Optional</span>
                                    Analytics Cookies
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Help us understand how visitors interact with our website.
                                </p>
                                <ul class="text-sm text-gray-500 dark:text-gray-400">
                                    <li>• Google Analytics</li>
                                    <li>• Page view tracking</li>
                                    <li>• User behavior analysis</li>
                                </ul>
                            </div>
                            
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                    <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded text-xs mr-2">Optional</span>
                                    Functional Cookies
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Enable enhanced functionality and personalization.
                                </p>
                                <ul class="text-sm text-gray-500 dark:text-gray-400">
                                    <li>• Theme preferences</li>
                                    <li>• Language settings</li>
                                    <li>• Form data storage</li>
                                </ul>
                            </div>
                            
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                    <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded text-xs mr-2">Optional</span>
                                    Marketing Cookies
                                </h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Used to track visitors for advertising purposes.
                                </p>
                                <ul class="text-sm text-gray-500 dark:text-gray-400">
                                    <li>• Social media pixels</li>
                                    <li>• Advertising networks</li>
                                    <li>• Conversion tracking</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-database text-green-500 mr-2"></i>
                            Data We Collect
                        </h2>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Information Automatically Collected</h3>
                            <ul class="text-gray-600 dark:text-gray-300 space-y-1">
                                <li>• IP address (anonymized for analytics)</li>
                                <li>• Browser type and version</li>
                                <li>• Operating system</li>
                                <li>• Pages visited and time spent</li>
                                <li>• Referring website</li>
                                <li>• Device information (mobile/desktop)</li>
                            </ul>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Information You Provide</h3>
                            <ul class="text-gray-600 dark:text-gray-300 space-y-1">
                                <li>• Contact form submissions</li>
                                <li>• Email communications</li>
                                <li>• Comment submissions</li>
                                <li>• Newsletter subscriptions</li>
                            </ul>
                        </div>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-balance-scale text-purple-500 mr-2"></i>
                            Your Rights (GDPR)
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">Right to Access</h4>
                                <p class="text-blue-800 dark:text-blue-300 text-sm">You can request information about the personal data we hold about you.</p>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                                <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">Right to Rectification</h4>
                                <p class="text-green-800 dark:text-green-300 text-sm">You can request correction of inaccurate personal data.</p>
                            </div>
                            
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4">
                                <h4 class="font-semibold text-red-900 dark:text-red-200 mb-2">Right to Erasure</h4>
                                <p class="text-red-800 dark:text-red-300 text-sm">You can request deletion of your personal data ("right to be forgotten").</p>
                            </div>
                            
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">Right to Withdraw Consent</h4>
                                <p class="text-purple-800 dark:text-purple-300 text-sm">You can withdraw your consent for data processing at any time.</p>
                            </div>
                        </div>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-cog text-gray-500 mr-2"></i>
                            Managing Your Cookie Preferences
                        </h2>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-4 mb-4">
                            <p class="text-yellow-800 dark:text-yellow-200">
                                You can change your cookie preferences at any time by clicking the cookie settings button at the bottom right of any page, or by using the button below.
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <button id="openCookieSettings" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 inline-flex items-center">
                                <i class="fas fa-cookie-bite mr-2"></i>
                                Manage Cookie Preferences
                            </button>
                        </div>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-envelope text-blue-500 mr-2"></i>
                            Contact Information
                        </h2>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">
                                If you have any questions about this privacy policy or our data practices, please contact us:
                            </p>
                            <div class="space-y-2 text-gray-600 dark:text-gray-400">
                                <p><strong>Email:</strong> <a href="mailto:<?= CONTACT_EMAIL ?>" class="text-blue-500 hover:underline"><?= CONTACT_EMAIL ?></a></p>
                                <p><strong>Website:</strong> <a href="<?= APP_URL ?>" class="text-blue-500 hover:underline"><?= APP_URL ?></a></p>
                                <p><strong>Response Time:</strong> We aim to respond to all privacy-related inquiries within 30 days.</p>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-clock text-orange-500 mr-2"></i>
                            Changes to This Policy
                        </h2>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            We may update this privacy policy from time to time. Any changes will be posted on this page with an updated revision date. We encourage you to review this policy periodically to stay informed about how we protect your information.
                        </p>
                        
                        <!-- <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4">
                            <p class="text-green-800 dark:text-green-200">
                                <strong>Last updated:</strong> <?= date('F j, Y') ?> - Initial version with comprehensive cookie consent implementation.
                            </p>
                        </div> -->
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Open cookie settings when button is clicked
document.getElementById('openCookieSettings')?.addEventListener('click', function() {
    if (window.cookieConsent) {
        window.cookieConsent.showCustomizeModal();
    }
});
</script>

<?php require_once '../partials/footer.php'; ?>