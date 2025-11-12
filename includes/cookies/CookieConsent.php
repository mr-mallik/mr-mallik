<?php

class CookieConsent
{
    private $logDir;
    private $logFile;
    
    public function __construct()
    {
        $this->logDir = BASE_URL . 'logs/';
        $this->logFile = $this->logDir . 'cookie_consent.log';
        
        // Ensure log directory exists
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }
    }
    
    /**
     * Log cookie consent action
     */
    public function logConsent($action, $consentData = [])
    {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => $this->getClientIP(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'action' => $action, // 'accept_all', 'accept_necessary', 'reject_all', 'customize'
            'consent_data' => $consentData,
            'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? '/',
            'accept_language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown',
            'browser_info' => $this->getBrowserInfo(),
            'session_id' => session_id() ?: 'No session',
            'consent_id' => $this->generateConsentId()
        ];
        
        $logLine = json_encode($logEntry) . PHP_EOL;
        
        // Write to log file
        file_put_contents($this->logFile, $logLine, FILE_APPEND | LOCK_EX);
        
        return $logEntry['consent_id'];
    }
    
    /**
     * Get client IP address considering proxies
     */
    private function getClientIP()
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                $ip = trim($ips[0]);
                
                // Validate IP address
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }
    
    /**
     * Extract browser information from user agent
     */
    private function getBrowserInfo()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $browserInfo = [
            'browser' => 'Unknown',
            'version' => 'Unknown',
            'platform' => 'Unknown',
            'is_mobile' => false
        ];
        
        // Detect browser
        if (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches)) {
            $browserInfo['browser'] = 'Chrome';
            $browserInfo['version'] = $matches[1];
        } elseif (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
            $browserInfo['browser'] = 'Firefox';
            $browserInfo['version'] = $matches[1];
        } elseif (preg_match('/Safari\/([0-9.]+)/', $userAgent, $matches)) {
            $browserInfo['browser'] = 'Safari';
            $browserInfo['version'] = $matches[1];
        } elseif (preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches)) {
            $browserInfo['browser'] = 'Edge';
            $browserInfo['version'] = $matches[1];
        }
        
        // Detect platform
        if (strpos($userAgent, 'Windows') !== false) {
            $browserInfo['platform'] = 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $browserInfo['platform'] = 'Mac';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $browserInfo['platform'] = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $browserInfo['platform'] = 'Android';
            $browserInfo['is_mobile'] = true;
        } elseif (strpos($userAgent, 'iOS') !== false) {
            $browserInfo['platform'] = 'iOS';
            $browserInfo['is_mobile'] = true;
        }
        
        // Detect mobile
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            $browserInfo['is_mobile'] = true;
        }
        
        return $browserInfo;
    }
    
    /**
     * Generate unique consent ID
     */
    private function generateConsentId()
    {
        return 'consent_' . uniqid() . '_' . time();
    }
    
    /**
     * Check if user has given consent
     */
    public function hasConsent($cookieName = 'cookie_consent')
    {
        return isset($_COOKIE[$cookieName]);
    }
    
    /**
     * Get consent preferences from cookie
     */
    public function getConsentPreferences($cookieName = 'cookie_consent')
    {
        if (!$this->hasConsent($cookieName)) {
            return null;
        }
        
        $cookieData = $_COOKIE[$cookieName];
        return json_decode($cookieData, true);
    }
    
    /**
     * Check if specific cookie category is allowed
     */
    public function isCategoryAllowed($category, $cookieName = 'cookie_consent')
    {
        $preferences = $this->getConsentPreferences($cookieName);
        
        if (!$preferences) {
            return false;
        }
        
        // Necessary cookies are always allowed
        if ($category === 'necessary') {
            return true;
        }
        
        return isset($preferences['categories'][$category]) && $preferences['categories'][$category] === true;
    }
    
    /**
     * Get recent consent logs (for admin viewing)
     */
    public function getRecentConsentLogs($limit = 100)
    {
        if (!file_exists($this->logFile)) {
            return [];
        }
        
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = [];
        
        // Get last N lines
        $lines = array_slice($lines, -$limit);
        
        foreach ($lines as $line) {
            $logEntry = json_decode($line, true);
            if ($logEntry) {
                $logs[] = $logEntry;
            }
        }
        
        return array_reverse($logs); // Most recent first
    }
    
    /**
     * Get consent statistics
     */
    public function getConsentStats()
    {
        if (!file_exists($this->logFile)) {
            return ['total' => 0, 'accept_all' => 0, 'reject_all' => 0, 'customize' => 0];
        }
        
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $stats = ['total' => 0, 'accept_all' => 0, 'reject_all' => 0, 'customize' => 0, 'accept_necessary' => 0];
        
        foreach ($lines as $line) {
            $logEntry = json_decode($line, true);
            if ($logEntry && isset($logEntry['action'])) {
                $stats['total']++;
                $action = $logEntry['action'];
                if (isset($stats[$action])) {
                    $stats[$action]++;
                }
            }
        }
        
        return $stats;
    }
    
    /**
     * Clean old log entries (GDPR compliance - data retention)
     */
    public function cleanOldLogs($daysToKeep = 365)
    {
        if (!file_exists($this->logFile)) {
            return;
        }
        
        $lines = file($this->logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$daysToKeep} days"));
        $keptLines = [];
        
        foreach ($lines as $line) {
            $logEntry = json_decode($line, true);
            if ($logEntry && isset($logEntry['timestamp'])) {
                if ($logEntry['timestamp'] >= $cutoffDate) {
                    $keptLines[] = $line;
                }
            }
        }
        
        // Rewrite file with only recent entries
        file_put_contents($this->logFile, implode(PHP_EOL, $keptLines) . PHP_EOL);
    }
}