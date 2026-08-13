<?php
session_start();

require_once __DIR__ . '/../backend/core/router.php';
require_once __DIR__ . '/../backend/core/functions.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME']);

// Remove o diretório base (/projetos/projeto-ads-3/public)
if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
    $uri = substr($uri, strlen($scriptName));
}

// Garante que a raiz vazia seja tratada como '/'
if ($uri === '' || $uri === false) {
    $uri = '/';
}

handleRequest($uri);
