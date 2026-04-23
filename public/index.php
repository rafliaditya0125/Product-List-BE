<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/ProductController.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$env = parse_ini_file(__DIR__ . '/../.env');

$pdo = getDBConnection();
$baseUrl = $env['BASE_URL'];

$authController = new AuthController($pdo);
$productController = new ProductController($pdo, $baseUrl);

// Route mapping
$routes = [
    'POST' => [
        '/api/login' => fn() => $authController->login(),
        '/api/register' => fn() => $authController->register(),
        '/api/products' => fn() => $productController->store(),
        '/api/products/update' => fn() => $productController->update(),
        '/api/products/delete' => fn() => $productController->delete(),
    ],
    'GET' => [
        '/api/products' => fn() => $productController->index(),
    ]
];

if (isset($routes[$method][$path])) {
    $routes[$method][$path]();
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}
