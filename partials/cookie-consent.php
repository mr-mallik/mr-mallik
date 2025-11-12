<?php
/**
 * Cookie Consent Banner Component
 * GDPR/EEA compliant cookie consent banner
 */

require_once __DIR__ . '/../includes/cookies/CookieConsent.php';

$cookieConsent = new CookieConsent();
?>

<!-- Cookie Consent Banner -->
<div id="cookieConsentBanner" class="cookie-consent-banner" style="display: none;">
    <div class="cookie-consent-content">
        <div class="cookie-consent-text">
            <h3><i class="fas fa-cookie-bite"></i> We Use Cookies</h3>
            <p>We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. 
               By clicking "Accept All", you consent to our use of cookies. You can manage your preferences or learn more 
               about our practices in our <a href="<?= url('privacy-policy') ?>" target="_blank">Privacy Policy</a>.</p>
        </div>
        <div class="cookie-consent-actions">
            <button id="acceptAllCookies" class="btn btn-accept">
                <i class="fas fa-check"></i> Accept All
            </button>
            <button id="acceptNecessaryCookies" class="btn btn-necessary">
                <i class="fas fa-shield-alt"></i> Necessary Only
            </button>
            <button id="customizeCookies" class="btn btn-customize">
                <i class="fas fa-cog"></i> Customize
            </button>
            <button id="rejectAllCookies" class="btn btn-reject">
                <i class="fas fa-times"></i> Reject All
            </button>
        </div>
    </div>
</div>

<!-- Cookie Preferences Modal -->
<div id="cookiePreferencesModal" class="cookie-modal" style="display: none;">
    <div class="cookie-modal-content">
        <div class="cookie-modal-header">
            <h3><i class="fas fa-cookie-bite"></i> Cookie Preferences</h3>
            <button id="closeCookieModal" class="modal-close">&times;</button>
        </div>
        <div class="cookie-modal-body">
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="necessaryCookies" checked disabled>
                        <span class="slider"></span>
                    </label>
                    <div class="cookie-category-info">
                        <h4>Necessary Cookies <span class="required-badge">Required</span></h4>
                        <p>These cookies are essential for the website to function properly. They enable basic features like page navigation and access to secure areas.</p>
                    </div>
                </div>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="analyticsCookies">
                        <span class="slider"></span>
                    </label>
                    <div class="cookie-category-info">
                        <h4>Analytics Cookies</h4>
                        <p>These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.</p>
                        <small><strong>Examples:</strong> Google Analytics, visitor tracking</small>
                    </div>
                </div>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="marketingCookies">
                        <span class="slider"></span>
                    </label>
                    <div class="cookie-category-info">
                        <h4>Marketing Cookies</h4>
                        <p>These cookies are used to track visitors across websites to display relevant advertisements and measure campaign effectiveness.</p>
                        <small><strong>Examples:</strong> Social media pixels, advertising networks</small>
                    </div>
                </div>
            </div>
            
            <div class="cookie-category">
                <div class="cookie-category-header">
                    <label class="cookie-switch">
                        <input type="checkbox" id="functionalCookies">
                        <span class="slider"></span>
                    </label>
                    <div class="cookie-category-info">
                        <h4>Functional Cookies</h4>
                        <p>These cookies enable enhanced functionality and personalization, such as remembering your preferences and settings.</p>
                        <small><strong>Examples:</strong> Theme preferences, language settings</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="cookie-modal-footer">
            <button id="saveCustomPreferences" class="btn btn-accept">
                <i class="fas fa-save"></i> Save Preferences
            </button>
            <button id="acceptAllFromModal" class="btn btn-accept-all">
                <i class="fas fa-check-double"></i> Accept All
            </button>
        </div>
    </div>
</div>

<!-- Cookie Settings Link (always visible) -->
<div id="cookieSettingsLink" class="cookie-settings-link" style="display: none;">
    <button id="reopenCookieSettings" title="Cookie Settings">
        <i class="fas fa-cookie-bite"></i>
    </button>
</div>

<style>
/* Cookie Consent Banner Styles */
.cookie-consent-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    padding: 20px;
    box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
    z-index: 10000;
    border-top: 3px solid #3498db;
    animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
    from { transform: translateY(100%); }
    to { transform: translateY(0); }
}

.cookie-consent-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cookie-consent-text {
    flex: 1;
    min-width: 300px;
}

.cookie-consent-text h3 {
    margin: 0 0 10px 0;
    font-size: 1.2em;
    font-weight: 600;
}

.cookie-consent-text h3 i {
    color: #f39c12;
    margin-right: 8px;
}

.cookie-consent-text p {
    margin: 0;
    line-height: 1.5;
    font-size: 0.95em;
}

.cookie-consent-text a {
    color: #3498db;
    text-decoration: underline;
}

.cookie-consent-text a:hover {
    color: #5dade2;
}

.cookie-consent-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9em;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.btn i {
    font-size: 0.85em;
}

.btn-accept {
    background: #27ae60;
    color: white;
}

.btn-accept:hover {
    background: #229f56;
    transform: translateY(-1px);
}

.btn-necessary {
    background: #3498db;
    color: white;
}

.btn-necessary:hover {
    background: #2980b9;
    transform: translateY(-1px);
}

.btn-customize {
    background: #f39c12;
    color: white;
}

.btn-customize:hover {
    background: #e67e22;
    transform: translateY(-1px);
}

.btn-reject {
    background: #e74c3c;
    color: white;
}

.btn-reject:hover {
    background: #c0392b;
    transform: translateY(-1px);
}

.btn-accept-all {
    background: #16a085;
    color: white;
}

.btn-accept-all:hover {
    background: #138d75;
    transform: translateY(-1px);
}

/* Cookie Preferences Modal */
.cookie-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 10001;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.cookie-modal-content {
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { transform: scale(0.9) translateY(-20px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
}

.cookie-modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8f9fa;
    border-radius: 12px 12px 0 0;
}

.cookie-modal-header h3 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.3em;
}

.cookie-modal-header h3 i {
    color: #f39c12;
    margin-right: 8px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5em;
    cursor: pointer;
    color: #7f8c8d;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: #ecf0f1;
    color: #e74c3c;
}

.cookie-modal-body {
    padding: 20px 24px;
}

.cookie-category {
    margin-bottom: 20px;
    padding: 16px;
    border: 1px solid #ecf0f1;
    border-radius: 8px;
    background: #fafbfc;
}

.cookie-category-header {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.cookie-category-info h4 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-size: 1.1em;
    display: flex;
    align-items: center;
    gap: 8px;
}

.required-badge {
    background: #e74c3c;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7em;
    font-weight: 500;
}

.cookie-category-info p {
    margin: 0 0 8px 0;
    color: #5d6d7e;
    line-height: 1.5;
}

.cookie-category-info small {
    color: #7f8c8d;
    font-style: italic;
}

/* Cookie Switch Styles */
.cookie-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    margin-top: 2px;
}

.cookie-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #bdc3c7;
    transition: 0.3s;
    border-radius: 26px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

input:checked + .slider {
    background-color: #27ae60;
}

input:checked + .slider:before {
    transform: translateX(24px);
}

input:disabled + .slider {
    background-color: #95a5a6;
    cursor: not-allowed;
}

.cookie-modal-footer {
    padding: 20px 24px;
    border-top: 1px solid #ecf0f1;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    background: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

/* Cookie Settings Link */
.cookie-settings-link {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}

.cookie-settings-link button {
    background: #3498db;
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    font-size: 1.2em;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.cookie-settings-link button:hover {
    background: #2980b9;
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(52, 152, 219, 0.4);
}

/* Dark mode support */
.dark .cookie-modal-content {
    background: #374151;
    color: white;
}

.dark .cookie-modal-header {
    background: #4b5563;
    border-bottom-color: #6b7280;
}

.dark .cookie-modal-header h3 {
    color: #f9fafb;
}

.dark .cookie-modal-footer {
    background: #4b5563;
    border-top-color: #6b7280;
}

.dark .cookie-category {
    background: #4b5563;
    border-color: #6b7280;
}

.dark .cookie-category-info h4 {
    color: #f9fafb;
}

.dark .cookie-category-info p {
    color: #d1d5db;
}

.dark .cookie-category-info small {
    color: #9ca3af;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .cookie-consent-content {
        flex-direction: column;
        text-align: center;
    }
    
    .cookie-consent-actions {
        justify-content: center;
        width: 100%;
    }
    
    .btn {
        flex: 1;
        min-width: 120px;
    }
    
    .cookie-modal-content {
        width: 95%;
        margin: 20px;
    }
    
    .cookie-category-header {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
    
    .cookie-modal-footer {
        flex-direction: column;
    }
    
    .cookie-modal-footer .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .cookie-consent-banner {
        padding: 15px;
    }
    
    .cookie-consent-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
class CookieConsentManager {
    constructor() {
        this.cookieName = 'cookie_consent';
        this.consentDuration = 365; // days
        this.apiEndpoint = '<?php echo url("api/cookie-consent.php", false); ?>';
        
        this.init();
    }
    
    init() {
        // Show banner if no consent given
        if (!this.hasConsent()) {
            this.showBanner();
        } else {
            this.showSettingsLink();
        }
        
        // Bind event listeners
        this.bindEvents();
        
        // Load existing preferences
        this.loadPreferences();
    }
    
    bindEvents() {
        // Banner buttons
        document.getElementById('acceptAllCookies')?.addEventListener('click', () => this.acceptAll());
        document.getElementById('acceptNecessaryCookies')?.addEventListener('click', () => this.acceptNecessary());
        document.getElementById('customizeCookies')?.addEventListener('click', () => this.showCustomizeModal());
        document.getElementById('rejectAllCookies')?.addEventListener('click', () => this.rejectAll());
        
        // Modal buttons
        document.getElementById('closeCookieModal')?.addEventListener('click', () => this.hideCustomizeModal());
        document.getElementById('saveCustomPreferences')?.addEventListener('click', () => this.saveCustomPreferences());
        document.getElementById('acceptAllFromModal')?.addEventListener('click', () => this.acceptAllFromModal());
        
        // Settings link
        document.getElementById('reopenCookieSettings')?.addEventListener('click', () => this.showCustomizeModal());
        
        // Close modal on outside click
        document.getElementById('cookiePreferencesModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'cookiePreferencesModal') {
                this.hideCustomizeModal();
            }
        });
    }
    
    hasConsent() {
        return document.cookie.split(';').some(cookie => cookie.trim().startsWith(`${this.cookieName}=`));
    }
    
    getConsent() {
        const cookie = document.cookie.split(';').find(cookie => cookie.trim().startsWith(`${this.cookieName}=`));
        if (cookie) {
            try {
                return JSON.parse(decodeURIComponent(cookie.split('=')[1]));
            } catch (e) {
                return null;
            }
        }
        return null;
    }
    
    setConsent(preferences) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (this.consentDuration * 24 * 60 * 60 * 1000));
        
        const cookieValue = encodeURIComponent(JSON.stringify(preferences));
        document.cookie = `${this.cookieName}=${cookieValue}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
        
        return preferences;
    }
    
    showBanner() {
        const banner = document.getElementById('cookieConsentBanner');
        if (banner) {
            banner.style.display = 'block';
        }
    }
    
    hideBanner() {
        const banner = document.getElementById('cookieConsentBanner');
        if (banner) {
            banner.style.display = 'none';
        }
        this.showSettingsLink();
    }
    
    showSettingsLink() {
        const link = document.getElementById('cookieSettingsLink');
        if (link) {
            link.style.display = 'block';
        }
    }
    
    showCustomizeModal() {
        const modal = document.getElementById('cookiePreferencesModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }
    
    hideCustomizeModal() {
        const modal = document.getElementById('cookiePreferencesModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
    
    loadPreferences() {
        const consent = this.getConsent();
        if (consent && consent.categories) {
            document.getElementById('analyticsCookies').checked = consent.categories.analytics || false;
            document.getElementById('marketingCookies').checked = consent.categories.marketing || false;
            document.getElementById('functionalCookies').checked = consent.categories.functional || false;
        }
    }
    
    async logConsent(action, consentData) {
        try {
            const response = await fetch(this.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    consent_data: consentData
                })
            });
            
            const result = await response.json();
            if (!result.success) {
                console.warn('Failed to log consent:', result.error);
            }
        } catch (error) {
            console.warn('Error logging consent:', error);
        }
    }
    
    async acceptAll() {
        const preferences = {
            timestamp: new Date().toISOString(),
            action: 'accept_all',
            categories: {
                necessary: true,
                analytics: true,
                marketing: true,
                functional: true
            }
        };
        
        this.setConsent(preferences);
        await this.logConsent('accept_all', preferences);
        this.hideBanner();
        this.hideCustomizeModal();
        
        // Reload page to activate all tracking
        window.location.reload();
    }
    
    async acceptNecessary() {
        const preferences = {
            timestamp: new Date().toISOString(),
            action: 'accept_necessary',
            categories: {
                necessary: true,
                analytics: false,
                marketing: false,
                functional: false
            }
        };
        
        this.setConsent(preferences);
        await this.logConsent('accept_necessary', preferences);
        this.hideBanner();
        this.hideCustomizeModal();
    }
    
    async rejectAll() {
        const preferences = {
            timestamp: new Date().toISOString(),
            action: 'reject_all',
            categories: {
                necessary: true,
                analytics: false,
                marketing: false,
                functional: false
            }
        };
        
        this.setConsent(preferences);
        await this.logConsent('reject_all', preferences);
        this.hideBanner();
        this.hideCustomizeModal();
    }
    
    async saveCustomPreferences() {
        const preferences = {
            timestamp: new Date().toISOString(),
            action: 'customize',
            categories: {
                necessary: true,
                analytics: document.getElementById('analyticsCookies').checked,
                marketing: document.getElementById('marketingCookies').checked,
                functional: document.getElementById('functionalCookies').checked
            }
        };
        
        this.setConsent(preferences);
        await this.logConsent('customize', preferences);
        this.hideBanner();
        this.hideCustomizeModal();
        
        // Reload if analytics were enabled to activate tracking
        if (preferences.categories.analytics) {
            window.location.reload();
        }
    }
    
    async acceptAllFromModal() {
        document.getElementById('analyticsCookies').checked = true;
        document.getElementById('marketingCookies').checked = true;
        document.getElementById('functionalCookies').checked = true;
        
        await this.acceptAll();
    }
    
    // Public methods for checking consent
    isCategoryAllowed(category) {
        const consent = this.getConsent();
        if (!consent) return false;
        
        if (category === 'necessary') return true;
        
        return consent.categories && consent.categories[category] === true;
    }
    
    // Method to check if specific scripts should load
    canLoadAnalytics() {
        return this.isCategoryAllowed('analytics');
    }
    
    canLoadMarketing() {
        return this.isCategoryAllowed('marketing');
    }
    
    canLoadFunctional() {
        return this.isCategoryAllowed('functional');
    }
}

// Initialize cookie consent manager
document.addEventListener('DOMContentLoaded', function() {
    window.cookieConsent = new CookieConsentManager();
});

// Global function to check consent (for use in other scripts)
window.checkCookieConsent = function(category) {
    if (window.cookieConsent) {
        return window.cookieConsent.isCategoryAllowed(category);
    }
    return false;
};
</script>