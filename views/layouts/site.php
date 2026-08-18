<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <link rel="icon" type="image/png" href="<?php echo baseUrl('assets/images/no-image.jpg'); ?>">
    <title><?php echo $title ?? 'Site'; ?> | CMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <main class="container flex-grow-1 mb-5">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <a class="text-white-50 text-decoration-none" href="<?php echo baseUrl('admin'); ?>">Admin</a>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <?php if (!empty($script)): ?>
        <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
    <?php endif; ?>
</body>

</html>