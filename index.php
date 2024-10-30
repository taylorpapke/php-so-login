<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
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

// Microsoft OAuth setup
$microsoft_client = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => $config['microsoft_client_id'],
    'clientSecret'            => $config['microsoft_client_secret'],
    'redirectUri'             => $config['microsoft_redirect_uri'],
    'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
    'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
    'scopes'                  => ['https://experientialai.onmicrosoft.com/microsoft-sso/openid', 'email', 'profile'],
]);

// Amazon SSO URL
$amazon_auth_url = sprintf(
    // 'https://%s/oauth2/authorize?response_type=code&client_id=%s&redirect_uri=%s&scope=openid profile email',
    'https://%s/oauth2/authorize?response_type=code&client_id=%s&redirect_uri=%s&scope=openid profile email&prompt=login',
    $config['amazon_domain'],
    $config['amazon_client_id'],
    urlencode($config['amazon_redirect_uri'])
);

$microsoft_auth_url = $microsoft_client->getAuthorizationUrl();

// Create the Google OAuth URL
$authUrl = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            margin-top: 50px;
        }

        a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            padding: 10px;
            color: white;
            background-color: #4285F4;
            border-radius: 4px;
            width: 200px;
        }

        a:nth-child(2) {
            background-color: #2F2F2F;
        }

        .dropdown {
            margin-top: 20px;
        }

        .dropdown select {
            padding: 10px;
            width: 200px;
        }
    </style>
    <script>
        function handleFeatureChange() {
            var feature = document.getElementById('feature').value;
            if (feature === 'virtual bot') {
                window.location.href = 'virtual-bot.php';
            } else if (feature === 'content generator') {
                window.location.href = 'content-generator.php';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <a href="<?= htmlspecialchars($authUrl); ?>">Login with Google</a>
        <a href="<?= htmlspecialchars($microsoft_auth_url); ?>">Login with Microsoft</a>
        <a href="<?= htmlspecialchars($amazon_auth_url); ?>">Login with Amazon</a>

        <!-- Dropdown menu below sign-in links -->
        <div class="dropdown">
            <label for="feature">Select a feature:</label>
            <select id="feature" name="feature" onchange="handleFeatureChange()">
                <option value="">--Select a feature--</option>
                <option value="virtual bot">Virtual Bot</option>
                <option value="content generator">Content Generator</option>
            </select>
        </div>
    </div>
</body>
</html>