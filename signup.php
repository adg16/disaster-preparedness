<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);
        echo json_encode(['status' => 'success', 'message' => 'Account created']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    }
}
?>
