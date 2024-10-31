<?php
require_once 'vendor/autoload.php';

session_start();

$config = require 'config.php';

// Initialize the Google Client
$client = new Google_Client();
$client->setClientId($config['YOUR_GOOGLE_CLIENT_ID']);
$client->setClientSecret($config['YOUR_GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($config['YOUR_GOOGLE_REDIRECT_URI']);

// If the code is in the URL, exchange it for an access token


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Store the token in the session
    $_SESSION['access_token'] = $token;

    // Set the access token in the client
    $client->setAccessToken($token);

    // Get the user's profile information from Google
    $google_service = new Google_Service_Oauth2($client);
    $user_info = $google_service->userinfo->get();

    // Store user info in session for future use
    $_SESSION['user_info'] = [
        'id' => $user_info->id,
        'name' => $user_info->name,
        'email' => $user_info->email,
    ];

    // Redirect to the protected page after login
    header('Location: protected_page.php');
    exit();
}