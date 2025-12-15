<?php
header('Content-Type: application/json');

require_once '../app/config/EnvLoader.php';
require_once '../app/model/ApiClient.php';

try {
    // Load Environment Variables
    EnvLoader::load(__DIR__ . '/../.env');

    // Check query
    if (!isset($_GET['query'])) {
        echo json_encode(['error' => 'No query provided']);
        exit;
    }

    $query = $_GET['query'];

    // Instantiate Client and Fetch
    $client = new ApiClient();
    $response = $client->get($query);

    echo $response;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
