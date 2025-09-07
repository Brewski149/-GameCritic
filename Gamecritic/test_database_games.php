<?php
require_once 'app/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    $result = $conn->query('SELECT COUNT(*) as count FROM games');
    $row = $result->fetch_assoc();
    echo "Games in database: " . $row['count'] . "<br>";
    
    if ($row['count'] > 0) {
        $result = $conn->query('SELECT * FROM games LIMIT 5');
        echo "Sample games:<br>";
        while ($game = $result->fetch_assoc()) {
            echo "- " . $game['title'] . " (" . $game['genre'] . ")<br>";
        }
    } else {
        echo "No games found in database!<br>";
        echo "You may need to run the database setup script.<br>";
    }
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}
?>
