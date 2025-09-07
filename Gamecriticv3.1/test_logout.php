<?php
// Test logout functionality
session_start();

echo "Before logout:<br>";
echo "Session ID: " . session_id() . "<br>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Is Admin: " . ($_SESSION['is_admin'] ?? 'Not set') . "<br>";

echo "<br>Testing logout...<br>";

// Simulate logout
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

echo "After logout:<br>";
echo "Session ID: " . session_id() . "<br>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Is Admin: " . ($_SESSION['is_admin'] ?? 'Not set') . "<br>";

echo "<br><a href='public/'>Go to Home Page</a>";
?>


