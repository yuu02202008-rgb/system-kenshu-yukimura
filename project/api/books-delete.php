<?php

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/../config/db.php';
requireMethod('DELETE');

$rawId = $_GET['id'] ?? null;
if ($rawId === null) {
    $body = readJsonBody();
    $rawId = $body['id'] ?? null;
}

$id = positiveInteger($rawId);
if ($id === null) {
    jsonResponse(['error' => 'id must be a positive integer.'], 400);
}

$pdo = getDatabaseConnection();
$statement = $pdo->prepare('DELETE FROM books WHERE id = :id');
$statement->execute(['id' => $id]);

if ($statement->rowCount() === 0) {
    jsonResponse(['error' => 'Book not found.'], 404);
}

jsonResponse(['status' => 'ok', 'deleted_id' => $id]);
