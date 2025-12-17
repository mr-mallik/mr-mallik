# Copilot Instructions - Mr Mallik Portfolio

## Architecture Overview

This is a **PHP-based portfolio website** with a custom-built admin CMS. It uses a **procedural PHP architecture** (not MVC) with shared includes, Tailwind CSS for styling, and vanilla JavaScript for interactivity.

### Core File Structure
- **Entry Points**: Pages are in root (`index.php`) and `pages/` directory
- **Includes**: All shared logic lives in `includes/` with specific purposes:
  - `common.php` - Base include that loads config, SQL helpers, and dynamic functions
  - `admin-common.php` - Separate include for admin pages with auth checks
  - `config.php` - Loads `.env` via vlucas/phpdotenv and defines constants
  - `sql.php` - Database wrapper functions (PDO-based)
  - `helper.php` - Utility functions like `url()`, `redirect()`, `show_alert_message()`
  - `dynamic.php` - Content-fetching functions like `blogList()`, `blogGet()`, `siteMenu()`
- **Partials**: `partials/header.php` and `partials/footer.php` for frontend, separate ones in `partials/admin/`
- **Database**: MySQL with PDO, connection via `DBConnect()` in `sql.php`

### Environment & Configuration

**Critical**: Always use `.env` file (loaded by `config.php`) for all configuration:
- Database credentials: `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE`
- App settings: `APP_URL`, `APP_ENV` (local/production), `MAINTENANCE_MODE`
- Social/contact info: `SOCIAL_LINKEDIN`, `CONTACT_EMAIL`, etc.

Never hardcode URLs or credentials. Use `APP_URL` constant via `url()` helper.

### Common Patterns

**Page Structure Pattern**:
```php
<?php
require_once __DIR__ . '/includes/common.php'; // or admin-common.php for admin
// Set SEO array
$SEO = ['title' => '...', 'description' => '...', 'keywords' => '...'];
require_once __DIR__ . '/partials/header.php';
?>
<!-- Page content here -->
<?php require_once __DIR__ . '/partials/footer.php'; ?>
```

**Admin Page Pattern**:
```php
<?php
require_once __DIR__ . '/../../includes/admin-common.php';
checkAdminAuth(); // Redirects if not logged in
// Admin logic here
require_once __DIR__ . '/../../partials/admin/header.php';
require_once __DIR__ . '/../../partials/admin/side-nav.php';
?>
```

**URL Generation**: Always use `url()` helper:
```php
url('assets/images/logo.png'); // Prints full URL
url('about', false); // Returns URL without printing
```

**Redirects with Flash Messages**:
```php
redirect('/admin/login', 'error', 'Please login first.');
// Display in template with: show_alert_message('error');
```

**Database Queries**:
```php
global $CONN; // Get global PDO connection
$stmt = $CONN->prepare("SELECT * FROM blog WHERE slug = ?");
$stmt->execute([$slug]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
```

## Developer Workflows

### Tailwind CSS Build
**Required after any Tailwind class changes**:
```bash
npx tailwindcss -i ./assets/css/tailwind.css -o ./assets/css/style.css --minify
```

Config is in `tailwind.config.js` with `darkMode: 'class'` and content scanning `./**/*.php` and `./**/*.html`.

### Database Schema
- Main tables: `blog` (stores both blog posts and projects via `type` field), `profile`, `resume`
- SQL snapshots in `database/` directory
- No migration system - use direct SQL imports

### Admin Authentication
- Login: `includes/admin-common.php` → `loginAdmin($username, $password)`
- Uses password_verify with MD5-hashed passwords (legacy pattern)
- Session check: `$_SESSION['admin_logged_in']`
- Auth guard: `checkAdminAuth()` function

### Cookie Consent System
Comprehensive GDPR implementation (see `docs/COOKIE_CONSENT_GUIDE.md`):
- Class: `includes/cookies/CookieConsent.php`
- Banner: `partials/cookie-consent.php` (auto-included in header)
- API: `api/cookie-consent.php` for AJAX logging
- Admin: `pages/admin/cookie-consent.php` for analytics
- Logs stored in `logs/cookie_consent_*.log`

## Project-Specific Conventions

### Naming & File Organization
- **Routes**: No framework routing - files map directly to URLs (`pages/about.php` → `/about`)
- **Assets**: Projects and stories have subfolders in `assets/projects/` and `assets/stories/`
- **Error Pages**: Custom error handlers in `errors/` (401, 403, 404, 500, etc.)
- **Maintenance Mode**: Set `MAINTENANCE_MODE=true` in `.env` to redirect all traffic to `errors/maintenance.php`

### SEO Handling
Every page sets `$SEO` array before including header:
```php
$SEO = [
    'title' => 'Page Title | Mr Mallik',
    'description' => 'Meta description',
    'keywords' => 'keyword1, keyword2',
    'image' => url('assets/images/og-image.png', false),
    'url' => url('current-page', false)
];
```

### URL Rewriting
- Controlled by `URL_REWRITING` env variable
- `APP_ENV=local` affects URL parsing in `activeUrl()` helper
- No `.htaccess` present - may need to add for production clean URLs

### Dark Mode
Uses Tailwind's `class` strategy. Toggle logic in `assets/js/app.js`. All components support `dark:` variants.

### External Integrations
- **Medium RSS**: `getMediumRssFeed()` fetches and parses author's Medium articles
- **Social Profiles**: Constants in `config.php` (SOCIAL_*, ACADEMIC_*, CONTACT_*)
- **AOS (Animate On Scroll)**: Included in `assets/js/aos/` for scroll animations

## Anti-Patterns to Avoid

❌ Don't use Laravel/Symfony patterns - this is procedural PHP  
❌ Don't create models/controllers - use direct SQL in `includes/dynamic.php`  
❌ Don't skip `url()` helper - breaks multi-environment support  
❌ Don't forget `checkAdminAuth()` on admin pages  
❌ Don't bypass the admin includes - use `admin-common.php` not `common.php`

## Key Files Reference

- Database operations: [includes/sql.php](includes/sql.php)
- Content fetchers: [includes/dynamic.php](includes/dynamic.php)
- Admin auth: [includes/admin-common.php](includes/admin-common.php#L15-L19)
- Cookie consent: [docs/COOKIE_CONSENT_GUIDE.md](docs/COOKIE_CONSENT_GUIDE.md)
- Tailwind config: [tailwind.config.js](tailwind.config.js)
