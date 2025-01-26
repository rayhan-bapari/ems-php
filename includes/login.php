<?php
require_once '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        jsonResponse(false, 'All fields are required');
    }

    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                jsonResponse(true, 'Login successful');
            } else {
                jsonResponse(false, 'Invalid credentials');
            }
        } else {
            jsonResponse(false, 'Invalid credentials');
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        jsonResponse(false, 'Login failed');
    }
}

include '../pages/login.php';
?>
