<?php
ini_set('display_errors', '0');

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../core/functions.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
  jsonResponse(['error' => 'Method not allowed'], 405);
}

$data     = json_decode(file_get_contents('php://input'), true);
$email    = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (!$email || !$password) {
  jsonResponse(['error' => 'E-mail e senha são obrigatórios'], 400);
}

try {
  $userModel = new User();
  $user = $userModel->findByEmail($email);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    jsonResponse(['ok' => true]);
  } else {
    jsonResponse(['error' => 'Credenciais inválidas'], 401);
  }
} catch (Exception $e) {
  jsonResponse(['error' => $e->getMessage()], 500);
}
