<?php

require_once __DIR__ . '/response.php';
requireMethod('GET');

jsonResponse([
    'message' => 'API is running',
    'status' => 'ok',
]);
