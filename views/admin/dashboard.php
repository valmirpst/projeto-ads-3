<?php ob_start(); ?>

<h2>Dashboard</h2>

<?php
$title   = 'Dashboard';
$script  = 'pages/admin/dashboard.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>