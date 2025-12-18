<?php
require_once __DIR__ . '/../includes/common.php'; # config file
$defaultSeo = [
    'title' => 'Gulger Mallik - Director & Co-founder at Cosmokode Ltd',
    'description' => 'Gulger Mallik is Director and Co-founder of Cosmokode Ltd with over half a decade of industry experience in software engineering, full-stack development, and AI/ML implementations. Leading innovative tech solutions in the UK.',
    'keywords' => 'gulger mallik, mr mallik, director cosmokode, cosmokode ltd, software engineering director, full stack developer, tech entrepreneur, UK software development',
    'image' => url('assets/images/gulger-mallik@1x1.png', false),
    'url' => url('director', false),
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
<html lang="en" class="light">
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
        <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico', false) ?>" />
        <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico', false) ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= url('apple-touch-icon.png', false) ?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?= url('favicon-32x32.png', false) ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?= url('favicon-16x16.png', false) ?>" />
        <link rel="manifest" href="<?= url('site.webmanifest', false) ?>" />
        <link rel="mask-icon" href="<?= url('safari-pinned-tab.svg', false) ?>" color="#5bbad5" />
        
        <!-- Additional favicon formats for better compatibility -->
        <meta name="msapplication-TileImage" content="<?= url('favicon-32x32.png', false) ?>" />
        <meta name="msapplication-config" content="<?= url('browserconfig.xml', false) ?>" />
        
        <!-- App Configuration -->
        <meta name="apple-mobile-web-app-title" content="Gulger Mallik" />
        <meta name="application-name" content="Mr Mallik" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#000000" />
        
        <!-- Favicon optimization for search engines -->
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        
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

        <!-- Additional SEO Meta Tags -->
        <meta name="format-detection" content="telephone=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        
        <!-- Rich Snippets -->
        <meta property="profile:first_name" content="Gulger">
        <meta property="profile:last_name" content="Mallik">
        <meta property="profile:username" content="mr-mallik">
        
        <!-- LinkedIn -->
        <meta property="article:author" content="<?php echo SOCIAL_LINKEDIN; ?>">
        
        <!-- Company/Organization Tags -->
        <meta name="company" content="CosmoKode Ltd">
        <meta name="industry" content="Software Development">
        <meta name="location" content="United Kingdom">
        
        <!-- Academic Verification -->
        <meta name="academic-orcid" content="0009-0002-5110-8575">
        <meta name="academic-affiliation" content="University of Huddersfield">
        <meta name="research-profile" content="https://pure.hud.ac.uk/en/persons/gulger-mallik">
        
        <!-- Professional Verification -->
        <meta name="dc.creator" content="Gulger Mallik">
        <meta name="dc.contributor" content="Gulger Mallik">
        <meta name="dc.publisher" content="Mr Mallik">
        <meta name="citation_author" content="Gulger Mallik">
        <meta name="citation_author_institution" content="University of Huddersfield">

        <!-- Structured Data -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Person",
            "name": "Gulger Mallik",
            "alternateName": ["Mr Mallik", "mr mallik", "Gulger Mallik Director", "Gulger Mallik Cosmokode"],
            "url": "<?= htmlspecialchars($SEO['url']); ?>",
            "image": "<?= htmlspecialchars($SEO['image']); ?>",
            "logo": "<?= url('favicon-32x32.png', false); ?>",
            "description": "<?= htmlspecialchars($SEO['description']); ?>",
            "jobTitle": ["Director", "Co-founder", "Software Engineer", "Full Stack Developer"],
            "knowsAbout": ["Software Engineering", "Web Development", "Mobile Development", "AI", "Machine Learning", "Full Stack Development", "PHP", "JavaScript", "Python"],
            "address": {
                "@type": "PostalAddress",
                "addressRegion": "West Yorkshire",
                "addressCountry": "United Kingdom"
            },
            "alumniOf": [
                {
                    "@type": "CollegeOrUniversity",
                    "name": "University of Huddersfield",
                    "url": "https://www.hud.ac.uk/",
                    "sameAs": "<?php echo ACADEMIC_PURE; ?>"
                }
            ],
            "affiliation": [
                {
                    "@type": "CollegeOrUniversity",
                    "name": "University of Huddersfield",
                    "url": "https://www.hud.ac.uk/"
                },
                {
                    "@type": "Organization",
                    "name": "CosmoKode Ltd",
                    "url": "https://cosmokode.com/"
                }
            ],
            "worksFor": [
                {
                    "@type": "Organization",
                    "name": "CosmoKode Ltd",
                    "url": "https://cosmokode.com/",
                    "description": "Director & Co-founder",
                    "foundingDate": "2018"
                }
            ],
            "hasOccupation": {
                "@type": "Occupation",
                "name": "Director & Co-founder",
                "occupationalCategory": "Management and Leadership in Technology",
                "skills": ["Software Engineering", "Full Stack Development", "AI/ML", "Technology Leadership", "Business Strategy", "Team Management"],
                "yearsOfExperience": "6+"
            },
            "workLocation": "United Kingdom",
            "nationality": "Indian",
            "identifier": [
                {
                    "@type": "PropertyValue",
                    "name": "ORCID",
                    "value": "0009-0002-5110-8575",
                    "url": "<?php echo ACADEMIC_ORCID; ?>"
                }
            ],
            "sameAs": [
                "<?php echo SOCIAL_LINKEDIN; ?>",
                "<?php echo SOCIAL_GITHUB; ?>",
                "<?php echo SOCIAL_MEDIUM; ?>",
                "<?php echo SOCIAL_INSTAGRAM; ?>",
                "<?php echo SOCIAL_FACEBOOK; ?>",
                "<?php echo SOCIAL_TWITTER; ?>",
                "<?php echo SOCIAL_YOUTUBE; ?>",
                "<?php echo ACADEMIC_PURE; ?>",
                "<?php echo ACADEMIC_ORCID; ?>"
            ]
        }
        </script>
        
        <!-- Organization Structured Data for CosmoKode -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "CosmoKode Ltd",
            "url": "https://cosmokode.com/",
            "logo": "<?= url('favicon-32x32.png', false); ?>",
            "founder": {
                "@type": "Person",
                "name": "Gulger Mallik",
                "url": "<?= htmlspecialchars($SEO['url']); ?>"
            },
            "description": "Software development company co-founded by Gulger Mallik"
        }
        </script>

        <!-- Academic/Research Profile -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Person",
            "@id": "<?php echo ACADEMIC_ORCID; ?>",
            "name": "Gulger Mallik",
            "givenName": "Gulger",
            "familyName": "Mallik",
            "alternateName": "Mr Mallik",
            "jobTitle": ["Director & Co-founder at Cosmokode Ltd", "Software Engineer", "Researcher", "Full Stack Developer"],
            "affiliation": [
                {
                    "@type": "CollegeOrUniversity",
                    "name": "University of Huddersfield",
                    "url": "https://www.hud.ac.uk/",
                    "department": {
                        "@type": "Organization",
                        "name": "School of Computing and Engineering"
                    }
                }
            ],
            "alumniOf": {
                "@type": "CollegeOrUniversity",
                "name": "University of Huddersfield",
                "url": "https://www.hud.ac.uk/"
            },
            "url": "<?= htmlspecialchars($SEO['url']); ?>",
            "sameAs": [
                "<?php echo ACADEMIC_PURE; ?>",
                "<?php echo ACADEMIC_ORCID; ?>"
            ],
            "knowsAbout": [
                "Software Engineering",
                "Computer Science", 
                "Web Development",
                "Mobile Development",
                "Artificial Intelligence",
                "Machine Learning",
                "Full Stack Development"
            ]
        }
        </script>

        <!-- External Resources -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS -->
        <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>
    <body class="mx-auto p-6 md:p-10 max-w-7xl director-page">
        <main>
            <!-- Header Section -->
            <header class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-black mb-2 tracking-tight">
                    Gulger Mallik
                </h1>
                <p class="text-lg md:text-xl text-gray-800 font-medium">
                    Director & Co-founder, <span class="font-semibold">Cosmokode Ltd</span>
                </p>
            </header>
            
            <!-- Main Content Section -->
            <section class="grid md:grid-cols-2 gap-8 md:gap-12 mb-12 items-start">
                
                <!-- Profile Image -->
                <div>
                    <div class="relative">
                        <img 
                            src="<?= url('assets/images/gulger-mallik@1x1.png', false) ?>" 
                            alt="Gulger Mallik - Director and Co-founder of Cosmokode Ltd" 
                            class="profile-image w-full h-auto rounded-lg"
                            loading="eager"
                            onerror="this.src='<?= url('assets/images/logo/logo-dark.png', false) ?>'"
                        >
                    </div>
                </div>
                
                <!-- About Content -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-black mb-4">
                        About Me
                    </h2>
                    
                    <div class="content-divider mb-4"></div>
                    
                    <div class="space-y-4 text-gray-900 text-base leading-relaxed">
                        <p class="font-medium">
                            As Director and Co-founder of Cosmokode Ltd, I lead a talented team in delivering 
                            cutting-edge software solutions. With over half a decade of industry experience, I've built 
                            a reputation for combining technical excellence with strategic leadership—from full-stack 
                            development to AI/ML implementations and enterprise-scale solutions.
                        </p>
                        
                        <p>
                            Grounded in Computer Science from the University of Huddersfield and 6+ years across 
                            diverse industries, I help organizations leverage technology to achieve their most 
                            ambitious goals. At Cosmokode, we create solutions that transform businesses and 
                            drive real impact.
                        </p>
                    </div>
                    
                    <div class="content-divider mt-4 mb-3"></div>
                    
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-black mb-2">What Drives Me</h3>
                        <p class="text-gray-900 text-base leading-relaxed">
                            Building world-class technology solutions and leading teams toward extraordinary outcomes. 
                            Fostering innovation, nurturing talent, and positioning Cosmokode Ltd as a leader in 
                            delivering exceptional software that makes a lasting impact.
                        </p>
                    </div>
                </div>
                
            </section>
            
            <!-- Bottom Section: Signature & Social Links -->
            <section class="relative mt-8 pt-6 border-t-2 border-black/20">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    
                    <!-- Signature (Bottom Left) -->
                    <div class="signature-container md:w-1/2">
                        <p class="text-xs text-gray-600 mb-1 font-medium">Sincerely,</p>
                        <div class="signature text-4xl sm:text-5xl my-2">mr mallik</div>
                        <p class="text-xs text-gray-700 font-semibold mt-0.5">Gulger Mallik</p>
                        <p class="text-xs text-gray-600">Director & Co-founder, Cosmokode Ltd</p>
                    </div>
                    
                    <!-- Social Links (Bottom Right) -->
                    <div class="social-links-container md:w-1/2 md:text-right">
                        <p class="text-xs text-gray-600 mb-3 font-medium">Connect with me</p>
                        <div class="flex gap-3 justify-center md:justify-end flex-wrap">
                            
                            <a href="<?php echo SOCIAL_LINKEDIN; ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="social-link linkedin"
                               title="Connect on LinkedIn"
                               aria-label="LinkedIn Profile">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            
                            <a href="<?php echo SOCIAL_GITHUB; ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="social-link github"
                               title="View GitHub Profile"
                               aria-label="GitHub Profile">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                            
                            <a href="<?php echo SOCIAL_MEDIUM; ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="social-link medium"
                               title="Read on Medium"
                               aria-label="Medium Profile">
                                <i class="fab fa-medium text-xl"></i>
                            </a>
                            
                            <a href="<?= url('', false) ?>" 
                               class="social-link website"
                               title="Visit Personal Website"
                               aria-label="Personal Website">
                                <i class="fas fa-globe text-xl"></i>
                            </a>
                            
                            <a href="mailto:<?php echo CONTACT_EMAIL; ?>" 
                               class="social-link email"
                               title="Send Email"
                               aria-label="Email Contact">
                                <i class="fas fa-envelope text-xl"></i>
                            </a>
                            
                        </div>
                    </div>
                    
                </div>
            </section>
        </main>
        
        <!-- jQuery Interactions -->
        <script>
            $(document).ready(function() {
                // Track social link clicks
                $('.social-link').on('click', function() {
                    const platform = $(this).attr('class').split(' ').find(c => 
                        ['linkedin', 'github', 'medium', 'website', 'email'].includes(c)
                    );
                    console.log('Social link clicked: ' + platform);
                });
            });
        </script>
    </body>
</html>