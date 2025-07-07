<?php
// Admin Common File - Contains shared admin functionality
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sql.php';
require_once __DIR__ . '/helper.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$CONN = DBConnect(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);

// Authentication check function
function checkAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        redirect('/admin/login', 'error', 'Please login to access admin panel.');
    }
}

// Login admin function
function loginAdmin($username, $password) {
    global $CONN;
    
    // Use prepared statement to prevent SQL injection
    $stmt = $CONN->prepare("SELECT * FROM `profile` WHERE email = ? LIMIT 1");
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $md5Hash = md5($password);
        $passwordHash = $result['password'];
        
        if (!empty($passwordHash) && password_verify($md5Hash, $passwordHash)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $result;
            return true;
        }
    }
    return false;
}

// Logout admin function
function logoutAdmin() {
    session_destroy();
    redirect('/admin/login', 'success', 'Logged out successfully.');
}

// Handle file upload
function handleFileUpload($file, $uploadDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp']) {
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    $fileName = $file['name'];
    $tmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        return ['error' => 'Invalid file type. Allowed types: ' . implode(', ', $allowedTypes)];
    }
    
    // Validate file size (max 5MB)
    if ($fileSize > 5 * 1024 * 1024) {
        return ['error' => 'File size too large. Maximum size: 5MB'];
    }
    
    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $uniqueFileName = uniqid() . '_' . time() . '.' . $fileType;
    $targetPath = $uploadDir . '/' . $uniqueFileName;
    
    // Move uploaded file
    if (move_uploaded_file($tmpName, $targetPath)) {
        return ['success' => true, 'filename' => $uniqueFileName, 'path' => $targetPath];
    }
    
    return ['error' => 'Failed to upload file'];
}

// Delete file function
function deleteFile($filePath) {
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    return false;
}

// Sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Format date
function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

// Get all skills for dropdown
function getAllSkills() {
    global $CONN;
    $stmt = $CONN->query("SELECT * FROM skills ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Pagination function
function getPaginationData($table, $currentPage = 1, $itemsPerPage = 10, $conditions = '') {
    global $CONN;
    
    $offset = ($currentPage - 1) * $itemsPerPage;
    
    // Count total items
    $countSql = "SELECT COUNT(*) as total FROM $table";
    if ($conditions) {
        $countSql .= " WHERE $conditions";
    }
    
    $stmt = $CONN->query($countSql);
    $totalItems = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    return [
        'currentPage' => $currentPage,
        'itemsPerPage' => $itemsPerPage,
        'totalItems' => $totalItems,
        'totalPages' => $totalPages,
        'offset' => $offset,
        'hasNext' => $currentPage < $totalPages,
        'hasPrev' => $currentPage > 1
    ];
}

// Generate URL slug
function generateSlug($text) {
    // Convert to lowercase
    $text = strtolower($text);
    
    // Replace spaces and special characters with hyphens
    $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
    
    // Remove multiple consecutive hyphens
    $text = preg_replace('/-+/', '-', $text);
    
    // Trim hyphens from beginning and end
    $text = trim($text, '-');
    
    return $text;
}

// Check if slug exists
function slugExists($slug, $table, $excludeId = null) {
    global $CONN;
    
    $sql = "SELECT COUNT(*) as count FROM $table WHERE urlname = ?";
    $params = [$slug];
    
    if ($excludeId) {
        $sql .= " AND project_id != ?";
        $params[] = $excludeId;
    }
    
    $stmt = $CONN->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['count'] > 0;
}

// Generate unique slug
function generateUniqueSlug($text, $table, $excludeId = null) {
    $baseSlug = generateSlug($text);
    $slug = $baseSlug;
    $counter = 1;
    
    while (slugExists($slug, $table, $excludeId)) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
    }
    
    return $slug;
}
