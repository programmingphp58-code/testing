<?php
class SupabaseClient {
    private $url;
    private $anonKey;
    private $headers;

    public function __construct($url, $anonKey) {
        $this->url = rtrim($url, '/');
        $this->anonKey = $anonKey;
        $this->headers = [
            'apikey: ' . $this->anonKey,
            'Authorization: Bearer ' . $this->anonKey,
            'Content-Type: application/json',
            'Prefer: return=representation'
        ];
    }

    private function request($method, $endpoint, $data = null) {
        $ch = curl_init();
        $url = $this->url . '/rest/v1/' . $endpoint;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        }
        
        return false;
    }

    public function select($table, $columns = '*', $where = null) {
        $endpoint = $table . '?select=' . $columns;
        if ($where) {
            foreach ($where as $key => $value) {
                $endpoint .= '&' . $key . '=eq.' . urlencode($value);
            }
        }
        return $this->request('GET', $endpoint);
    }

    public function insert($table, $data) {
        return $this->request('POST', $table, $data);
    }

    public function update($table, $data, $where) {
        $endpoint = $table . '?';
        foreach ($where as $key => $value) {
            $endpoint .= $key . '=eq.' . urlencode($value) . '&';
        }
        $endpoint = rtrim($endpoint, '&');
        return $this->request('PATCH', $endpoint, $data);
    }

    public function delete($table, $where) {
        $endpoint = $table . '?';
        foreach ($where as $key => $value) {
            $endpoint .= $key . '=eq.' . urlencode($value) . '&';
        }
        $endpoint = rtrim($endpoint, '&');
        return $this->request('DELETE', $endpoint);
    }

    // Method to execute raw SQL-like queries (limited support)
    public function query($sql) {
        // This is a simplified implementation
        // For complex queries, you'll need to adapt them to REST API calls
        return false;
    }
}
