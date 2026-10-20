<?php

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/../config/db.php';
requireMethod('POST');

$body = readJsonBody();
$title = requiredText($body, 'title');
$author = requiredText($body, 'author');
$year = validBookYear($body['year'] ?? null);
$genre = requiredText($body, 'genre');

$errors = [];
if ($title === null) {
    $errors['title'] = 'title is required.';
}
if ($author === null) {
    $errors['author'] = 'author is required.';
}
if ($year === null) {
    $errors['year'] = 'year must be an integer from 0 to 9999.';
}
if ($genre === null) {
    $errors['genre'] = 'genre is required.';
}
if ($errors !== []) {
    jsonResponse(['error' => 'Validation failed.', 'details' => $errors], 400);
}

$pdo = getDatabaseConnection();
$statement = $pdo->prepare(
    'INSERT INTO books (title, author, year, genre) VALUES (:title, :author, :year, :genre)'
);
$statement->execute([
    'title' => $title,
    'author' => $author,
    'year' => $year,
    'genre' => $genre,
]);

$id = (int) $pdo->lastInsertId();
jsonResponse([
    'status' => 'created',
    'id' => $id,
    'data' => [
        'id' => $id,
        'title' => $title,
        'author' => $author,
        'year' => $year,
        'genre' => $genre,
    ],
], 201);
