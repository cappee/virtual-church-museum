<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$directory = __DIR__ . '/../data/photos/about';
$baseUrl = 'http://localhost:8000/data/photos/about';

$files = scandir($directory);

$imageUrls = [];
foreach ($files as $file) {
  if ($file !== '.' && $file !== '..') {
    $imageUrls[] = $baseUrl . '/' . $file;
  }
}

echo json_encode($imageUrls);
