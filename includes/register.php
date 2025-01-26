<?php
require_once '../config/database.php';
session_start();

function jsonResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || strlen($username) < 3 || strlen($username) > 50) {
        jsonResponse(false, 'Username must be between 3 and 50 characters');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(false, 'Invalid email format');
    }

    if (strlen($password) < 8) {
        jsonResponse(false, 'Password must be at least 8 characters long');
    }

    try {
        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            jsonResponse(false, 'Username or email already exists');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $hashedPassword]);

        jsonResponse(true, 'Registration successful');
    } catch (PDOException $e) {
        error_log($e->getMessage());
        jsonResponse(false, 'Registration failed. Please try again.');
    }
}

include '../pages/register.php';
?>

