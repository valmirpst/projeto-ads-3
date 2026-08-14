<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <title><?php echo $title ?? 'Admin'; ?> | CMS</title>
</head>

<body>
    <header>
        <h1>Admin</h1>
        <a href="<?php echo baseUrl("admin"); ?>">Dashboard</a>
        <a href="<?php echo baseUrl("admin/sections"); ?>">Sections</a>
        <a href="<?php echo baseUrl("admin/logout"); ?>">Logout</a>
        <a href="<?php echo baseUrl(); ?>">Back to Home</a>
    </header>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer>
    </footer>

    <?php if (!empty($script)): ?>
        <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
    <?php endif; ?>
</body>

</html>