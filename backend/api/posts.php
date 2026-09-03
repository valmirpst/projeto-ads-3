<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../core/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $postModel = new Post();
    $posts = $postModel->getAll();
    jsonResponse($posts);
} else {
    jsonResponse(['error' => 'Method Not Allowed'], 405);
}
