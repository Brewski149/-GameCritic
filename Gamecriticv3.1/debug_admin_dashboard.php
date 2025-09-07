<?php
// Debug admin dashboard
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/Gamecritic/public/admin/dashboard';
$_SERVER['HTTP_HOST'] = 'localhost:881';

// Start session and set admin user
session_start();
$_SESSION['user_id'] = 2;
$_SESSION['user_name'] = 'admin';
$_SESSION['user_email'] = 'admin@gamecritic.com';
$_SESSION['is_admin'] = 1;

echo "<h2>Admin Dashboard Debug</h2>";

try {
    require_once __DIR__ . '/app/config/Router.php';
    
    $router = new Router();
    $router->get('/admin/dashboard', 'Admin', 'dashboard');
    
    $output = $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    
    echo "Output type: " . gettype($output) . "<br>";
    echo "Output length: " . strlen($output) . "<br>";
    echo "<br>First 1000 characters:<br>";
    echo "<pre>" . htmlspecialchars(substr($output, 0, 1000)) . "</pre>";
    
    // Save full output to file
    file_put_contents('admin_dashboard_output.html', $output);
    echo "<br><a href='admin_dashboard_output.html' target='_blank'>View Full Admin Dashboard Output</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
