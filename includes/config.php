<?php

// Require the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load the environment variables from the .env file
$env = getenv('APP_ENV') ?: 'local';  // Default to 'development'
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env.' . $env);
$dotenv->load();

// Application configuration
define('APP_NAME', $_ENV['APP_NAME'] ?? 'My App');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost');
define('APP_ENV', $env);
define('APP_DEBUG', $_ENV['APP_DEBUG'] ?? true);
define('URL_REWRITING', $_ENV['URL_REWRITING'] ?? false);

// Database configuration
define('DB_HOST', $_ENV['DB_HOST'] ?? '');
define('DB_PORT', $_ENV['DB_PORT'] ?? '');
define('DB_DATABASE', $_ENV['DB_DATABASE'] ?? '');
define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? '');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');

// Mail configuration
define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? '');
define('MAIL_PORT', $_ENV['MAIL_PORT'] ?? '');
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');
define('MAIL_FROM', $_ENV['MAIL_FROM'] ?? 'noreply@example.com');
define('MAIL_FROM_NAME', $_ENV['MAIL_FROM_NAME'] ?? 'Example');

// Constants for socials
define('SOCIAL_LINKEDIN', $_ENV['SOCIAL_LINKEDIN'] ?? '');
define('SOCIAL_GITHUB', $_ENV['SOCIAL_GITHUB'] ?? '');
define('SOCIAL_MEDIUM', $_ENV['SOCIAL_MEDIUM'] ?? '');
define('SOCIAL_INSTAGRAM', $_ENV['SOCIAL_INSTAGRAM'] ?? '');
define('SOCIAL_FACEBOOK', $_ENV['SOCIAL_FACEBOOK'] ?? '');
define('SOCIAL_TWITTER', $_ENV['SOCIAL_TWITTER'] ?? '');
define('SOCIAL_YOUTUBE', $_ENV['SOCIAL_YOUTUBE'] ?? '');

// Constants for contact details
define('CONTACT_PHONE', $_ENV['CONTACT_PHONE'] ?? '');
define('CONTACT_PHONE2', $_ENV['CONTACT_PHONE2'] ?? '');
define('CONTACT_ADDRESS', $_ENV['CONTACT_ADDRESS'] ?? '');
define('CONTACT_EMAIL', $_ENV['CONTACT_EMAIL'] ?? '');
define('CONTACT_EMAIL2', $_ENV['CONTACT_EMAIL2'] ?? '');
define('CONTACT_ADDRESS_2', $_ENV['CONTACT_ADDRESS_2'] ?? '');