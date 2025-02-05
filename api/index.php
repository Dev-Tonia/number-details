<?php

$uri = $_SERVER['REQUEST_URI'];
$url_parts = explode('?', $uri)[0];

if ($url_parts === '/api/classify-number') {
    include  __DIR__ . '/number-info.php';
} else {
    include  __DIR__ . '/404.php';
}
