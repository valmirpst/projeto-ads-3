<?php
function handleRequest(string $uri)
{
    // Verifica se a URI começa com '/api' para determinar se é uma rota de API
    if (strpos($uri, '/api') === 0) {
        handleApiRequest($uri);
    } else {
        handleWebRequest($uri);
    }
}

function handleApiRequest(string $uri)
{
    switch ($uri) {
        case '/api/sections':
            require_once __DIR__ . '/../api/sections.php';
            break;
        case '/api/auth':
            require_once __DIR__ . '/../api/auth.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint não encontrado']);
            break;
    }
}

function handleWebRequest(string $uri)
{
    switch ($uri) {
        case '/':
        case '/home':
            require_once __DIR__ . '/../../views/site/home.php';
            break;
        case '/admin':
            require_once __DIR__ . '/../../views/admin/dashboard.php';
            break;
        case '/admin/sections':
            require_once __DIR__ . '/../../views/admin/sections.php';
            break;
        default:
            http_response_code(404);
            echo 'Página não encontrada';
            break;
    }
}
