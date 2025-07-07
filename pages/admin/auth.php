<?php
require_once __DIR__ . '/../../includes/admin-common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        redirect("/admin/login", "error", "Username and password are required.");
    }

    // Attempt login
    if (loginAdmin($username, $password)) {
        redirect("/admin", "success", "Login successful!");
    } else {
        redirect("/admin/login", "error", "Invalid username or password.");
    }
}
?>