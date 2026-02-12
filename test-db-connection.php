<?php
/**
 * Database Connection Test
 * Access this file to verify your database connection works
 * Delete this file after testing for security
 */

require_once 'configuration/config.php';

echo "<h2>Database Connection Test</h2>";
echo "<p><strong>Environment:</strong> " . (getenv('DATABASE_URL') ? 'Production (Railway)' : 'Local (XAMPP)') . "</p>";

try {
    $conn = dbConnect();
    if ($conn) {
        echo "<p style='color: green;'>✅ <strong>SUCCESS!</strong> Connected to database successfully.</p>";
        
        // Test a simple query
        $stmt = $conn->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<p><strong>Tables found:</strong> " . count($tables) . "</p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // Check accounts table
        $stmt = $conn->query("SELECT COUNT(*) as count FROM accounts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p><strong>Accounts in database:</strong> " . $result['count'] . "</p>";
        
    } else {
        echo "<p style='color: red;'>❌ <strong>FAILED!</strong> Could not connect to database.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ <strong>ERROR:</strong> " . $e->getMessage() . "</p>";
}
?>
