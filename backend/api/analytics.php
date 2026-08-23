<?php
require_once __DIR__ . '/../models/Visit.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $visitModel = new Visit();
    // Pega as visitas dos últimos 30 dias para a Dashboard
    $visits = $visitModel->getRecentVisits(30);

    header('Content-Type: application/json');
    echo json_encode($visits);
    exit;
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $sessionId = $data['session_id'] ?? null;
    $pageUrl = $data['page_url'] ?? '/';

    if ($sessionId) {
        $visitModel = new Visit();
        $visitModel->logVisit($sessionId, $pageUrl);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'session_id is required']);
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}
