<?php

class ApiClient
{
    private $appId;
    private $appKey;
    private $cacheDir;
    private $ttl; // Time To Live in seconds

    public function __construct()
    {
        $this->appId = $_ENV['EDAMAM_APP_ID'] ?? null;
        $this->appKey = $_ENV['EDAMAM_APP_KEY'] ?? null;
        $this->cacheDir = __DIR__ . '/../cache/';
        $this->ttl = 3600 * 24; // Default cache 24 hours

        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }

        if (!$this->appId || !$this->appKey) {
            throw new Exception("API Credentials not found in environment variables.");
        }
    }

    /**
     * Fetch nutrition data for a given query
     * @param string $query Food query (e.g., "1 apple")
     * @return string JSON response
     */
    public function get($query)
    {
        $hash = md5($query);
        $cacheFile = $this->cacheDir . $hash . '.json';

        // Check Cache
        if (file_exists($cacheFile)) {
            $fileTime = filemtime($cacheFile);
            $currentTime = time();
            
            if (($currentTime - $fileTime) < $this->ttl) {
                // Return cached data
                return file_get_contents($cacheFile);
            }
        }

        // Cache Miss or Expired: Fetch from API
        return $this->fetchFromApi($query, $cacheFile);
    }

    private function fetchFromApi($query, $cacheFile)
    {
        $encodedQuery = urlencode($query);
        $url = "https://api.edamam.com/api/food-database/v2/parser?app_id={$this->appId}&app_key={$this->appKey}&ingr={$encodedQuery}&nutrition-type=cooking";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            return json_encode(['error' => 'Curl error: ' . $error]);
        }

        if ($httpCode !== 200) {
            return json_encode(['error' => 'API request failed with status ' . $httpCode, 'details' => json_decode($response)]);
        }

        // Save to cache
        file_put_contents($cacheFile, $response);

        return $response;
    }
}
