<?php
require_once __DIR__ . '/../models/Visit.php';
require_once __DIR__ . '/../core/functions.php';

$method = $_SERVER['REQUEST_METHOD'];
$visitModel = new Visit();

if ($method === 'GET') {
    $visits = $visitModel->getRecentVisits(30);
    jsonResponse($visits);
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $sessionId = $data['session_id'] ?? null;
    $pageUrl = $data['page_url'] ?? '/';

    if ($sessionId) {
        $visitModel->logVisit($sessionId, $pageUrl);
        jsonResponse(['success' => true]);
    } else {
        jsonResponse(['error' => 'session_id is required'], 400);
    }
} else {
    jsonResponse(['error' => 'Method Not Allowed'], 405);
}
