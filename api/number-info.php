<?php
// Set response content type to JSON and handle CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Check if a number is a prime number  
function isPrime($num)
{
    if ($num < 2) return false;
    for ($i = 2; $i * $i <= $num; $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

// Check if the number is a perfect number
function isPerfect($num)
{
    if ($num < 1) return false;
    $sum = 0;
    for ($i = 1; $i < $num; $i++) {
        if ($num % $i == 0) {
            $sum += $i;
        }
    }
    return $sum == $num;
}

// Check if the number is an Armstrong number
function isArmstrong($num)
{
    $sum = 0;
    $digits = str_split($num);
    $power = strlen($num);
    foreach ($digits as $digit) {
        $sum += pow($digit, $power);
    }
    return $sum == $num;
}

// Sum of the digits of the number
function sumOfDigits($num)
{
    return array_sum(str_split($num));
}

// Get the properties of a number 
function getProperties($num)
{
    $properties = [];
    if (isArmstrong($num)) {
        $properties[] = "armstrong";
    }
    $properties[] = ($num % 2) ? "odd" : "even";
    return $properties;
}

// Get the fun fact of the number with a timeout
function getFunFact($num)
{
    $url = "http://numbersapi.com/{$num}/math";
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/json',
            'timeout' => 0.5 // Set timeout to 500ms
        ],
    ]);

    $response = @file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return 'Error: Unable to retrieve fun fact.';
    }
    $response = json_decode($response, true);
    return $response['text'];
}

// Reusable function to send JSON response
function sendJsonResponse($data, $status = 200)
{
    http_response_code($status);
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    echo $json;
    exit;
}

// Getting the number from the URL
$number = $_GET['number'];

// Check if the value from the URL is a number 
if (!is_numeric($number)) {
    $data = [
        "number" => $number,
        "error" => true,
    ];
    sendJsonResponse($data, 400);
    exit;
}

$number = (int)$number;

// Responses for the number
$response = [
    "number" => $number,
    "is_prime" => isPrime($number),
    "is_perfect" => isPerfect($number),
    "properties" => getProperties($number),
    "digit_sum" => sumOfDigits($number),
    "fun_fact" => getFunFact($number)
];
sendJsonResponse($response);
