<?php
require_once 'app/config/database.php';

echo "<h2>Admin Login Debug</h2>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "<h3>1. Checking Users Table Structure:</h3>";
    $result = $conn->query("DESCRIBE users");
    if ($result) {
        echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($col = $result->fetch_assoc()) {
            echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td><td>{$col['Null']}</td><td>{$col['Key']}</td><td>{$col['Default']}</td></tr>";
        }
        echo "</table>";
    }
    
    echo "<h3>2. All Users in Database:</h3>";
    $result = $conn->query("SELECT * FROM users");
    if ($result) {
        echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Email</th><th>is_admin</th><th>Password</th></tr>";
        while ($user = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>" . ($user['is_admin'] ?? 'NULL') . "</td>";
            echo "<td>" . substr($user['password'], 0, 20) . "...</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<h3>3. Testing Admin Authentication:</h3>";
    
    // Test with admin@gamecritic.com
    $email = 'admin@gamecritic.com';
    $password = 'admin123';
    
    echo "Testing login with: {$email}<br>";
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        echo "User found: " . json_encode($user) . "<br>";
        echo "is_admin value: " . ($user['is_admin'] ?? 'NULL') . "<br>";
        echo "is_admin type: " . gettype($user['is_admin']) . "<br>";
        echo "is_admin == 1: " . ($user['is_admin'] == 1 ? 'TRUE' : 'FALSE') . "<br>";
        echo "is_admin === 1: " . ($user['is_admin'] === 1 ? 'TRUE' : 'FALSE') . "<br>";
        
        // Test password
        $storedPassword = $user['password'] ?? '';
        $info = is_string($storedPassword) ? password_get_info($storedPassword) : ['algo' => 0];
        $isHashed = isset($info['algo']) && $info['algo'] !== 0;
        
        if ($isHashed) {
            $passwordMatch = password_verify($password, $storedPassword);
        } else {
            $passwordMatch = ($password === $storedPassword);
        }
        
        echo "Password match: " . ($passwordMatch ? 'TRUE' : 'FALSE') . "<br>";
        
        if ($passwordMatch) {
            echo "Would redirect to: " . ($user['is_admin'] == 1 ? '/admin/dashboard' : '/dashboard') . "<br>";
        }
    } else {
        echo "User not found!<br>";
    }
    
    echo "<h3>4. Fix Admin User:</h3>";
    
    // Add is_admin column if it doesn't exist
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0");
        echo "Added is_admin column<br>";
    } else {
        echo "is_admin column already exists<br>";
    }
    
    // Update admin user
    $conn->query("UPDATE users SET is_admin = 1 WHERE email = 'admin@gamecritic.com'");
    echo "Updated admin user to is_admin = 1<br>";
    
    // Verify the update
    $result = $conn->query("SELECT id, username, email, is_admin FROM users WHERE email = 'admin@gamecritic.com'");
    if ($user = $result->fetch_assoc()) {
        echo "Updated admin user: " . json_encode($user) . "<br>";
    }
    
    echo "<br><a href='public/login'>Try Login Now</a>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
