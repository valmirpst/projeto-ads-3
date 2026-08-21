<?php
ini_set('display_errors', '1');

require_once __DIR__ . '/../models/Media.php';
require_once __DIR__ . '/../core/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method Not Allowed'], 405);
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    jsonResponse(['error' => 'No file uploaded or upload error.'], 400);
}

$file = $_FILES['file'];
$uploadDir = __DIR__ . '/../../public/uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION); // extensão
$fileName = uniqid() . '-' . time() . '.' . $ext; // nome único do arquivo
$targetPath = $uploadDir . $fileName;

if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    $mediaModel = new Media();
    $dbPath = 'uploads/' . $fileName;

    $mediaId = $mediaModel->create($file['name'], $dbPath, $file['type']);

    jsonResponse([
        'success' => true,
        'media_id' => $mediaId,
        'path' => $dbPath,
        'url' => '/projetos/projeto-ads-3/public/' . $dbPath
    ]);
} else {
    jsonResponse(['error' => 'Failed to move uploaded file.'], 500);
}
