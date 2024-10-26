<?php
session_start();

// Debugging
error_log("Session: " . print_r($_SESSION, true));

if (!isset($_SESSION['user_info'])) {
    header('Location: login.php');
    exit();
}

$user_info = $_SESSION['user_info'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Page</title>
</head>
<body>
    <h1>Protected Page</h1>
    <p>ID: <?= htmlspecialchars($user_info['id']) ?></p>
    <p>Name: <?= htmlspecialchars($user_info['name']) ?></p>
    <p>Email: <?= htmlspecialchars($user_info['email']) ?></p>
    <a href="logout.php">Logout</a> <!-- Add this logout link -->
</body>
</html>