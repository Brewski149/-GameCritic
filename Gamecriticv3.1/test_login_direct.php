<?php
echo "=== Direct Login Test ===<br>";

// Set up the environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/login';
$_SERVER['HTTP_HOST'] = 'localhost:881';

echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Include the router
require_once __DIR__ . '/app/config/Router.php';

$router = new Router();
$router->get('/login', 'Auth', 'login');

echo "Router created<br>";

// Test the dispatch
try {
    echo "Calling dispatch...<br>";
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    echo "Dispatch completed<br>";
    echo "Output type: " . gettype($output) . "<br>";
    
    if (is_string($output)) {
        echo "Output length: " . strlen($output) . "<br>";
        echo "First 1000 characters:<br>";
        echo "<pre>" . htmlspecialchars(substr($output, 0, 1000)) . "</pre>";
    } else {
        echo "Output is not a string: " . print_r($output, true) . "<br>";
    }
    
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
