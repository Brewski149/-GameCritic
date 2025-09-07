<?php
// Test home page directly
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/';
$_SERVER['HTTP_HOST'] = 'localhost:881';

echo "Testing home page...<br>";

require_once __DIR__ . '/app/config/Router.php';

$router = new Router();
$router->get('/', 'Home', 'index');

try {
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    echo "Output type: " . gettype($output) . "<br>";
    echo "Output length: " . strlen($output) . "<br>";
    echo "First 500 characters:<br>";
    echo "<pre>" . htmlspecialchars(substr($output, 0, 500)) . "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>

