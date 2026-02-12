<?php
/**
 * Test the PDO-compatible wrapper for Supabase
 * This tests that existing code using $conn->prepare() will work
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/configuration/config.php';

echo "<h2>Supabase PDO Wrapper Test</h2>\n";

// Test 1: Basic connection
echo "<h3>1. Get Connection:</h3>\n";
try {
    $conn = dbConnect();
    echo "<span style='color: green;'>✓ Got connection wrapper</span><br>\n";
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
    exit;
}

// Test 2: SELECT query (like in login.php)
echo "<h3>2. SELECT Query (accounts table):</h3>\n";
try {
    $internetid = '3000615625';
    $log = "SELECT * FROM accounts WHERE internetid='$internetid' OR acct_email = '$internetid'";
    $stmt = $conn->prepare($log);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<span style='color: green;'>✓ Found user!</span><br>\n";
        echo "- Internet ID: " . ($user['internetid'] ?? 'N/A') . "<br>\n";
        echo "- Email: " . ($user['acct_email'] ?? 'N/A') . "<br>\n";
        echo "- Name: " . ($user['firstname'] ?? '') . " " . ($user['lastname'] ?? '') . "<br>\n";
        echo "- Status: " . ($user['acct_status'] ?? 'N/A') . "<br>\n";
    } else {
        echo "<span style='color: orange;'>⚠ No user found with that ID</span><br>\n";
    }
    
    echo "Row count: " . $stmt->rowCount() . "<br>\n";
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
}

// Test 3: SELECT with named parameters
echo "<h3>3. SELECT with Named Parameters:</h3>\n";
try {
    $sql = "SELECT * FROM settings WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => 1]);
    
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($settings) {
        echo "<span style='color: green;'>✓ Found settings!</span><br>\n";
        echo "- Website Name: " . ($settings['website_name'] ?? 'N/A') . "<br>\n";
    } else {
        echo "<span style='color: orange;'>⚠ No settings found</span><br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
}

// Test 4: SELECT all from accounts
echo "<h3>4. SELECT All Accounts:</h3>\n";
try {
    $sql = "SELECT * FROM accounts";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<span style='color: green;'>✓ Found " . count($accounts) . " account(s)</span><br>\n";
    foreach ($accounts as $acct) {
        echo "- " . ($acct['firstname'] ?? '') . " " . ($acct['lastname'] ?? '') . " (" . ($acct['acct_email'] ?? 'N/A') . ")<br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
}

// Test 5: Admin table
echo "<h3>5. SELECT Admin:</h3>\n";
try {
    $sql = "SELECT * FROM admin WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => 1]);
    
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "<span style='color: green;'>✓ Found admin!</span><br>\n";
        echo "- Username: " . ($admin['admin_name'] ?? $admin['username'] ?? 'N/A') . "<br>\n";
    } else {
        echo "<span style='color: orange;'>⚠ No admin found</span><br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
}

echo "<hr>\n";
echo "<p><strong>If all tests pass, the login system should work!</strong></p>\n";
