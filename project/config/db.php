<?php

require_once __DIR__ . '/../api/response.php';

function getDatabaseConnection(): PDO
{
    $requiredVariables = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
    $configuration = [];

    foreach ($requiredVariables as $variable) {
        $value = getenv($variable);
        if ($value === false || $value === '') {
            jsonResponse(['error' => 'Database configuration is incomplete.'], 500);
        }
        $configuration[$variable] = $value;
    }

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        $configuration['DB_HOST'],
        $configuration['DB_NAME']
    );

    try {
        return new PDO($dsn, $configuration['DB_USER'], $configuration['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        error_log('Database connection failed: ' . $exception->getMessage());
        jsonResponse(['error' => 'Could not connect to the database.'], 500);
    }
}
