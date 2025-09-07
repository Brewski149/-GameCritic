<?php
// Debug router
echo "Testing router...<br>";

// Simulate the request
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/login';
$_SERVER['HTTP_HOST'] = 'localhost:881';

echo "Original URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Include the router
require_once __DIR__ . '/app/config/Router.php';

$router = new Router();

// Define routes
$router->get('/', 'Home', 'index');
$router->get('/login', 'Auth', 'login');

echo "Router created successfully<br>";

// Test dispatch
try {
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    echo "Router output: " . (is_string($output) ? $output : 'No string output') . "<br>";
} catch (Exception $e) {
    echo "Router error: " . $e->getMessage() . "<br>";
}
?>
