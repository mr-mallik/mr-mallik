<?php
require_once __DIR__ . '/includes/common.php';

header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    <!-- Homepage -->
    <url>
        <loc><?= url('', false); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
        <image:image>
            <image:loc><?= url('assets/images/gulger-mallik@1x1.jpg', false); ?></image:loc>
            <image:title>Gulger Mallik - Software Engineer</image:title>
            <image:caption>Gulger Mallik, Software Engineer and Full Stack Developer</image:caption>
        </image:image>
    </url>
    
    <!-- About Page -->
    <url>
        <loc><?= url('about', false); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
        <image:image>
            <image:loc><?= url('assets/images/about-me-grad.jpg', false); ?></image:loc>
            <image:title>About Gulger Mallik</image:title>
            <image:caption>Gulger Mallik graduation photo from University of Huddersfield</image:caption>
        </image:image>
    </url>
    
    <!-- Projects Page -->
    <url>
        <loc><?= url('projects', false); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <image:image>
            <image:loc><?= url('assets/images/projects.jpeg', false); ?></image:loc>
            <image:title>Projects by Gulger Mallik</image:title>
            <image:caption>Software development projects portfolio</image:caption>
        </image:image>
    </url>
    
    <!-- Blog/Stories Page -->
    <url>
        <loc><?= url('blogs', false); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <image:image>
            <image:loc><?= url('assets/images/stories.jpeg', false); ?></image:loc>
            <image:title>Blog Stories by Gulger Mallik</image:title>
            <image:caption>Software engineering journey and tech insights</image:caption>
        </image:image>
    </url>
    
    <!-- Contact Page -->
    <url>
        <loc><?= url('contact', false); ?></loc>
        <lastmod><?= date('Y-m-d'); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
        <image:image>
            <image:loc><?= url('assets/images/contact-me.jpg', false); ?></image:loc>
            <image:title>Contact Gulger Mallik</image:title>
            <image:caption>Get in touch with Gulger Mallik for software development projects</image:caption>
        </image:image>
    </url>
    
    <?php
    // Dynamic project pages
    if (function_exists('blogList')) {
        $projects = blogList("AND type='project' AND status='A'");
        foreach ($projects as $project) {
            echo "<url>\n";
            echo "    <loc>" . url('projects/' . $project['urlname'], false) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($project['updated_at'] ?? $project['created_at'])) . "</lastmod>\n";
            echo "    <changefreq>monthly</changefreq>\n";
            echo "    <priority>0.7</priority>\n";
            if (!empty($project['image'])) {
                echo "    <image:image>\n";
                echo "        <image:loc>" . url($project['image'], false) . "</image:loc>\n";
                echo "        <image:title>" . htmlspecialchars($project['title']) . "</image:title>\n";
                echo "        <image:caption>" . htmlspecialchars($project['short_description']) . "</image:caption>\n";
                echo "    </image:image>\n";
            }
            echo "</url>\n";
        }
    }
    
    // Dynamic blog/story pages
    if (function_exists('blogList')) {
        $stories = blogList("AND type='blog' AND status='A'");
        foreach ($stories as $story) {
            echo "<url>\n";
            echo "    <loc>" . url('stories/' . $story['urlname'], false) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($story['updated_at'] ?? $story['created_at'])) . "</lastmod>\n";
            echo "    <changefreq>monthly</changefreq>\n";
            echo "    <priority>0.6</priority>\n";
            if (!empty($story['image'])) {
                echo "    <image:image>\n";
                echo "        <image:loc>" . url($story['image'], false) . "</image:loc>\n";
                echo "        <image:title>" . htmlspecialchars($story['title']) . "</image:title>\n";
                echo "        <image:caption>" . htmlspecialchars($story['short_description']) . "</image:caption>\n";
                echo "    </image:image>\n";
            }
            echo "</url>\n";
        }
    }
    ?>
    
</urlset>