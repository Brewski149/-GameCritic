<?php
require_once __DIR__ . '/app/controllers/BaseController.php';

class DebugController extends BaseController {
    public function debug() {
        echo "<h1>Debug Base URL</h1>";
        echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "</p>";
        echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "</p>";
        echo "<p><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "</p>";
        echo "<p><strong>Calculated Base URL:</strong> " . $this->baseUrl() . "</p>";
        echo "<p><strong>CSS URL would be:</strong> " . $this->baseUrl() . "/css/style.css</p>";
    }
}

$debug = new DebugController();
$debug->debug();
?>

