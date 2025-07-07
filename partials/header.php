<?php
require_once __DIR__ . '/../includes/common.php'; # config file

$defaultSeo = [
    'title' => 'Gulger Mallik aka Mr. Mallik',
    'description' => 'Gulger Mallik is a Software Engineer and a Fullstack developer.',
    'keywords' => 'gulger mallik, mr mallik, gulger, mallik, software engineer, fullstack developer',
    'image' => url('assets/images/article-footer-light.png', false),
    'url' => url('', false),
];

// merge if SEO is already set
if (isset($SEO) && is_array($SEO)) {
    $SEO = array_merge($defaultSeo, $SEO);
}
else {
    $SEO = $defaultSeo;
}

?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="<?= htmlspecialchars($SEO['url']); ?>">
        
        <!-- Preconnect for performance -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        
        <!-- Favicon and App Icons -->
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url('apple-touch-icon.png') ?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?= url('favicon-32x32.png') ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?= url('favicon-16x16.png') ?>" />
        <link rel="manifest" href="<?= url('site.webmanifest') ?>" />
        <link rel="mask-icon" href="<?= url('safari-pinned-tab.svg') ?>" color="#5bbad5" />
        
        <!-- App Configuration -->
        <meta name="apple-mobile-web-app-title" content="mrmallik" />
        <meta name="application-name" content="mrmallik" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#000000" />
        
        <!-- SEO Meta Tags -->
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
        <meta name="googlebot" content="index, follow" />
        <meta name="bingbot" content="index, follow" />
        <meta name="language" content="en" />
        <meta name="geo.region" content="UK" />
        <meta name="geo.placename" content="United Kingdom" />

        <title><?= htmlspecialchars($SEO['title']); ?></title>
        <meta name="description" content="<?= htmlspecialchars($SEO['description']); ?>">
        <meta name="keywords" content="<?= htmlspecialchars($SEO['keywords']); ?>">
        <meta name="author" content="Gulger Mallik">

        <!-- Open Graph Tags -->
        <meta property="og:title" content="<?= htmlspecialchars($SEO['title']); ?>">
        <meta property="og:description" content="<?= htmlspecialchars($SEO['description']); ?>">
        <meta property="og:image" content="<?= htmlspecialchars($SEO['image']); ?>">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="<?= htmlspecialchars($SEO['title']); ?>">
        <meta property="og:url" content="<?= htmlspecialchars($SEO['url']); ?>">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Gulger Mallik">
        <meta property="og:locale" content="en_GB">

        <!-- Twitter Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= htmlspecialchars($SEO['title']); ?>">
        <meta name="twitter:description" content="<?= htmlspecialchars($SEO['description']); ?>">
        <meta name="twitter:image" content="<?= htmlspecialchars($SEO['image']); ?>">
        <meta name="twitter:image:alt" content="<?= htmlspecialchars($SEO['title']); ?>">
        <meta name="twitter:site" content="@gulger_mallik">
        <meta name="twitter:creator" content="@gulger_mallik">
        <meta name="twitter:url" content="<?= htmlspecialchars($SEO['url']); ?>">

        <!-- Structured Data -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Person",
            "name": "Gulger Mallik",
            "alternateName": "Mr Mallik",
            "url": "<?= htmlspecialchars($SEO['url']); ?>",
            "image": "<?= htmlspecialchars($SEO['image']); ?>",
            "description": "<?= htmlspecialchars($SEO['description']); ?>",
            "jobTitle": "Software Engineer",
            "worksFor": {
                "@type": "Organization",
                "name": "Freelance"
            },
            "sameAs": [
                "<?php echo SOCIAL_LINKEDIN; ?>",
                "<?php echo SOCIAL_GITHUB; ?>",
                "<?php echo SOCIAL_MEDIUM; ?>",
                "<?php echo SOCIAL_INSTAGRAM; ?>",
                "<?php echo SOCIAL_FACEBOOK; ?>",
                "<?php echo SOCIAL_TWITTER; ?>",
                "<?php echo SOCIAL_YOUTUBE; ?>"
            ]
        }
        </script>

        <!-- External Resources -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php url('assets/css/style.css'); ?>">
        <link rel="stylesheet" href="<?php url('assets/js/aos/aos.css'); ?>">
        <script src="<?php url('assets/js/aos/aos.js'); ?>"></script>
    </head>
    <body class="bg-gray-100 dark:bg-black-base dark:text-gray-200">
    <div id="outer-container" class="mx-auto container max-w-7xl">
        <header class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-10 text-center">
            <nav class="relative">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2 lg:gap-4">
                        <img src="<?php url('assets/images/logo/mallik_logo.png'); ?>" alt="Mr Mallik" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full transition-transform duration-800 hover:rotate-[360deg] hover:cursor-pointer invert dark:invert-0" 
                            onmouseout="this.style.transform='rotate(-360deg)'">
                        <a href="<?= url('') ?>" class="signature text-2xl sm:text-3xl text-black dark:text-white">mr mallik</a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <ul class="hidden md:flex justify-between text-gray-400 gap-4 lg:gap-6 xl:gap-12">
                        <?php
                        if (!str_contains($_SERVER['PHP_SELF'], '/errors/maintenance.php')) {
                            $menu = siteMenu();
                            foreach ($menu as $key => $value) {
                                echo '<li><a href="' . url($key, false) . '" class="text-sm lg:text-base text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 [&.active]:text-blue-600 dark:[&.active]:text-cyan-400 transition-colors duration-300 ' . activeUrl($key) . '" >' . $value . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                    
                    <!-- Desktop CTA Button -->
                    <a href="mailto:<?= strtolower(CONTACT_EMAIL) ?>" target="_blank"
                        class="hidden md:block hover:cursor-pointer bg-gray-500 text-gray-200 dark:bg-gray-900 dark:text-white hover:bg-gray-600 dark:hover:bg-gray-800 font-bold py-2 px-3 lg:px-4 rounded-lg transition-colors duration-300 text-sm lg:text-base">
                        Let's Talk
                    </a>
                    
                    <!-- Mobile Hamburger Button -->
                    <button id="mobile-menu-button" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors duration-300" aria-label="Toggle mobile menu">
                        <svg id="hamburger-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="close-icon" class="w-6 h-6 hidden transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Menu -->
                <div id="mobile-menu" class="md:hidden absolute top-full left-0 right-0 mt-4 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible transform -translate-y-2 transition-all duration-300 ease-in-out z-50">
                    <div class="py-4">
                        <?php
                        if (!str_contains($_SERVER['PHP_SELF'], '/errors/maintenance.php')) {
                            $menu = siteMenu();
                            foreach ($menu as $key => $value) {
                                echo '<a href="' . url($key, false) . '" class="mobile-menu-link block px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white [&.active]:text-blue-600 dark:[&.active]:text-cyan-400 [&.active]:bg-blue-50 dark:[&.active]:bg-gray-800 transition-colors duration-200 ' . activeUrl($key) . '">' . $value . '</a>';
                            }
                        }
                        ?>
                        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 mt-2">
                            <a href="mailto:<?= strtolower(CONTACT_EMAIL) ?>" target="_blank"
                                class="block w-full text-center bg-gray-500 text-gray-200 dark:bg-gray-700 dark:text-white hover:bg-gray-600 dark:hover:bg-gray-600 font-bold py-3 px-4 rounded-lg transition-colors duration-300">
                                Let's Talk
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
        <!-- body starts here -->
