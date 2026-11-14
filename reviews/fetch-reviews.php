<?php

// how to use

// $reviewsOpts = [
//   'json'       => __DIR__ . '/data/reviews-cache.json',
//   'title'      => 'What our students say',
//   'limit'      => 6,
//   'min_rating' => 4,
//   'exclude'    => [],   // author names to hide
// ];
// include 'includes/reviews.php';

$config = include __DIR__ . '/../env.php';

// Set your credentials and file path
$placeId   = $config['PLACE_ID'];
$apiKey    = $config['GOOGLE_API_KEY'];
$cacheFile = __DIR__ . '/reviews-cache.json';

// API URL with Field Mask in the header
$url = "https://places.googleapis.com/v1/places/{$placeId}";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => true, // Secure HTTPS connection
    CURLOPT_HTTPHEADER     => [
        "Content-Type: application/json",
        "X-Goog-Api-Key: {$apiKey}",
        "X-Goog-FieldMask: id,displayName,rating,userRatingCount,reviews,googleMapsUri"
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Safety Check: Only update cache if Google returns a valid 200 OK with reviews
if ($httpCode === 200 && $response) {
    $decoded = json_decode($response, true);
    if (!empty($decoded['reviews'])) {
        // Automatically creates the file if missing, or completely overwrites (clears) the old data if it exists
        file_put_contents($cacheFile, $response, LOCK_EX);
        echo "Success: Reviews cache updated safely.";
    } else {
        echo "Notice: API responded, but reviews array was empty. Existing cache was left untouched.";
    }
} else {
    echo "Error: Failed to fetch from Google (HTTP Code: {$httpCode})";
}
?>