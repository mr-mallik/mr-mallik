#!/usr/bin/env php
<?php
/**
 * Generate .htaccess file dynamically
 * 
 * Usage: php commands/generate_htaccess.php
 */

// Define the root directory
$rootDir = dirname(__DIR__);
$htaccessPath = $rootDir . '/.htaccess';
$pagesDir = $rootDir . '/pages';

// Manual configuration for special routes
$manualRoutes = [
    'dynamic_routes' => [
        '^projects/([^/]+)?/?$' => 'pages/article.php?type=project&slug=$1',
        '^blogs/([^/]+)?/?$' => 'pages/article.php?type=blog&slug=$1',
    ],
    'error_pages' => [
        401 => '/errors/401.php',
        403 => '/errors/403.php',
        404 => '/errors/404.php',
        500 => '/errors/500.php',
        502 => '/errors/502.php',
        503 => '/errors/503.php',
    ],
];

// Discover routes from pages directory
$routes = discoverRoutes($pagesDir);

/**
 * Recursively discover all PHP files in the pages directory
 * and generate route mappings
 */
function discoverRoutes($directory, $basePath = '') {
    $discovered = [
        'public_pages' => [],
        'admin_pages' => [],
        'tools' => [],
    ];
    
    if (!is_dir($directory)) {
        echo "Warning: Pages directory not found: $directory\n";
        return $discovered;
    }
    
    $items = scandir($directory);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..' || $item === 'templates') {
            continue;
        }
        
        $fullPath = $directory . '/' . $item;
        $relativePath = $basePath ? $basePath . '/' . $item : $item;
        
        if (is_dir($fullPath)) {
            // Recursively scan subdirectories
            $subRoutes = discoverRoutes($fullPath, $relativePath);
            $discovered['public_pages'] = array_merge($discovered['public_pages'], $subRoutes['public_pages']);
            $discovered['admin_pages'] = array_merge($discovered['admin_pages'], $subRoutes['admin_pages']);
            $discovered['tools'] = array_merge($discovered['tools'], $subRoutes['tools']);
        } elseif (pathinfo($item, PATHINFO_EXTENSION) === 'php') {
            // Generate route from file path
            $fileName = pathinfo($item, PATHINFO_FILENAME);
            $target = 'pages/' . $relativePath;
            
            // Determine route URL and category
            if (strpos($relativePath, 'admin/') === 0) {
                // Admin routes
                $routeUrl = str_replace('.php', '', $relativePath);
                $discovered['admin_pages'][$routeUrl] = $target;
            } elseif (strpos($relativePath, 'tools/') === 0) {
                // Tools routes
                $routeUrl = str_replace('.php', '', $relativePath);
                $discovered['tools'][$routeUrl] = $target;
            } else {
                // Public routes
                if (strpos($relativePath, '/') === false) {
                    // Top-level page (e.g., about.php, contact.php)
                    $routeUrl = $fileName;
                } else {
                    // Nested page - use full path without .php
                    $routeUrl = str_replace('.php', '', $relativePath);
                }
                $discovered['public_pages'][$routeUrl] = $target;
            }
        }
    }
    
    return $discovered;
}

// Generate .htaccess content
$content = <<<HTACCESS
# force index loading only
DirectoryIndex index.php

# Enable URL rewriting
RewriteEngine On

HTACCESS;

// Add dynamic routes (these need to come first to match before static routes)
$content .= "# Redirect to internal pages\n";
foreach ($manualRoutes['dynamic_routes'] as $pattern => $target) {
    $content .= "RewriteRule $pattern $target [L,QSA]\n";
}

// Add static page routes
$content .= "\n# Add specific rewrite rules for other pages\n";
foreach ($routes['public_pages'] as $route => $target) {
    $content .= "RewriteRule ^{$route}?/?$ $target [L,QSA]\n";
}

// Add admin routes
$content .= "\n# Admin module\n";
foreach ($routes['admin_pages'] as $route => $target) {
    $content .= "RewriteRule ^{$route}/?$ $target [L,QSA]\n";
}

// Add tools routes
$content .= "\n# Tools module\n";
foreach ($routes['tools'] as $route => $target) {
    $content .= "RewriteRule ^{$route}?/?$ $target [L,QSA]\n";
}

// Add custom error pages
$content .= "\n# Custom error pages\n";
foreach ($manualRoutes['error_pages'] as $code => $page) {
    $content .= "ErrorDocument $code $page\n";
}

// Write to file
try {
    $result = file_put_contents($htaccessPath, $content);
    
    if ($result !== false) {
        echo "✓ Successfully generated .htaccess file\n";
        echo "  Location: $htaccessPath\n";
        echo "  Size: " . formatBytes($result) . "\n";
        echo "\n";
        echo "Routes configured:\n";
        echo "  - Public pages: " . count($routes['public_pages']) . "\n";
        echo "  - Dynamic routes: " . count($manualRoutes['dynamic_routes']) . "\n";
        echo "  - Admin pages: " . count($routes['admin_pages']) . "\n";
        echo "  - Tools: " . count($routes['tools']) . "\n";
        echo "  - Error pages: " . count($manualRoutes['error_pages']) . "\n";
        echo "\n";
        echo "Discovered routes:\n";
        
        // Show public routes
        if (!empty($routes['public_pages'])) {
            echo "  Public:\n";
            foreach ($routes['public_pages'] as $route => $target) {
                echo "    - /$route → $target\n";
            }
        }
        
        // Show admin routes
        if (!empty($routes['admin_pages'])) {
            echo "\n  Admin:\n";
            foreach ($routes['admin_pages'] as $route => $target) {
                echo "    - /$route → $target\n";
            }
        }
        
        // Show tools routes
        if (!empty($routes['tools'])) {
            echo "\n  Tools:\n";
            foreach ($routes['tools'] as $route => $target) {
                echo "    - /$route → $target\n";
            }
        }
        
        exit(0);
    } else {
        echo "✗ Error: Failed to write .htaccess file\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Format bytes to human readable format
 */
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
