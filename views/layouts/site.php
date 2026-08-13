<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <title><?php echo $title ?? 'Site'; ?> | CMS</title>
</head>

<body>
    <header>
        <h1>Meu Site</h1>
    </header>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer>
        <a href="<?php echo baseUrl('admin'); ?>">Admin</a>
    </footer>

    <?php if (!empty($script)): ?>
        <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
    <?php endif; ?>
</body>

</html>