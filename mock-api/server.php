<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$requestUri = $_SERVER['REQUEST_URI'];

$routes = [
    '/api/ched'     => __DIR__ . '/data/ched_scholarships.json',
    '/api/dost'     => __DIR__ . '/data/dost_scholarships.json',
    '/api/lgu'      => __DIR__ . '/data/lgu_scholarships.json',
];

foreach ($routes as $route => $file) {
    if (str_starts_with($requestUri, $route)) {
        if (file_exists($file)) {
            echo file_get_contents($file);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Data file not found']);
        }
        exit;
    }
}

http_response_code(404);
echo json_encode([
    'error'     => 'Endpoint not found',
    'available' => array_keys($routes)
]);