<?php
echo "<h1>Simple Test</h1>";
echo "<p>PHP is working!</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "</p>";
echo "<p>SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "</p>";
?>
