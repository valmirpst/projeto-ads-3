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
      jsonResponse(['error' => 'Configurações não encontradas'], 404);
    }
    break;
}
