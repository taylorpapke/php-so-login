# php-sso-login

Step-by-Step Guide to Starting a PHP Server
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
