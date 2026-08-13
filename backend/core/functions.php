<?php
function jsonResponse(array $data, $statusCode = 200)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function baseUrl($path = '')
{
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    if ($scriptName === '\\' || $scriptName === '/') {
        $scriptName = '';
    }
    return rtrim($scriptName, '/') . '/' . ltrim($path, '/');
}
