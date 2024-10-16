<?php
session_start();

// Check if the user is logged in by checking the access token
if (!isset($_SESSION['access_token'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Check if user info is set in the session
if (isset($_SESSION['user_info'])) {
    $google_id = $_SESSION['user_info']['id'];
    $name = $_SESSION['user_info']['name'];
    $email = $_SESSION['user_info']['email'];
} else {
    // If not set, display a default message or handle the error gracefully
    $google_id = 'Not available';
    $name = 'Not available';
    $email = 'Not available';
}

// Display user info
echo "<h1>Welcome to the Protected Page!</h1>";
echo "<p>Google ID: " . htmlspecialchars($google_id) . "</p>";
echo "<p>Name: " . htmlspecialchars($name) . "</p>";
echo "<p>Email: " . htmlspecialchars($email) . "</p>";

// Provide a logout link
echo '<a href="logout.php">Logout</a>';