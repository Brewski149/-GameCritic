<?php
echo "=== Detailed Router Debug ===<br>";

// Simulate the request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/login';
$_SERVER['HTTP_HOST'] = 'localhost:881';

echo "Original URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Test URI processing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo "Parsed URI: " . $uri . "<br>";

// Handle Gamecritic subfolder
if (strpos($uri, '/Gamecritic') === 0) {
    $uri = substr($uri, strlen('/Gamecritic'));
    echo "After removing /Gamecritic: " . $uri . "<br>";
}

// Handle public subfolder
if (strpos($uri, '/public') === 0) {
    $uri = substr($uri, strlen('/public'));
    echo "After removing /public: " . $uri . "<br>";
}

echo "Final processed URI: " . $uri . "<br>";

// Test if we can include the files
echo "<br>=== Testing File Includes ===<br>";

if (file_exists(__DIR__ . '/app/config/Router.php')) {
    echo "Router.php exists<br>";
} else {
    echo "Router.php NOT found<br>";
}

if (file_exists(__DIR__ . '/app/controllers/AuthController.php')) {
    echo "AuthController.php exists<br>";
} else {
    echo "AuthController.php NOT found<br>";
}

if (file_exists(__DIR__ . '/app/views/auth/login.php')) {
    echo "login.php view exists<br>";
} else {
    echo "login.php view NOT found<br>";
}

echo "<br>=== Testing Router ===<br>";

try {
    require_once __DIR__ . '/app/config/Router.php';
    echo "Router included successfully<br>";
    
    $router = new Router();
    echo "Router instance created<br>";
    
    // Define just the login route
    $router->get('/login', 'Auth', 'login');
    echo "Login route defined<br>";
    
    // Test dispatch
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    echo "Router dispatch completed<br>";
    echo "Output type: " . gettype($output) . "<br>";
    if (is_string($output)) {
        echo "Output length: " . strlen($output) . " characters<br>";
        echo "First 200 chars: " . substr($output, 0, 200) . "...<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
