<?php
require_once __DIR__ . '/../../backend/models/Section.php';
$sectionModel = new Section();
$sections = $sectionModel->getAllOrdered();

ob_start();
?>

<div id="sections-container" class="flex-grow-1">
    <?php foreach ($sections as $section): ?>
        <?php
        $config = json_decode($section['config'], true);
        $type = $section['type'];
        $componentPath = __DIR__ . "/components/{$type}.php";
        if (file_exists($componentPath)) {
            require $componentPath;
        }
        ?>
    <?php endforeach; ?>
</div>

<?php
$title   = 'Home';
$script  = 'pages/home.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>