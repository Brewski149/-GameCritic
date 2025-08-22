<?php
echo "<h1>Database Connection Test</h1>";

try {
    // Test basic MySQLi connection
    echo "<h2>Testing MySQLi Connection...</h2>";
    $mysqli = new mysqli("127.0.0.1", "root", "", "gamecritic");
    
    if ($mysqli->connect_error) {
        echo "<p>❌ Connection failed: " . $mysqli->connect_error . "</p>";
        exit;
    } else {
        echo "<p>✅ MySQLi connection successful!</p>";
    }
    
    // Test if the users table exists
    echo "<h2>Testing Table Structure...</h2>";
    $result = $mysqli->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "<p>✅ Users table exists</p>";
        
        // Show table structure
        $result = $mysqli->query("DESCRIBE users");
        echo "<h3>Users Table Structure:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Show sample data (without passwords)
        $result = $mysqli->query("SELECT id, name, email, is_admin FROM users LIMIT 5");
        echo "<h3>Sample Users (first 5):</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Is Admin</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['is_admin'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p>❌ Users table does not exist!</p>";
    }
    
    // Test our Database class
    echo "<h2>Testing Our Database Class...</h2>";
    require_once __DIR__ . '/app/config/database.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "<p>✅ Our Database class connection successful!</p>";
        
        // Test a simple query
        $result = $conn->query("SELECT COUNT(*) as count FROM users");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>✅ Query successful: " . $row['count'] . " users found</p>";
        } else {
            echo "<p>❌ Query failed: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>❌ Our Database class connection failed!</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>
