<?php
// Load .env file for local development
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!getenv($name)) {
                putenv("$name=$value");
            }
        }
    }
}

// Include Supabase REST API Client
require_once(__DIR__ . '/SupabaseDB.php');

// Change Bank Name
define("WEB_TITLE","Dogwood State Bank"); 
// Change Web URL https://domain.com or https://sud.domain.com  with No Ending slash "/"
define("WEB_URL",""); 
// Change Your Website Email
define("WEB_EMAIL","support@support.support"); 
// Change Your Website Phone Number
define("WEB_PHONE","000000000"); 

// Do not Edit
$web_url = WEB_URL;
$web_title = WEB_TITLE;
$web_phone = WEB_PHONE;
$web_email = WEB_EMAIL;
// Do not Edit

// Get Supabase DB instance (singleton)
function getDB() {
    return getSupabaseDB();
}

// Legacy dbConnect function - HYBRID approach for performance
function dbConnect(){
    static $conn = null;
    
    if ($conn !== null) {
        return $conn;
    }
    
    // Check if we're on Railway (production) - use direct PostgreSQL for speed
    $isProduction = getenv('RAILWAY_ENVIRONMENT') || getenv('DATABASE_URL');
    
    if ($isProduction && getenv('DATABASE_URL')) {
        // PRODUCTION: Use PostgreSQL connection pooler (FAST!)
        try {
            $db_url = parse_url(getenv('DATABASE_URL'));
            $servername = $db_url['host'];
            $username = $db_url['user'];
            $password = $db_url['pass'];
            $database = ltrim($db_url['path'], '/');
            $port = isset($db_url['port']) ? $db_url['port'] : 5432;
            
            $dsn = "pgsql:host=$servername;port=$port;dbname=$database;sslmode=require";
            $conn = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true // Reuse connections
            ]);
            
            error_log("Using PostgreSQL direct connection (fast mode)");
            return $conn;
        } catch(PDOException $e) {
            error_log("PostgreSQL connection failed, falling back to REST API: " . $e->getMessage());
            // Fall through to REST API
        }
    }
    
    // LOCAL or fallback: Use REST API wrapper
    error_log("Using Supabase REST API wrapper (local mode)");
    $conn = new SupabasePDOWrapper(getSupabaseDB());
    return $conn;
}

/**
 * PDO-like wrapper for SupabaseDB to maintain backward compatibility
 * This allows existing code using $conn->prepare() to work with minimal changes
 */
class SupabasePDOWrapper {
    private $db;
    
    public function __construct(SupabaseDB $db) {
        $this->db = $db;
    }
    
    public function prepare($sql) {
        return new SupabaseStatement($this->db, $sql);
    }
    
    public function query($sql) {
        $stmt = new SupabaseStatement($this->db, $sql);
        $stmt->execute();
        return $stmt;
    }
    
    public function lastInsertId() {
        // Supabase returns the inserted row, so this is handled in statement
        return SupabaseStatement::$lastInsertId;
    }
}

/**
 * PDO Statement-like wrapper for Supabase queries
 */
class SupabaseStatement {
    private $db;
    private $sql;
    private $params = [];
    private $results = [];
    private $rowCount = 0;
    private $currentIndex = 0;
    public static $lastInsertId = null;
    private static $parseCache = []; // Cache parsed SQL
    
    public function __construct(SupabaseDB $db, $sql) {
        $this->db = $db;
        $this->sql = $sql;
    }
    
    public function execute($params = []) {
        $this->params = $params;
        $this->results = [];
        $this->rowCount = 0;
        $this->currentIndex = 0;
        
        // Parse SQL and convert to Supabase REST API calls
        $sql = $this->sql;
        
        // Replace named parameters with values (optimized)
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $placeholder = ':' . ltrim($key, ':');
                $sql = str_replace($placeholder, $this->quote($value), $sql);
            }
        }
        
        // Determine query type (fast check)
        $firstWord = strtolower(substr(ltrim($sql), 0, 6));
        
        if ($firstWord === 'select') {
            $this->handleSelect($sql);
        } elseif ($firstWord === 'insert') {
            $this->handleInsert($sql);
        } elseif ($firstWord === 'update') {
            $this->handleUpdate($sql);
        } elseif ($firstWord === 'delete') {
            $this->handleDelete($sql);
        }
        
        return true;
    }
    
    private function quote($value) {
        if ($value === null) {
            return 'NULL';
        }
        if (is_numeric($value)) {
            return $value;
        }
        return "'" . addslashes($value) . "'";
    }
    
    private function handleSelect($sql) {
        // Parse SELECT query
        // Example: SELECT * FROM accounts WHERE internetid='123'
        
        preg_match('/from\s+(\w+)/i', $sql, $tableMatch);
        $table = $tableMatch[1] ?? null;
        
        if (!$table) {
            throw new Exception("Could not parse table from SELECT: $sql");
        }
        
        // Parse columns
        preg_match('/select\s+(.+?)\s+from/i', $sql, $colMatch);
        $columns = trim($colMatch[1] ?? '*');
        
        // Parse WHERE conditions (returns ['filters' => [...], 'or' => [...]])
        $whereResult = $this->parseWhere($sql);
        $filters = $whereResult['filters'] ?? [];
        
        // Parse ORDER BY
        $options = [];
        
        // Add OR conditions if present
        if (!empty($whereResult['or'])) {
            $options['or'] = $whereResult['or'];
        }
        
        if (preg_match('/order\s+by\s+(\w+)\s*(asc|desc)?/i', $sql, $orderMatch)) {
            $direction = strtolower($orderMatch[2] ?? 'asc') === 'desc' ? '.desc' : '.asc';
            $options['order'] = $orderMatch[1] . $direction;
        }
        
        // Parse LIMIT
        if (preg_match('/limit\s+(\d+)/i', $sql, $limitMatch)) {
            $options['limit'] = intval($limitMatch[1]);
        }
        
        try {
            $this->results = $this->db->select($table, $columns, $filters, $options);
            $this->rowCount = count($this->results);
        } catch (Exception $e) {
            error_log("Supabase SELECT Error: " . $e->getMessage() . " | SQL: $sql");
            $this->results = [];
            $this->rowCount = 0;
        }
    }
    
    private function handleInsert($sql) {
        // Parse INSERT query - optimized
        // Example: INSERT INTO accounts (col1, col2) VALUES ('val1', 'val2')
        
        // Fast extraction
        $intoPos = stripos($sql, 'into');
        $valuesPos = stripos($sql, 'values');
        
        if ($intoPos === false || $valuesPos === false) {
            throw new Exception("Could not parse INSERT: $sql");
        }
        
        // Extract table name and columns
        $tablePart = trim(substr($sql, $intoPos + 4, $valuesPos - $intoPos - 4));
        
        // Get table name
        preg_match('/^(\w+)/', $tablePart, $tableMatch);
        $table = $tableMatch[1] ?? null;
        
        // Get columns from parentheses
        preg_match('/\(([^)]+)\)/', $tablePart, $colMatch);
        $columnsStr = $colMatch[1] ?? '';
        $columns = array_map('trim', explode(',', $columnsStr));
        
        // Get values from after VALUES
        $afterValues = trim(substr($sql, $valuesPos + 6));
        preg_match('/\((.+)\)/', $afterValues, $valMatch);
        $valuesStr = $valMatch[1] ?? '';
        
        // Parse values (faster method)
        $values = $this->parseValues($valuesStr);
        
        $data = [];
        foreach ($columns as $i => $col) {
            $data[trim($col)] = $values[$i] ?? null;
        }
        
        try {
            $result = $this->db->insert($table, $data);
            $this->results = is_array($result) ? $result : [$result];
            $this->rowCount = count($this->results);
            
            // Store last insert ID
            if (!empty($this->results[0]['id'])) {
                self::$lastInsertId = $this->results[0]['id'];
            }
        } catch (Exception $e) {
            error_log("Supabase INSERT Error: " . $e->getMessage());
            $this->results = [];
            $this->rowCount = 0;
        }
    }
    
    private function handleUpdate($sql) {
        // Parse UPDATE query
        // Example: UPDATE accounts SET col1='val1' WHERE id=1
        
        preg_match('/update\s+(\w+)\s+set\s+(.+?)\s+where\s+(.+)/i', $sql, $matches);
        
        if (count($matches) < 4) {
            throw new Exception("Could not parse UPDATE: $sql");
        }
        
        $table = $matches[1];
        $setClause = $matches[2];
        $whereClause = $matches[3];
        
        // Parse SET clause
        $data = $this->parseSetClause($setClause);
        
        // Parse WHERE (use filters, OR conditions not typically used in UPDATE)
        $whereResult = $this->parseWhere("WHERE $whereClause");
        $filters = $whereResult['filters'] ?? [];
        
        try {
            $result = $this->db->update($table, $data, $filters);
            $this->results = is_array($result) ? $result : [];
            $this->rowCount = count($this->results);
        } catch (Exception $e) {
            error_log("Supabase UPDATE Error: " . $e->getMessage() . " | SQL: $sql");
            $this->rowCount = 0;
        }
    }
    
    private function handleDelete($sql) {
        // Parse DELETE query
        preg_match('/delete\s+from\s+(\w+)\s+where\s+(.+)/i', $sql, $matches);
        
        if (count($matches) < 3) {
            throw new Exception("Could not parse DELETE: $sql");
        }
        
        $table = $matches[1];
        $whereClause = $matches[2];
        
        $whereResult = $this->parseWhere("WHERE $whereClause");
        $filters = $whereResult['filters'] ?? [];
        
        try {
            $result = $this->db->delete($table, $filters);
            $this->results = is_array($result) ? $result : [];
            $this->rowCount = count($this->results);
        } catch (Exception $e) {
            error_log("Supabase DELETE Error: " . $e->getMessage() . " | SQL: $sql");
            $this->rowCount = 0;
        }
    }
    
    private function parseWhere($sql) {
        $result = ['filters' => [], 'or' => []];
        
        // Fast check - no WHERE clause
        if (stripos($sql, 'where') === false) {
            return $result;
        }
        
        // Extract WHERE clause (optimized)
        $wherePos = stripos($sql, 'where');
        $afterWhere = substr($sql, $wherePos + 5);
        
        // Find end of WHERE clause
        $endKeywords = ['order by', 'limit', 'group by'];
        $endPos = strlen($afterWhere);
        foreach ($endKeywords as $keyword) {
            $pos = stripos($afterWhere, $keyword);
            if ($pos !== false && $pos < $endPos) {
                $endPos = $pos;
            }
        }
        
        $whereClause = trim(substr($afterWhere, 0, $endPos));
        
        // Check for OR (case-insensitive, word boundary)
        $hasOr = preg_match('/\s+or\s+/i', $whereClause);
        
        if ($hasOr) {
            // Handle OR conditions
            $conditions = preg_split('/\s+or\s+/i', $whereClause, -1, PREG_SPLIT_NO_EMPTY);
            
            foreach ($conditions as $condition) {
                if (preg_match("/(\w+)\s*=\s*'([^']*)'/", $condition, $match)) {
                    $result['or'][$match[1]] = $match[2];
                } elseif (preg_match("/(\w+)\s*=\s*(\d+)/", $condition, $match)) {
                    $result['or'][$match[1]] = $match[2];
                }
            }
        } else {
            // No OR - handle AND conditions
            $andParts = preg_split('/\s+and\s+/i', $whereClause, -1, PREG_SPLIT_NO_EMPTY);
            
            foreach ($andParts as $part) {
                if (preg_match("/(\w+)\s*=\s*'([^']*)'/", $part, $match)) {
                    $result['filters'][$match[1]] = $match[2];
                } elseif (preg_match("/(\w+)\s*=\s*(\d+)/", $part, $match)) {
                    $result['filters'][$match[1]] = $match[2];
                }
            }
        }
        
        return $result;
    }
    
    private function parseSetClause($setClause) {
        $data = [];
        
        // Split by comma but not inside quotes
        $parts = preg_split("/,(?=(?:[^']*'[^']*')*[^']*$)/", $setClause);
        
        foreach ($parts as $part) {
            if (preg_match("/(\w+)\s*=\s*'([^']*)'/", $part, $match)) {
                $data[$match[1]] = $match[2];
            } elseif (preg_match("/(\w+)\s*=\s*(\d+)/", $part, $match)) {
                $data[$match[1]] = $match[2];
            } elseif (preg_match("/(\w+)\s*=\s*NULL/i", $part, $match)) {
                $data[$match[1]] = null;
            }
        }
        
        return $data;
    }
    
    private function parseValues($valuesStr) {
        $values = [];
        $current = '';
        $inQuote = false;
        $quoteChar = '';
        
        for ($i = 0; $i < strlen($valuesStr); $i++) {
            $char = $valuesStr[$i];
            
            if (($char === "'" || $char === '"') && ($i === 0 || $valuesStr[$i-1] !== '\\')) {
                if (!$inQuote) {
                    $inQuote = true;
                    $quoteChar = $char;
                } elseif ($char === $quoteChar) {
                    $inQuote = false;
                    $quoteChar = '';
                } else {
                    $current .= $char;
                }
            } elseif ($char === ',' && !$inQuote) {
                $values[] = $this->cleanValue(trim($current));
                $current = '';
            } else {
                $current .= $char;
            }
        }
        
        if ($current !== '') {
            $values[] = $this->cleanValue(trim($current));
        }
        
        return $values;
    }
    
    private function cleanValue($value) {
        // Remove surrounding quotes
        if ((substr($value, 0, 1) === "'" && substr($value, -1) === "'") ||
            (substr($value, 0, 1) === '"' && substr($value, -1) === '"')) {
            $value = substr($value, 1, -1);
        }
        
        // Handle NULL
        if (strtoupper($value) === 'NULL') {
            return null;
        }
        
        // Unescape
        return stripslashes($value);
    }
    
    public function fetch($mode = null) {
        if ($this->currentIndex >= count($this->results)) {
            return false;
        }
        return $this->results[$this->currentIndex++];
    }
    
    public function fetchAll($mode = null) {
        return $this->results;
    }
    
    public function rowCount() {
        return $this->rowCount;
    }
    
    public function bindParam($param, &$value, $type = null) {
        $this->params[$param] = &$value;
    }
    
    public function bindValue($param, $value, $type = null) {
        $this->params[$param] = $value;
    }
}

function inputValidation($value): string
{
    return trim(htmlspecialchars(htmlentities($value)));
}