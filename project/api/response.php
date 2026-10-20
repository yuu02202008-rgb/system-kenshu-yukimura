<?php

set_exception_handler(static function (Throwable $exception): void {
    error_log('Unhandled API exception: ' . $exception->getMessage());
    jsonResponse(['error' => 'An unexpected server error occurred.'], 500);
});

function jsonResponse(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function requireMethod(string $expectedMethod): void
{
    $actualMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    if ($actualMethod !== $expectedMethod) {
        header('Allow: ' . $expectedMethod);
        jsonResponse(['error' => 'Method not allowed.'], 405);
    }
}

function readJsonBody(): array
{
    $rawBody = file_get_contents('php://input');
    $decoded = json_decode($rawBody === false ? '' : $rawBody, true);

    if (!is_array($decoded) || json_last_error() !== JSON_ERROR_NONE) {
        jsonResponse(['error' => 'Request body must be a valid JSON object.'], 400);
    }

    return $decoded;
}

function positiveInteger(mixed $value): ?int
{
    $validated = filter_var($value, FILTER_VALIDATE_INT);
    return $validated !== false && $validated > 0 ? $validated : null;
}

function requiredText(array $data, string $key): ?string
{
    if (!isset($data[$key]) || !is_string($data[$key])) {
        return null;
    }

    $value = trim($data[$key]);
    return $value === '' ? null : $value;
}

function validBookYear(mixed $value): ?int
{
    $validated = filter_var($value, FILTER_VALIDATE_INT);
    return $validated !== false && $validated >= 0 && $validated <= 9999
        ? $validated
        : null;
}
