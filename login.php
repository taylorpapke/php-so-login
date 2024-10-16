<?php
require_once 'vendor/autoload.php';

$config = require 'config.php';

// Initialize the Google Client
$client = new Google_Client();
$client->setClientId($config['YOUR_GOOGLE_CLIENT_ID']);
$client->setClientSecret($config['YOUR_GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri('http://localhost:8000/callback.php');  // Ensure this matches your Google console setup
$client->addScope("email");
$client->addScope("profile");

// Create the Google OAuth URL
$authUrl = $client->createAuthUrl();

// Show the login link
echo "<a href='" . htmlspecialchars($authUrl) . "'>Login with Google</a>";