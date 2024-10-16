# php-sso-login

## Step-by-Step Guide to Starting a PHP Server

1. Install PHP

First, ensure that PHP is installed on your system. You can check this by opening a terminal (or Command Prompt) and typing:

php -v

If PHP is installed, you'll see the version of PHP that's running. If you don't have it installed, you can download PHP from:

PHP Downloads for Windows
Use a package manager for Linux (e.g., sudo apt install php for Ubuntu/Debian, or sudo yum install php for CentOS/Fedora).
On macOS, you can use Homebrew:

brew install php

2. Navigate to Your Project Directory

Once PHP is installed, navigate to the directory where your PHP files are stored (for example, the directory where you have your login.php and callback.php files).

In the terminal, use the cd command to change directories. For example:

cd /path/to/your/project

3. Start the PHP Built-In Server

Once you're in the project directory, you can start the PHP built-in server with this command:

php -S localhost:8000

localhost is your local machine.
8000 is the port number. You can change this to any available port, like 8080 or 3000.
After running this command, you should see output similar to this:

PHP 7.x.x Development Server started at http://localhost:8000
Listening on http://localhost:8000
Document root is /path/to/your/project
Press Ctrl-C to quit.

4. Access the Server in Your Browser

Now, open your web browser and go to:

http://localhost:8000

This will load the PHP files in the directory where you started the server. For example, if you have a login.php file, you can access it by visiting:

http://localhost:8000/login.php

5. Stop the Server

When you're done, you can stop the server by going back to your terminal and pressing Ctrl+C.

Alternative: Use XAMPP (for a Full PHP Stack)
If you prefer a complete solution with Apache, MySQL, and PHP in one package, you can install XAMPP (or MAMP for macOS users). Here's how:

Download and install XAMPP from https://www.apachefriends.org/index.html.
After installation, start the Apache server from the XAMPP control panel.
Place your PHP files in the htdocs folder (inside the XAMPP installation directory).
Access your files via http://localhost/your-file.php.

## Setting up Google SSO

Step 1: Set up your Google API credentials
Create a project in the Google Developer Console.
Enable the Google Sign-In API:
Go to the "API & Services" > "Library" section.
Search for "Google Sign-In" or "Google Identity".
Enable the API for your project.
Create OAuth 2.0 credentials:
Go to the "Credentials" section in the API Console.
Create an "OAuth 2.0 Client ID".
Set the application type to "Web Application".
Provide the Authorized redirect URIs where Google will redirect after successful authentication (e.g., http://localhost/your-app/callback.php).
After setting this up, you will receive a Client ID and Client Secret.

Step 2: Install the Google API PHP Client Library
You can use the Google API PHP Client Library to handle OAuth easily.

Install it via Composer:

composer require google/apiclient:^2.0

Step 3: Create the login and callback logic

Use the provided code in login.php and callback.php

Step 4: Running the app
Start your PHP server (if using localhost, run php -S localhost:8000 in the terminal in your app's directory).
Navigate to http://localhost:8000/login.php.
Click on the "Login with Google" link, which will redirect you to Google's sign-in page.
After signing in, Google will redirect you back to callback.php, where you can retrieve and display the user's info.

# Make sure to create a config.php for YOUR_GOOGLE_CLIENT_ID and YOUR_GOOGLE_CLIENT_SECRET!
