# Cookie Consent System - Implementation Guide

## Overview

This comprehensive cookie consent system provides GDPR/EEA compliant cookie management for your website. It includes:

- ✅ **Cookie Consent Banner** - User-friendly consent collection
- ✅ **Detailed Cookie Preferences** - Granular control over cookie categories
- ✅ **Comprehensive Logging** - Complete audit trail for compliance
- ✅ **Admin Dashboard** - Monitor consent statistics and logs
- ✅ **Privacy Policy Integration** - Complete privacy documentation
- ✅ **Analytics Integration** - Conditional loading based on consent

## 🚀 Quick Start

### 1. Files Created

```
includes/cookies/
├── CookieConsent.php          # Main consent handling class
partials/
├── cookie-consent.php         # Cookie banner component
api/
├── cookie-consent.php         # AJAX endpoint for consent logging
pages/admin/
├── cookie-consent.php         # Admin dashboard
privacy-policy.php             # Privacy policy page
logs/                         # Log directory (auto-created)
```

### 2. Integration Status

The cookie consent system is automatically integrated into:
- ✅ **Main Header** (`partials/header.php`) - Banner appears on all frontend pages
- ✅ **LinkedIn Tool** (`pages/tools/reachout.php`) - Conditional analytics loading
- ✅ **Privacy Policy** - Complete documentation and settings access

## 📋 Features

### Cookie Categories

1. **Necessary Cookies** (Always enabled)
   - Session management
   - Security features
   - Cookie consent preferences

2. **Analytics Cookies** (Optional)
   - Google Analytics
   - Page view tracking
   - User behavior analysis

3. **Functional Cookies** (Optional)
   - Theme preferences
   - Language settings
   - Form data storage

4. **Marketing Cookies** (Optional)
   - Social media pixels
   - Advertising networks
   - Conversion tracking

### User Interface Features

- **Mobile-responsive design**
- **Dark/light mode support**
- **Keyboard shortcuts** (Ctrl+Shift+D for theme toggle)
- **Accessibility compliant**
- **Smooth animations**
- **Professional styling**

## 🔧 Configuration

### 1. Basic Setup

The system is ready to use out of the box. The banner will appear automatically on first visit.

### 2. Customizing Cookie Categories

Edit `partials/cookie-consent.php` to modify cookie categories:

```javascript
// Add/modify categories in the saveCustomPreferences function
const preferences = {
    timestamp: new Date().toISOString(),
    action: 'customize',
    categories: {
        necessary: true,
        analytics: document.getElementById('analyticsCookies').checked,
        marketing: document.getElementById('marketingCookies').checked,
        functional: document.getElementById('functionalCookies').checked,
        // Add new categories here
        advertising: document.getElementById('advertisingCookies').checked
    }
};
```

### 3. Analytics Integration

The system includes conditional Google Analytics loading:

```javascript
// Check consent before loading analytics
if (window.checkCookieConsent && window.checkCookieConsent('analytics')) {
    // Load Google Analytics
    gtag('config', 'GA_MEASUREMENT_ID');
}
```

**Replace `GA_MEASUREMENT_ID`** with your actual Google Analytics measurement ID.

## 📊 Admin Dashboard

Access the admin dashboard at: `/pages/admin/cookie-consent.php`

### Features:
- **Consent Statistics** - Visual overview of user choices
- **Recent Logs** - Detailed consent history
- **Log Management** - GDPR-compliant data retention
- **Export Capabilities** - Data analysis and reporting

### Statistics Tracked:
- Total consents given
- Accept all percentage
- Custom preferences percentage
- Reject all percentage
- Necessary only percentage

## 🗃️ Logging System

### What's Logged:
- **Timestamp** - When consent was given
- **IP Address** - Anonymized for privacy
- **User Agent** - Browser and device information
- **Consent Action** - accept_all, reject_all, customize, etc.
- **Consent Details** - Which categories were accepted
- **Referer** - Where the user came from
- **Session ID** - For tracking user sessions
- **Browser Info** - Extracted browser, version, platform
- **Unique Consent ID** - For tracking individual consents

### Log Format:
```json
{
    "timestamp": "2025-01-12 10:30:45",
    "ip_address": "192.168.1.1",
    "user_agent": "Mozilla/5.0...",
    "action": "accept_all",
    "consent_data": {
        "categories": {
            "necessary": true,
            "analytics": true,
            "marketing": true,
            "functional": true
        }
    },
    "referer": "https://google.com",
    "request_uri": "/tools/reachout.php",
    "browser_info": {
        "browser": "Chrome",
        "version": "120.0",
        "platform": "Windows",
        "is_mobile": false
    },
    "consent_id": "consent_67823f1d2a3b5_1736687901"
}
```

## 🛡️ GDPR Compliance

### Data Retention
- **Default**: 365 days (1 year)
- **Configurable**: 30 days to 2555 days (7 years max)
- **Automatic Cleanup**: Available in admin dashboard
- **Manual Cleanup**: Run `$cookieConsent->cleanOldLogs($days)`

### User Rights Implementation
1. **Right to Access** - Admin can view all user consents
2. **Right to Rectification** - Users can update preferences anytime
3. **Right to Erasure** - Logs can be cleaned/deleted
4. **Right to Withdraw Consent** - Users can reject cookies anytime

### Privacy Policy
Complete privacy policy available at `/privacy-policy.php` including:
- Cookie categories explanation
- Data collection details
- User rights information
- Contact information
- Cookie preference management

## 🔧 Advanced Usage

### Checking Consent in Your Code

```php
// PHP - Server side
$cookieConsent = new CookieConsent();
if ($cookieConsent->isCategoryAllowed('analytics')) {
    // Load analytics tracking
}
```

```javascript
// JavaScript - Client side
if (window.checkCookieConsent('analytics')) {
    // Load analytics scripts
}
```

### Adding New Cookie Categories

1. **Update the modal HTML** in `partials/cookie-consent.php`
2. **Add category to JavaScript** consent handling
3. **Update admin dashboard** to display new category
4. **Document in privacy policy**

### Custom Styling

The system uses Tailwind CSS classes and custom CSS. Key classes:
- `.cookie-consent-banner` - Main banner styling
- `.cookie-modal` - Preferences modal
- `.cookie-category` - Individual category sections
- `.cookie-switch` - Toggle switches

## 📱 Mobile Support

- **Responsive design** - Works on all screen sizes
- **Touch-friendly** - Large buttons and touch targets
- **Mobile-specific** - Detects mobile devices in logs
- **Adaptive layout** - Stacks elements on small screens

## 🎨 Theme Support

- **Dark/Light mode** - Automatic theme detection
- **Custom themes** - Easy to customize colors
- **System preference** - Respects user's OS setting
- **Theme persistence** - Remembers user's choice

## 🔍 Testing

### Test Scenarios:
1. **First Visit** - Banner should appear
2. **Accept All** - All categories enabled, banner hidden
3. **Reject All** - Only necessary cookies, banner hidden
4. **Customize** - Modal opens, user can select categories
5. **Settings Link** - Always visible for preference changes
6. **Analytics Loading** - Conditional based on consent
7. **Log Generation** - All actions logged to file

### Browser Testing:
- ✅ Chrome/Chromium
- ✅ Firefox
- ✅ Safari
- ✅ Edge
- ✅ Mobile browsers

## 🚨 Troubleshooting

### Common Issues:

1. **Banner Not Showing**
   - Check if cookie already exists
   - Verify JavaScript console for errors
   - Ensure `partials/cookie-consent.php` is included

2. **Analytics Not Loading**
   - Check consent status in browser console
   - Verify GA measurement ID is correct
   - Check network tab for blocked requests

3. **Logs Not Being Created**
   - Check `logs/` directory permissions (755)
   - Verify API endpoint is accessible
   - Check server error logs

4. **Admin Dashboard Issues**
   - Ensure admin authentication is working
   - Check file permissions on log files
   - Verify all required files exist

### Debug Mode:
Add to browser console:
```javascript
// Check current consent status
console.log(window.cookieConsent.getConsent());

// Check specific category
console.log(window.checkCookieConsent('analytics'));
```

## 📈 Performance

- **Minimal impact** - Only loads when needed
- **Lazy loading** - Analytics loaded after consent
- **Efficient storage** - Uses cookies, not localStorage
- **Optimized CSS** - Minimal custom styles
- **CDN usage** - External libraries from CDN

## 🔄 Updates & Maintenance

### Regular Tasks:
1. **Monitor consent logs** - Check admin dashboard monthly
2. **Clean old logs** - Maintain GDPR compliance
3. **Update privacy policy** - When adding new features
4. **Test functionality** - After any website updates

### Version Control:
- Current version: 1.0.0
- Last updated: January 2025
- Next review: January 2026

## 📞 Support

For questions or issues:
- **Email**: gulger.mallik@gmail.com
- **Documentation**: This file
- **Admin Dashboard**: Check logs and statistics
- **Privacy Policy**: `/privacy-policy.php`

---

**Note**: This system is designed to be compliant with GDPR and other privacy regulations. However, you should consult with legal experts to ensure full compliance for your specific use case and jurisdiction.