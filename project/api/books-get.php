<?php

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/../config/db.php';
requireMethod('GET');

$pdo = getDatabaseConnection();
$rawId = $_GET['id'] ?? null;

if ($rawId !== null) {
    $id = positiveInteger($rawId);
    if ($id === null) {
        jsonResponse(['error' => 'id must be a positive integer.'], 400);
    }

    $statement = $pdo->prepare(
        'SELECT id, title, author, year, genre FROM books WHERE id = :id'
    );
    $statement->execute(['id' => $id]);
    $book = $statement->fetch();

    if ($book === false) {
        jsonResponse(['error' => 'Book not found.'], 404);
    }

    jsonResponse(['status' => 'ok', 'data' => $book]);
}

$statement = $pdo->query(
    'SELECT id, title, author, year, genre FROM books ORDER BY id ASC'
);
jsonResponse(['status' => 'ok', 'data' => $statement->fetchAll()]);
