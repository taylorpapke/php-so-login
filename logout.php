<?php
session_start();
session_destroy(); // Destroy the session

$config = require 'config.php'; // Add this line to include your config

// Redirect to Amazon's logout URL
$logoutUrl = sprintf(
    'https://%s/logout?client_id=%s&logout_uri=%s',
    $config['amazon_domain'],
    $config['amazon_client_id'],
    urlencode('http://localhost:8000/login.php') // Redirect back to your login page
);

header('Location: ' . $logoutUrl);
exit();
?>