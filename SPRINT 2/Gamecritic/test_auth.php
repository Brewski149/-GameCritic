<?php
echo "<h1>Auth Controller Test</h1>";

try {
    require_once __DIR__ . '/app/controllers/BaseController.php';
    echo "<p>✅ BaseController loaded successfully</p>";
    
    require_once __DIR__ . '/app/controllers/AuthController.php';
    echo "<p>✅ AuthController loaded successfully</p>";
    
    $auth = new AuthController();
    echo "<p>✅ AuthController instance created successfully</p>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . "</p>";
    echo "<p>Line: " . $e->getLine() . "</p>";
}
?>
