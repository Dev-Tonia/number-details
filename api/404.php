<?php

header("Content-Type: application/json"); // Set response content type to JSON
header("Access-Control-Allow-Origin: *"); // Handle CORS


// Set the status code to 404
http_response_code(404);


// Prepare the response array
$response = [
    'error' => true,
    'message' => '404 Not Found',
];

// Return JSON response
echo json_encode($response, JSON_PRETTY_PRINT);
