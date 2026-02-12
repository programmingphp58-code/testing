<?php
/**
 * Test Supabase REST API Connection
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/configuration/SupabaseDB.php';

echo "<h2>Supabase REST API Connection Test</h2>\n";

// Check environment variables
echo "<h3>1. Environment Variables:</h3>\n";
$url = getenv('SUPABASE_URL') ?: $_ENV['SUPABASE_URL'] ?? 'NOT SET';
$key = getenv('SUPABASE_KEY') ?: $_ENV['SUPABASE_KEY'] ?? 'NOT SET';

echo "SUPABASE_URL: " . ($url !== 'NOT SET' ? substr($url, 0, 50) . '...' : 'NOT SET') . "<br>\n";
echo "SUPABASE_KEY: " . ($key !== 'NOT SET' ? substr($key, 0, 30) . '...' : 'NOT SET') . "<br>\n";

// Test connection
echo "<h3>2. Connection Test:</h3>\n";
try {
    $db = getSupabaseDB();
    $result = $db->testConnection();
    
    if ($result['success']) {
        echo "<span style='color: green; font-weight: bold;'>✓ " . $result['message'] . "</span><br>\n";
    } else {
        echo "<span style='color: red;'>✗ " . $result['message'] . "</span><br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Error: " . $e->getMessage() . "</span><br>\n";
}

// Test actual query
echo "<h3>3. Query Test (accounts table):</h3>\n";
try {
    $db = getSupabaseDB();
    
    // Try to fetch accounts (limit 1)
    $accounts = $db->select('accounts', '*', [], ['limit' => 1]);
    
    if (is_array($accounts)) {
        echo "<span style='color: green; font-weight: bold;'>✓ Successfully queried accounts table</span><br>\n";
        echo "Found " . count($accounts) . " account(s)<br>\n";
        
        if (!empty($accounts)) {
            echo "<pre>";
            // Show limited info for security
            foreach ($accounts as $acct) {
                echo "- ID: " . ($acct['id'] ?? 'N/A') . "\n";
                echo "  Email: " . ($acct['acct_email'] ?? 'N/A') . "\n";
                echo "  Name: " . ($acct['firstname'] ?? 'N/A') . " " . ($acct['lastname'] ?? '') . "\n";
            }
            echo "</pre>";
        }
    } else {
        echo "<span style='color: orange;'>⚠ No data returned</span><br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Query Error: " . $e->getMessage() . "</span><br>\n";
    echo "<small>Note: Make sure RLS policies allow read access. You may need to disable RLS for testing.</small><br>\n";
}

// Test admin table
echo "<h3>4. Query Test (admin table):</h3>\n";
try {
    $db = getSupabaseDB();
    
    // Try to fetch admin
    $admins = $db->select('admin', '*', [], ['limit' => 1]);
    
    if (is_array($admins)) {
        echo "<span style='color: green; font-weight: bold;'>✓ Successfully queried admin table</span><br>\n";
        echo "Found " . count($admins) . " admin(s)<br>\n";
    }
} catch (Exception $e) {
    echo "<span style='color: red;'>✗ Query Error: " . $e->getMessage() . "</span><br>\n";
}

echo "<hr>\n";
echo "<h3>cURL Info:</h3>\n";
echo "cURL enabled: " . (function_exists('curl_version') ? '<span style="color:green">Yes</span>' : '<span style="color:red">No</span>') . "<br>\n";
if (function_exists('curl_version')) {
    $curl_info = curl_version();
    echo "cURL version: " . $curl_info['version'] . "<br>\n";
    echo "SSL version: " . $curl_info['ssl_version'] . "<br>\n";
}
