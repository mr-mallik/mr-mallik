<?php
require_once __DIR__ . '/../includes/common.php'; # config file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($username) || empty($password)) {
        redirect("/finance", "error", "Username and password is required.");
    }

    $q = DBQuery($CONN, "SELECT * FROM `profile` WHERE email = '$username'");
    $result = DBFetch($q);

    if ($result) {

        $md5Hash = md5($password);
        $passwordHash = $result['password'];

        // echo password_hash(md5('password'), PASSWORD_DEFAULT) . "<br/>";
        // echo $md5Hash . "==" . $passwordHash . "<br/>";
        // exit;

        if(empty($passwordHash) || empty($md5Hash)) {
            redirect("/finance", "error", "Invalid username or password.");
        }
        
        if (password_verify($md5Hash, $passwordHash)) {
            redirect("/finance/accounts");
        } else {
            redirect("/finance", "error", "Invalid username or password.");
        }
    } else {
        redirect("/finance", "error", "Invalid username or password.");
    }
}
?>