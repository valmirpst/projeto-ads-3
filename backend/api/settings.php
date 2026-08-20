<?php
ini_set('display_errors', '1');

require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/../core/functions.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'GET':
    $settingModel = new Setting();
    $settings = $settingModel->getSettings();

    if ($settings) {
      jsonResponse($settings);
    } else {
      jsonResponse(['error' => 'Settings not found'], 404);
    }
    break;

  case 'PUT':
    $body = json_decode(file_get_contents('php://input'), true);

    if (empty($body['site_name'])) {
      jsonResponse(['error' => 'site_name é obrigatório'], 400);
    }

    $settingModel = new Setting();
    $ok = $settingModel->updateSettings($body);

    if ($ok) {
      jsonResponse($settingModel->getSettings());
    } else {
      jsonResponse(['error' => 'Falha ao atualizar settings'], 500);
    }
    break;
}
