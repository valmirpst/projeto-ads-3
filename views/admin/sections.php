<?php ob_start(); ?>

<h2>Admin Sections</h2>

<?php
$title   = 'Sections Management';
$script  = 'pages/admin/sections.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>