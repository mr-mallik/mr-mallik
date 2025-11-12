<?php
/**
 * Cookie Consent API Endpoint
 * Handles AJAX requests for cookie consent actions
 */

require_once '../includes/config.php';
require_once '../includes/cookies/CookieConsent.php';

// Set JSON response headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    $action = $input['action'] ?? '';
    $consentData = $input['consent_data'] ?? [];
    
    if (empty($action)) {
        throw new Exception('Action is required');
    }
    
    // Initialize consent handler
    $cookieConsent = new CookieConsent();
    
    // Log the consent action
    $consentId = $cookieConsent->logConsent($action, $consentData);
    
    // Prepare response
    $response = [
        'success' => true,
        'message' => 'Consent logged successfully',
        'consent_id' => $consentId,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    // Add specific response data based on action
    switch ($action) {
        case 'accept_all':
            $response['message'] = 'All cookies accepted and logged';
            break;
        case 'accept_necessary':
            $response['message'] = 'Only necessary cookies accepted and logged';
            break;
        case 'reject_all':
            $response['message'] = 'All non-necessary cookies rejected and logged';
            break;
        case 'customize':
            $response['message'] = 'Custom cookie preferences saved and logged';
            break;
        default:
            $response['message'] = 'Cookie consent action logged';
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}