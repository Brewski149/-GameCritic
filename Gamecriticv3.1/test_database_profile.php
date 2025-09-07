<?php
// Test script to check database and add profile_picture column
require_once __DIR__ . '/app/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    echo "✅ Database connection successful!\n\n";
    
    // Check if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "✅ Users table exists\n";
        
        // Show current table structure
        echo "\n📋 Current users table structure:\n";
        $result = $conn->query("DESCRIBE users");
        while ($row = $result->fetch_assoc()) {
            echo "- {$row['Field']}: {$row['Type']} {$row['Null']} {$row['Key']} {$row['Default']}\n";
        }
        
        // Check if profile_picture column exists
        $result = $conn->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
        if ($result->num_rows > 0) {
            echo "\n✅ profile_picture column already exists\n";
        } else {
            echo "\n❌ profile_picture column does NOT exist\n";
            
            // Add the column
            echo "\n🔧 Adding profile_picture column...\n";
            $sql = "ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL AFTER password";
            if ($conn->query($sql)) {
                echo "✅ profile_picture column added successfully!\n";
                
                // Show updated table structure
                echo "\n📋 Updated users table structure:\n";
                $result = $conn->query("DESCRIBE users");
                while ($row = $result->fetch_assoc()) {
                    echo "- {$row['Field']}: {$row['Type']} {$row['Null']} {$row['Key']} {$row['Default']}\n";
                }
            } else {
                echo "❌ Failed to add profile_picture column: " . $conn->error . "\n";
            }
        }
        
    } else {
        echo "❌ Users table does not exist!\n";
        echo "You need to create the users table first.\n";
    }
    
    // Test file upload directory
    $uploadDir = __DIR__ . '/public/uploads/profiles/';
    if (is_dir($uploadDir)) {
        echo "\n✅ Upload directory exists: {$uploadDir}\n";
        if (is_writable($uploadDir)) {
            echo "✅ Upload directory is writable\n";
        } else {
            echo "❌ Upload directory is NOT writable\n";
        }
    } else {
        echo "\n❌ Upload directory does not exist: {$uploadDir}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
