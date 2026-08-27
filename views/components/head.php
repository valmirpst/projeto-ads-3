<?php
require_once __DIR__ . '/../../backend/models/Setting.php';
$settingModel = new Setting();
$globalSettings = $settingModel->getSettings();
$siteName = $globalSettings['site_name'] ?? 'CMS';
$favicon = !empty($globalSettings['favicon_path']) ? baseUrl($globalSettings['favicon_path']) : baseUrl('assets/images/no-image.jpg');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <link rel="icon" type="image/png" href="<?php echo $favicon; ?>">
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' | ' . htmlspecialchars($siteName) : htmlspecialchars($siteName); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>