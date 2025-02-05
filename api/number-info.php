<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Optimized prime check without hardcoded values
function isPrime($num)
{
    if ($num < 2) return false;
    if ($num === 2) return true;
    if ($num % 2 === 0) return false;

    $sqrt = (int)sqrt($num);
    for ($i = 3; $i <= $sqrt; $i += 2) {
        if ($num % $i === 0) return false;
    }
    return true;
}

// Calculate if a number is perfect by finding its divisors
function isPerfect($num)
{
    if ($num < 1) return false;
    $sum = 1;
    $sqrt = (int)sqrt($num);

    for ($i = 2; $i <= $sqrt; $i++) {
        if ($num % $i === 0) {
            $sum += $i;
            if ($i !== $num / $i) {
                $sum += $num / $i;
            }
        }
    }

    return $sum === $num && $num !== 1;
}

// Armstrong number check with dynamic power calculation
function isArmstrong($num)
{
    static $powers = [];
    $sum = 0;
    $numStr = (string)$num;
    $len = strlen($numStr);

    // Calculate powers for this length if not already cached
    if (!isset($powers[$len])) {
        $powers[$len] = [];
        for ($i = 0; $i < 10; $i++) {
            $powers[$len][$i] = pow($i, $len);
        }
    }

    for ($i = 0; $i < $len; $i++) {
        $digit = (int)$numStr[$i];
        $sum += $powers[$len][$digit];
        if ($sum > $num) return false;  // Early exit if sum exceeds number
    }
    return $sum === $num;
}

// Optimized digit sum using mathematical approach
function sumOfDigits($num)
{
    $sum = 0;
    while ($num > 0) {
        $sum += $num % 10;
        $num = (int)($num / 10);
    }
    return $sum;
}

// Get properties dynamically
function getProperties($num)
{
    $properties = [];
    if (isArmstrong($num)) {
        $properties[] = "armstrong";
    }
    $properties[] = ($num & 1) ? "odd" : "even";
    return $properties;
}

// Get fun fact with configurable timeout
function getFunFact($num, $timeout = 0.3)
{
    $url = "http://numbersapi.com/{$num}/math";
    $ctx = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => $timeout,
            'ignore_errors' => true
        ]
    ]);

    $response = @file_get_contents($url, false, $ctx);
    return $response === FALSE ? 'Fact unavailable' : $response;
}

// Input validation and processing
if (!isset($_GET['number']) || !is_numeric($_GET['number'])) {
    http_response_code(400);
    echo json_encode(["error" => true, 'number' => $_GET['number']]);
    exit;
}

$number = (int)$_GET['number'];

// Generate response
$response = [
    "number" => $number,
    "is_prime" => isPrime($number),
    "is_perfect" => isPerfect($number),
    "properties" => getProperties($number),
    "digit_sum" => sumOfDigits($number),
    "fun_fact" => getFunFact($number)
];

echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
