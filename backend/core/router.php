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
    try {
        switch ($uri) {
            case '/api/analytics':
                require_once __DIR__ . '/../api/analytics.php';
                break;
            case '/api/upload':
                require_once __DIR__ . '/../api/upload.php';
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint não encontrado']);
                break;
        }
    } catch (Throwable $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

function handleWebRequest(string $uri)
{
    // Qualquer rota /admin/* exige login, exceto a própria tela de login
    if (strpos($uri, '/admin') === 0 && $uri !== '/admin/login' && !(isset($_SESSION['user_id']))) {
        header('Location: ' . baseUrl('admin/login'));
        exit;
    }

    // Se a rota for /admin/login e o usuário já estiver logado, redireciona para o dashboard
    if ($uri === '/admin/login' && isset($_SESSION['user_id'])) {
        header('Location: ' . baseUrl('admin'));
        exit;
    }

    switch ($uri) {
        case '/':
        case '/home':
            require_once __DIR__ . '/../../views/site/home.php';
            break;
        case '/admin':
            require_once __DIR__ . '/../../views/admin/dashboard.php';
            break;
        case '/admin/login':
            require_once __DIR__ . '/../../views/admin/login.php';
            break;
        case '/admin/logout':
            session_destroy();
            header('Location: ' . baseUrl('admin/login'));
            exit;
        case '/admin/sections':
            require_once __DIR__ . '/../../views/admin/sections.php';
            break;
        case '/admin/settings':
            require_once __DIR__ . '/../../views/admin/settings.php';
            break;
        default:
            http_response_code(404);
            echo 'Página não encontrada';
            break;
    }
}
