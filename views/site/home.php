<?php ob_start(); ?>

<h2>Hello World</h2>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>