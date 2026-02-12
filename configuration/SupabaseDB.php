<?php
/**
 * Supabase REST API Client for PHP
 * Replaces PDO connections with REST API calls
 */

class SupabaseDB {
    private $url;
    private $key;
    private $headers;
    private static $cache = []; // Simple in-memory cache
    private static $curlHandle = null; // Reusable cURL handle
    
    public function __construct($url, $key) {
        $this->url = rtrim($url, '/');
        $this->key = $key;
        $this->headers = [
            'apikey: ' . $key,
            'Authorization: Bearer ' . $key,
            'Content-Type: application/json',
            'Prefer: return=representation'
        ];
    }
    
    /**
     * Make HTTP request to Supabase REST API (optimized)
     */
    private function request($method, $endpoint, $data = null, $extraHeaders = []) {
        $url = $this->url . '/rest/v1/' . $endpoint;
        
        // Check cache for GET requests
        if ($method === 'GET') {
            $cacheKey = md5($url);
            if (isset(self::$cache[$cacheKey])) {
                $cached = self::$cache[$cacheKey];
                // Cache for 30 seconds
                if (time() - $cached['time'] < 30) {
                    return $cached['data'];
                }
            }
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->headers, $extraHeaders));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Reduced from 30
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // Fast connection timeout
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0); // HTTP/2 for multiplexing
        curl_setopt($ch, CURLOPT_TCP_KEEPALIVE, 1); // Keep connection alive
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 300); // Cache DNS lookups
        
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if ($data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }
        
        $decoded = json_decode($response, true);
        
        if ($httpCode >= 400) {
            $errorMsg = isset($decoded['message']) ? $decoded['message'] : $response;
            throw new Exception("Supabase API Error ($httpCode): " . $errorMsg);
        }
        
        // Cache GET requests
        if ($method === 'GET' && $decoded) {
            $cacheKey = md5($url);
            self::$cache[$cacheKey] = [
                'data' => $decoded,
                'time' => time()
            ];
        }
        
        return $decoded;
    }
    
    /**
     * SELECT query
     * @param string $table Table name
     * @param string $columns Columns to select (default: *)
     * @param array $filters Associative array of column => value for WHERE conditions
     * @param array $options Additional options: order, limit, offset, or (for OR conditions)
     * @return array
     */
    public function select($table, $columns = '*', $filters = [], $options = []) {
        $endpoint = $table . '?select=' . urlencode($columns);
        
        // Handle OR conditions
        if (!empty($options['or'])) {
            // Format: or=(col1.eq.val1,col2.eq.val2)
            $orParts = [];
            foreach ($options['or'] as $col => $val) {
                $orParts[] = $col . '.eq.' . $val;
            }
            $endpoint .= '&or=(' . implode(',', $orParts) . ')';
        }
        
        // Add filters (AND conditions)
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                // Handle operators: ['gt' => 5] becomes column=gt.5
                foreach ($value as $operator => $val) {
                    $endpoint .= '&' . urlencode($column) . '=' . $operator . '.' . urlencode($val);
                }
            } else {
                // Simple equality
                $endpoint .= '&' . urlencode($column) . '=eq.' . urlencode($value);
            }
        }
        
        // Add ordering
        if (!empty($options['order'])) {
            $endpoint .= '&order=' . urlencode($options['order']);
        }
        
        // Add limit
        if (!empty($options['limit'])) {
            $endpoint .= '&limit=' . intval($options['limit']);
        }
        
        // Add offset
        if (!empty($options['offset'])) {
            $endpoint .= '&offset=' . intval($options['offset']);
        }
        
        return $this->request('GET', $endpoint);
    }
    
    /**
     * Get a single row
     */
    public function selectOne($table, $columns = '*', $filters = []) {
        $results = $this->select($table, $columns, $filters, ['limit' => 1]);
        return !empty($results) ? $results[0] : null;
    }
    
    /**
     * INSERT query
     * @param string $table Table name
     * @param array $data Associative array of column => value
     * @return array Inserted row(s)
     */
    public function insert($table, $data) {
        return $this->request('POST', $table, $data);
    }
    
    /**
     * UPDATE query
     * @param string $table Table name
     * @param array $data Associative array of column => value to update
     * @param array $filters WHERE conditions
     * @return array Updated row(s)
     */
    public function update($table, $data, $filters = []) {
        $endpoint = $table;
        
        // Add filters for WHERE clause
        $filterParts = [];
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $operator => $val) {
                    $filterParts[] = urlencode($column) . '=' . $operator . '.' . urlencode($val);
                }
            } else {
                $filterParts[] = urlencode($column) . '=eq.' . urlencode($value);
            }
        }
        
        if (!empty($filterParts)) {
            $endpoint .= '?' . implode('&', $filterParts);
        }
        
        return $this->request('PATCH', $endpoint, $data);
    }
    
    /**
     * DELETE query
     * @param string $table Table name
     * @param array $filters WHERE conditions
     * @return array Deleted row(s)
     */
    public function delete($table, $filters = []) {
        $endpoint = $table;
        
        // Add filters for WHERE clause
        $filterParts = [];
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $operator => $val) {
                    $filterParts[] = urlencode($column) . '=' . $operator . '.' . urlencode($val);
                }
            } else {
                $filterParts[] = urlencode($column) . '=eq.' . urlencode($value);
            }
        }
        
        if (!empty($filterParts)) {
            $endpoint .= '?' . implode('&', $filterParts);
        }
        
        return $this->request('DELETE', $endpoint);
    }
    
    /**
     * Count rows in a table
     */
    public function count($table, $filters = []) {
        $endpoint = $table . '?select=count';
        
        foreach ($filters as $column => $value) {
            $endpoint .= '&' . urlencode($column) . '=eq.' . urlencode($value);
        }
        
        $extraHeaders = ['Prefer: count=exact'];
        $result = $this->request('GET', $endpoint, null, $extraHeaders);
        
        return isset($result[0]['count']) ? intval($result[0]['count']) : 0;
    }
    
    /**
     * Execute raw SQL via Supabase RPC (requires function to be defined in Supabase)
     */
    public function rpc($functionName, $params = []) {
        return $this->request('POST', 'rpc/' . $functionName, $params);
    }
    
    /**
     * Test connection
     */
    public function testConnection() {
        try {
            // Try to query a table to verify connection
            $url = $this->url . '/rest/v1/';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            
            if ($error) {
                return ['success' => false, 'message' => 'cURL Error: ' . $error];
            }
            
            if ($httpCode >= 400) {
                return ['success' => false, 'message' => 'HTTP Error: ' . $httpCode . ' - ' . $response];
            }
            
            return ['success' => true, 'message' => 'Connected to Supabase successfully'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

/**
 * Global function to get SupabaseDB instance (singleton pattern)
 */
function getSupabaseDB() {
    static $instance = null;
    
    if ($instance === null) {
        // Load .env if not already loaded
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    if (!isset($_ENV[$key])) {
                        $_ENV[$key] = $value;
                        putenv("$key=$value");
                    }
                }
            }
        }
        
        $url = getenv('SUPABASE_URL') ?: $_ENV['SUPABASE_URL'] ?? null;
        $key = getenv('SUPABASE_KEY') ?: $_ENV['SUPABASE_KEY'] ?? null;
        
        if (!$url || !$key) {
            throw new Exception('SUPABASE_URL and SUPABASE_KEY must be set in environment');
        }
        
        $instance = new SupabaseDB($url, $key);
    }
    
    return $instance;
}
