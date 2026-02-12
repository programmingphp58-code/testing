<?php
require_once __DIR__ . '/configuration/config.php';

echo "<h2>Testing Supabase Connection</h2>";

echo "<p><strong>DATABASE_URL from .env:</strong> " . (getenv('DATABASE_URL') ? 'Found' : 'Not found') . "</p>";

if (getenv('DATABASE_URL')) {
    $db_url = parse_url(getenv('DATABASE_URL'));
    echo "<p><strong>Host:</strong> " . $db_url['host'] . "</p>";
    echo "<p><strong>Database:</strong> " . ltrim($db_url['path'], '/') . "</p>";
    echo "<p><strong>Port:</strong> " . ($db_url['port'] ?? 5432) . "</p>";
}

echo "<hr>";
echo "<p>Attempting database connection...</p>";

$conn = dbConnect();

if ($conn) {
    echo "<p style='color: green;'><strong>✓ Connection successful!</strong></p>";
    
    // Test query to list all tables
    try {
        $stmt = $conn->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' ORDER BY table_name");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<p><strong>Tables found:</strong></p>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // Test count from accounts table
        $stmt = $conn->query("SELECT COUNT(*) as count FROM accounts");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p><strong>Total accounts:</strong> " . $count['count'] . "</p>";
        
    } catch (PDOException $e) {
        echo "<p style='color: orange;'>Connected, but query error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'><strong>✗ Connection failed!</strong></p>";
}
?>
