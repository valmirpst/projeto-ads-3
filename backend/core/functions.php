<?php
function jsonResponse(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function baseUrl(string $path = ''): string
{
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    if ($scriptName === '\\' || $scriptName === '/') {
        $scriptName = '';
    }
    return rtrim($scriptName, '/') . '/' . ltrim($path, '/');
}

function handleUpload(array $file, string $uploadDir): ?int
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '-' . time() . '.' . $ext;

    if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        require_once __DIR__ . '/../models/Media.php';
        $mediaModel = new Media();
        return $mediaModel->create($file['name'], 'uploads/' . $fileName, $file['type']);
    }

    return null;
}
