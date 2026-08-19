<?php
require_once __DIR__ . '/../models/Section.php';
require_once __DIR__ . '/../core/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sectionModel = new Section();

    // Verifica se é pra buscar todas ou só as ativas e ordenadas
    if (isset($_GET['all']) && $_GET['all'] === 'true') {
        $sections = $sectionModel->getAll();
    } else {
        $sections = $sectionModel->getAllOrdered();
    }

    // decode de cada config JSON
    foreach ($sections as &$section) {
        if (!empty($section['config']) && is_string($section['config'])) {
            $section['config'] = json_decode($section['config'], true);
        }
    }

    jsonResponse($sections);
} else {
    jsonResponse(['error' => 'Method Not Allowed'], 405);
}
