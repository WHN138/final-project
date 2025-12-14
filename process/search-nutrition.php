<?php
header('Content-Type: application/json');

// Check if query is set
if (!isset($_GET['query'])) {
    echo json_encode(['error' => 'No query provided']);
    exit;
}

$query = urlencode($_GET['query']);

// User Instructions:
// 1. Sign up at https://developer.edamam.com/edamam-nutrition-api
// 2. Get your Application ID and Application Key
// 3. Replace the values below:

$appId = 'd256b72e'; 
$appKey = '3ca53b1a025d1f0e8ab435eccc6b1cab';

// IMPORTANT: Do not share your API keys publicly.

$url = "https://api.edamam.com/api/food-database/v2/parser?app_id={$appId}&app_key={$appKey}&ingr={$query}&nutrition-type=cooking";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
} elseif ($httpCode !== 200) {
     echo json_encode(['error' => 'API request failed with status ' . $httpCode, 'details' => json_decode($response)]);
} else {
    echo $response;
}

curl_close($ch);
?>
