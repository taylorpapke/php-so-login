<?php
require_once 'vendor/autoload.php';
session_start();

$config = require 'config.php';

$microsoft_client = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => $config['microsoft_client_id'],
    'clientSecret'            => $config['microsoft_client_secret'],
    'redirectUri'             => $config['microsoft_redirect_uri'],
    'urlAuthorize'            => 'https://experientialai.b2clogin.com/experientialai.onmicrosoft.com/oauth2/v2.0/authorize?p=B2C_1_sign-in',
    'urlAccessToken'          => 'https://experientialai.b2clogin.com/experientialai.onmicrosoft.com/oauth2/v2.0/token?p=B2C_1_sign-in',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
    'scopes'                  => ['https://experientialai.onmicrosoft.com/microsoft-sso/openid', 'email', 'profile'],
]);

// Check if the user has returned with an authorization code
if (isset($_GET['code'])) {
    try {
        // Exchange the authorization code for an access token
        $accessToken = $microsoft_client->getAccessToken('authorization_code', [
            'code' => $_GET['code'],
        ]);

        // Use the access token to get the user details
        $resourceOwner = $microsoft_client->getResourceOwner($accessToken);
        $user_info = $resourceOwner->toArray();

        // Store user info in session for future use
        $_SESSION['access_token'] = $accessToken->getToken();
        $_SESSION['user_info'] = [
            'id' => $user_info['id'],
            'name' => $user_info['displayName'],
            'email' => $user_info['userPrincipalName'],
        ];

        // Redirect to the protected page
        header('Location: protected_page.php');
        exit();
    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
        // Failed to get access token or user details
        exit('Something went wrong: ' . $e->getMessage());
    }
} else {
    // If no code in the URL, redirect back to the login page
    header('Location: index.php');
    exit();
}