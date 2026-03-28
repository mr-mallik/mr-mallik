<?php
require_once __DIR__ . '/../includes/common.php'; // Common functions and configurations

// SEO configuration for the contact page
$SEO = [
    'title' => 'Contact Gulger Mallik | Software Engineer | Mr Mallik',
    'description' => 'Get in touch for software development projects, collaborations, or consulting. Co-founder of CosmoKode with web & AI/ML expertise.',
    'keywords' => 'contact gulger mallik, mr mallik contact, hire software engineer uk, cosmokode contact, gulger mallik email, software development consultant',
    'image' => url('assets/images/og-image.png', false),
    'url' => url('contact', false),
];

// Read client locations from JSON
$locationsRaw = file_exists(__DIR__ . '/../data/worked-cordinates.json')
    ? file_get_contents(__DIR__ . '/../data/worked-cordinates.json')
    : '[]';
$locations    = json_decode($locationsRaw, true) ?: [];
$locationCount = count($locations);
$countryCount  = count(array_unique(array_column($locations, 'country')));

require_once __DIR__ . '/../partials/header.php';
?>

<!-- Hero Section -->
<section class="container mx-auto px-4 sm:px-6 lg:px-10 pt-6 pb-4">
    <div class="flex flex-col lg:flex-row gap-4">

        <!-- Intro card -->
        <div class="w-full lg:w-2/3">
            <div class="p-6 sm:p-8 lg:p-10 card-bg-radial rounded-xl shadow-lg h-full flex flex-col justify-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-widest mb-3">Get in touch</p>
                <h1 class="text-3xl sm:text-4xl xl:text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-4">
                    Let's build something<br/><span class="brand-text">great together.</span>
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base max-w-lg">
                    Whether you have a project in mind, want to collaborate, or just want to say hi — my inbox is always open. I'll do my best to get back to you promptly.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="mailto:<?= CONTACT_EMAIL; ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-semibold rounded-lg hover:opacity-90 transition-opacity duration-200">
                        <i class="fas fa-envelope text-xs"></i>
                        Send an Email
                    </a>
                    <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg hover:border-gray-500 dark:hover:border-gray-400 transition-colors duration-200">
                        <i class="fab fa-linkedin-in text-xs"></i>
                        Connect on LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Availability card -->
        <div class="w-full lg:w-1/3">
            <div class="p-5 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg h-full flex flex-col gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                        <span class="text-green-500 dark:text-green-400 text-xs font-semibold uppercase tracking-widest">Available for work</span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                        Delivered projects for clients across
                        <strong class="text-gray-900 dark:text-white"><?= $locationCount; ?> cities</strong>
                        in <strong class="text-gray-900 dark:text-white"><?= $countryCount; ?> countries</strong>.
                        Open to freelance, consulting, and full-time roles in software engineering, web, or AI/ML.
                    </p>
                </div>

                <!-- Client location map -->
                <div id="client-map" class="rounded-lg overflow-hidden flex-1" style="min-height:150px;z-index:0;"></div>

                <div class="flex flex-col gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt w-4 text-center text-xs"></i>
                        <span><?= CONTACT_ADDRESS_2; ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock w-4 text-center text-xs"></i>
                        <span>Usually responds within 24 hours</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Channels -->
<section class="container mx-auto px-4 sm:px-6 lg:px-10 py-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Email -->
        <a href="mailto:<?= CONTACT_EMAIL; ?>" class="group block" data-aos="fade-up">
            <div class="p-5 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 h-full flex flex-col gap-3">
                <div class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 256 193" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                        <path d="M58.182 192.05V93.14L27.507 65.077 0 49.504v125.091c0 9.658 7.825 17.455 17.455 17.455h40.727Z" fill="#4285F4"/>
                        <path d="M197.818 192.05h40.727c9.659 0 17.455-7.826 17.455-17.455V49.504l-31.156 17.837-27.026 25.798v98.91Z" fill="#34A853"/>
                        <path d="m58.182 93.14-4.174-38.647 4.174-36.989L128 69.868l69.818-52.364 4.669 34.992-4.669 40.644L128 145.504z" fill="#EA4335"/>
                        <path d="M197.818 17.504V93.14L256 49.504V26.231c0-21.585-24.64-33.89-41.89-20.945l-16.292 12.218Z" fill="#FBBC04"/>
                        <path d="m0 49.504 26.759 20.07L58.182 93.14V17.504L41.89 5.286C24.61-7.66 0 4.646 0 26.23v23.273Z" fill="#C5221F"/>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide mb-1">Email</p>
                    <p class="text-gray-900 dark:text-white font-semibold text-sm break-all group-hover:brand-text transition-colors duration-200"><?= CONTACT_EMAIL; ?></p>
                </div>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-auto">Best for project discussions &amp; consulting</p>
            </div>
        </a>

        <!-- LinkedIn -->
        <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="group block" data-aos="fade-up" data-aos-delay="75">
            <div class="p-5 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 h-full flex flex-col gap-3">
                <div class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#0077B5" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide mb-1">LinkedIn</p>
                    <p class="text-gray-900 dark:text-white font-semibold text-sm">Gulger Mallik</p>
                </div>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-auto">Professional network &amp; career updates</p>
            </div>
        </a>

        <!-- GitHub -->
        <a href="<?= SOCIAL_GITHUB; ?>" target="_blank" class="group block" data-aos="fade-up" data-aos-delay="150">
            <div class="p-5 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 h-full flex flex-col gap-3">
                <div class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" class="text-gray-900 dark:text-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide mb-1">GitHub</p>
                    <p class="text-gray-900 dark:text-white font-semibold text-sm">
                        <?php
                        // everything after the last slash in the URL
                        $github_username = substr(SOCIAL_GITHUB, strrpos(SOCIAL_GITHUB, '/') + 1);
                        echo $github_username;
                        ?>
                    </p>
                </div>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-auto">Open source work &amp; code samples</p>
            </div>
        </a>

        <!-- Medium -->
        <a href="<?= SOCIAL_MEDIUM; ?>" target="_blank" class="group block" data-aos="fade-up" data-aos-delay="225">
            <div class="p-5 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 h-full flex flex-col gap-3">
                <div class="w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#00AB6C" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wide mb-1">Medium</p>
                    <p class="text-gray-900 dark:text-white font-semibold text-sm">
                        <?php
                        // everything after the last slash in the URL
                        $medium_username = substr(SOCIAL_MEDIUM, strrpos(SOCIAL_MEDIUM, '/') + 1);
                        echo $medium_username;
                        ?>
                    </p>
                </div>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-auto">Articles on tech, ML &amp; software craft</p>
            </div>
        </a>

    </div>
</section>

<!-- CTA Strip -->
<section class="container mx-auto px-4 sm:px-6 lg:px-10 py-4 pb-8">
    <div class="card-bg-linear rounded-xl shadow-lg p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4" data-aos="fade-up">
        <div>
            <p class="text-gray-900 dark:text-white font-bold text-lg sm:text-xl">Have a project in mind?</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Drop me an email and let's get the conversation started.</p>
        </div>
        <a href="mailto:<?= CONTACT_EMAIL; ?>" class="shrink-0 inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-bold rounded-lg hover:opacity-90 transition-opacity duration-200 whitespace-nowrap">
            <i class="fas fa-paper-plane text-xs"></i>
            <?= CONTACT_EMAIL; ?>
        </a>
    </div>
</section>

<!-- Leaflet map for client locations -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<style>
.map-pin-wrap{position:relative;width:14px;height:14px}
.map-pin-dot{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:8px;height:8px;border-radius:50%;z-index:2;background:#00f;box-shadow:0 0 4px rgba(0,0,255,.6)}
.dark .map-pin-dot{background:#0ff;box-shadow:0 0 6px rgba(0,255,255,.8)}
.map-pin-pulse{position:absolute;top:50%;left:50%;width:8px;height:8px;border-radius:50%;animation:mapPulse 2s ease-out infinite;z-index:1;background:rgba(0,0,255,.3);transform:translate(-50%,-50%) scale(1)}
.dark .map-pin-pulse{background:rgba(0,255,255,.25)}
@keyframes mapPulse{0%{transform:translate(-50%,-50%) scale(1);opacity:.8}100%{transform:translate(-50%,-50%) scale(3.5);opacity:0}}
</style>
<script>
(function(){
    var locations = <?= json_encode($locations, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>;
    function initClientMap(){
        var el = document.getElementById('client-map');
        if(!el || typeof L==='undefined') return;
        var isDark = document.documentElement.classList.contains('dark');
        var lightUrl = 'https://{s}.basemaps.cartocdn.com/spotify_light/{z}/{x}/{y}{r}.png';
        var darkUrl  = 'https://{s}.basemaps.cartocdn.com/spotify_dark/{z}/{x}/{y}{r}.png';
        var map = L.map('client-map',{
            zoomControl:false, scrollWheelZoom:true, dragging:true,
            touchZoom:true, doubleClickZoom:false, boxZoom:false,
            keyboard:false, attributionControl:false
        });
        // var currentTile = L.tileLayer(isDark ? darkUrl : lightUrl, {maxZoom:18}).addTo(map);
        var currentTile = L.tileLayer(darkUrl, {maxZoom:18}).addTo(map);
        var pinIcon = function(city, country){
            var label = city + ', ' + country;
            return L.divIcon({
                className:'',
                html:'<div class="map-pin-wrap"><span class="map-pin-pulse"></span><span class="map-pin-dot"></span></div>',
                iconSize:[14,14], iconAnchor:[7,7]
            });
        };
        var markers = [];
        locations.forEach(function(loc){
            var m = L.marker([loc.lat,loc.lng],{icon:pinIcon(loc.city,loc.country)})
                .bindTooltip(loc.city+', '+loc.country,{direction:'top',className:'text-xs'});
            m.addTo(map);
            markers.push(m);
        });
        if(markers.length){
            map.fitBounds(L.featureGroup(markers).getBounds().pad(0.5));
        }
        // Sync tile layer with dark mode toggles
        new MutationObserver(function(muts){
            muts.forEach(function(mut){
                if(mut.attributeName==='class'){
                    var dark = document.documentElement.classList.contains('dark');
                    map.eachLayer(function(l){ if(l instanceof L.TileLayer) map.removeLayer(l); });
                    // L.tileLayer(dark ? darkUrl : lightUrl, {maxZoom:18}).addTo(map);
                    L.tileLayer(darkUrl, {maxZoom:18}).addTo(map);
                }
            });
        }).observe(document.documentElement,{attributes:true});
    }
    if(document.readyState==='loading'){
        document.addEventListener('DOMContentLoaded',initClientMap);
    } else { initClientMap(); }
})();
</script>

<?php
require_once __DIR__ . '/../partials/footer.php';
?>