<?php
// URLとHTTPメソッドで実行する処理を決める入口。
require_once __DIR__ . '/api/response.php';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($path === '/' && $method === 'GET') {
    readfile(__DIR__ . '/frontend/index.html');
    exit;
}
if ($path === '/examples/week-01.php' && $method === 'GET') {
    require __DIR__ . '/examples/week-01.php';
    exit;
}
// 第2週のPostman用URLを維持する。
$legacy = [
    '/api/status.php' => 'status.php',
    '/api/books-get.php' => 'books-get.php',
    '/api/books-create.php' => 'books-create.php',
    '/api/books-update.php' => 'books-update.php',
    '/api/books-delete.php' => 'books-delete.php',
];
if (isset($legacy[$path])) {
    require __DIR__ . '/api/' . $legacy[$path];
    exit;
}
if ($path === '/api/books') {
    $handlers = ['GET' => 'books-get.php', 'POST' => 'books-create.php',
        'PUT' => 'books-update.php', 'DELETE' => 'books-delete.php'];
    if (!isset($handlers[$method])) {
        header('Allow: GET, POST, PUT, DELETE');
        jsonResponse(['error' => 'Method not allowed.'], 405);
    }
    require __DIR__ . '/api/' . $handlers[$method];
    exit;
}
jsonResponse(['error' => 'Route not found.'], 404);
