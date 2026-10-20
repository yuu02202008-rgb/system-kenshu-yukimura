<?php

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/../config/db.php';
requireMethod('PUT');

$body = readJsonBody();
$id = positiveInteger($body['id'] ?? null);
if ($id === null) {
    jsonResponse(['error' => 'id must be a positive integer.'], 400);
}

$pdo = getDatabaseConnection();
$findStatement = $pdo->prepare(
    'SELECT id, title, author, year, genre FROM books WHERE id = :id'
);
$findStatement->execute(['id' => $id]);
$existing = $findStatement->fetch();
if ($existing === false) {
    jsonResponse(['error' => 'Book not found.'], 404);
}

// PUTで項目を省略した場合は現在の値を保ちます。
$title = array_key_exists('title', $body) ? requiredText($body, 'title') : $existing['title'];
$author = array_key_exists('author', $body) ? requiredText($body, 'author') : $existing['author'];
$year = array_key_exists('year', $body) ? validBookYear($body['year']) : (int) $existing['year'];
$genre = array_key_exists('genre', $body)
    ? (is_string($body['genre']) ? trim($body['genre']) : null)
    : $existing['genre'];

$errors = [];
if ($title === null) {
    $errors['title'] = 'title must be a non-empty string.';
}
if ($author === null) {
    $errors['author'] = 'author must be a non-empty string.';
}
if ($year === null) {
    $errors['year'] = 'year must be an integer from 0 to 9999.';
}
if ($genre === null) {
    $errors['genre'] = 'genre must be a string.';
}
if ($errors !== []) {
    jsonResponse(['error' => 'Validation failed.', 'details' => $errors], 400);
}

$statement = $pdo->prepare(
    'UPDATE books SET title = :title, author = :author, year = :year, genre = :genre WHERE id = :id'
);
$statement->execute([
    'title' => $title,
    'author' => $author,
    'year' => $year,
    'genre' => $genre,
    'id' => $id,
]);

jsonResponse([
    'status' => 'ok',
    'data' => [
        'id' => $id,
        'title' => $title,
        'author' => $author,
        'year' => $year,
        'genre' => $genre,
    ],
]);
