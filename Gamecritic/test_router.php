<?php
echo "<h1>Router Test</h1>";

try {
    require_once __DIR__ . '/app/config/Router.php';
    echo "<p>✅ Router class loaded successfully</p>";
    
    $router = new Router();
    echo "<p>✅ Router instance created successfully</p>";
    
    echo "<p>Available routes:</p>";
    echo "<ul>";
    echo "<li>GET /</li>";
    echo "<li>GET /login</li>";
    echo "<li>GET /admin/dashboard</li>";
    echo "<li>GET /dashboard</li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . "</p>";
    echo "<p>Line: " . $e->getLine() . "</p>";
}
?>
