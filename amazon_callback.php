<?php
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

session_start();
$config = require 'config.php';

if (isset($_GET['code'])) {
    try {
        $http = new Client();

        // Exchange the authorization code for tokens
        $response = $http->post('https://' . $config['amazon_domain'] . '/oauth2/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $config['amazon_client_id'],
                'client_secret' => $config['amazon_client_secret'],
                'redirect_uri' => $config['amazon_redirect_uri'],
                'code' => $_GET['code'],
            ],
        ]);

        $tokens = json_decode((string)$response->getBody(), true);

        // Debugging
        error_log("Tokens: " . print_r($tokens, true));

        // Use the access token to get the user details
        $response = $http->get('https://' . $config['amazon_domain'] . '/oauth2/userInfo', [
            'headers' => [
                'Authorization' => 'Bearer ' . $tokens['access_token'],
            ],
        ]);

        $user_info = json_decode((string)$response->getBody(), true);

        // Debugging
        error_log("User Info: " . print_r($user_info, true));

        // Store user info in session for future use
        $_SESSION['user_info'] = [
            'id' => $user_info['sub'],
            'name' => isset($user_info['username']) ? $user_info['username'] : 'No username provided',
            'email' => isset($user_info['email']) ? $user_info['email'] : 'No email provided',
        ];

        // Redirect to the protected page
        header('Location: protected_page.php');
        exit();
    } catch (ClientException $e) {
        // Output error message if fails
        echo "Something went wrong: " . $e->getMessage();
        exit();
    }
} else {
    // If no code is provided, redirect back to the login page
    header('Location: login.php');
    exit();
}

