<?php
// Set response content type to JSON and handle cors
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// check if a number is prime number  
function isPrime($num)
{
    // checking if the number is less than 2 
    if ($num < 2) return false;

    for ($i = 2; $i * $i <= $num; $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}

// check if the number is perfect number
function isPerfect($num)
{
    // check if the number is less than 1 
    if ($num < 1) return false;
    $sum = 0;
    for ($i = 1; $i < $num; $i++) {
        if ($num % $i == 0) {
            $sum += $i;
        }
    }
    return $sum == $num;
}

// check if the number is armstrong number
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

// sum of the digits of the number
function sumOfDigits($num)
{
    return array_sum(str_split($num));
}

// get the properties of a number 
function getProperties($num)
{
    $properties = [];
    $is_armstrong = isArmstrong($num);
    if ($is_armstrong) {
        $properties[] = "armstrong";
    }
    $properties[] = ($num % 2) ? "odd" : "even";
    return $properties;
}

// get the fun fact of the number
function getFunFact($num)
{
    $url = "http://numbersapi.com/{$num}/math";
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/json',
        ],
    ]);

    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return 'Error: Unable to retrieve fun fact.';
    }

    return $response;
}

// reusable function to send json response
function sendJsonResponse($data, $status = 200)
{
    http_response_code($status);
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    echo $json;
    exit;
}

// getting the number from the url
$number = (int)$_GET['number'];

// check if the value from the url is a number 
if (!is_numeric($number)) {
    $data = [
        "number" => $number . ' is not a number',
        "error" => true,
        "message" => "The value must be a number"
    ];
    sendJsonResponse($data, 400);
}

// responses for the number
$response = [
    "number" => $number,
    "is_prime" => isPrime($number),
    "is_perfect" => isPerfect($number),
    "properties" => getProperties($number),
    "digit_sum" => sumOfDigits($number),
    "fun_fact" => getFunFact($number)
];
sendJsonResponse($response);
