<?php
// Test admin add-game route
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/admin/add-game';
$_SERVER['HTTP_HOST'] = 'localhost:881';

// Start session and set admin user
session_start();
$_SESSION['user_id'] = 2;
$_SESSION['user_name'] = 'admin';
$_SESSION['user_email'] = 'admin@gamecritic.com';
$_SESSION['is_admin'] = 1;

echo "<h2>Testing Admin Add Game Route</h2>";

try {
    require_once __DIR__ . '/app/config/Router.php';
    
    $router = new Router();
    $router->get('/admin/add-game', 'Admin', 'addGame');
    
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    
    echo "Output type: " . gettype($output) . "<br>";
    echo "Output length: " . strlen($output) . "<br>";
    
    if (is_string($output)) {
        echo "<br>First 500 characters:<br>";
        echo "<pre>" . htmlspecialchars(substr($output, 0, 500)) . "</pre>";
        
        // Save full output
        file_put_contents('admin_add_game_output.html', $output);
        echo "<br><a href='admin_add_game_output.html' target='_blank'>View Full Add Game Page</a>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>


