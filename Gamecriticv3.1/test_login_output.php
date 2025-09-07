<?php
// Test the login page output directly
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/login';
$_SERVER['HTTP_HOST'] = 'localhost:881';

require_once __DIR__ . '/app/config/Router.php';

$router = new Router();
$router->get('/login', 'Auth', 'login');

$output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Save output to file for inspection
file_put_contents('login_output.html', $output);
echo "Login output saved to login_output.html<br>";
echo "Output length: " . strlen($output) . " characters<br>";
echo "First 500 characters:<br>";
echo "<pre>" . htmlspecialchars(substr($output, 0, 500)) . "</pre>";
?>
