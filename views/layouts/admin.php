<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | CMS</title>
</head>

<body>
    <header>
        <h1>Admin</h1>
    </header>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer>
        <a href="<?php echo baseUrl(); ?>">Home</a>
    </footer>

    <script type="module" src="<?php echo baseUrl('assets/js/pages/admin.js'); ?>"></script>
</body>

</html>