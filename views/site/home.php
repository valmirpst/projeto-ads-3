<?php ob_start(); ?>

<div id="sections-container" class="flex-grow-1"></div>

<?php
$title   = 'Home';
$script  = 'pages/home.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>