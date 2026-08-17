<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <title><?php echo $title ?? 'Admin'; ?> | CMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <header class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <h1 class="navbar-brand mb-0">Admin</h1>
            <nav class="nav">
                <a class="nav-link text-white" href="<?php echo baseUrl("admin"); ?>">Dashboard</a>
                <a class="nav-link text-white" href="<?php echo baseUrl("admin/sections"); ?>">Sections</a>
                <a class="nav-link text-white-50" href="<?php echo baseUrl(); ?>">Back to Home</a>
                <a class="nav-link text-danger" href="<?php echo baseUrl("admin/logout"); ?>">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mb-5 flex-grow-1">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-white text-center text-muted py-3 border-top mt-auto">
        <div class="container">
            <small>&copy; <?php echo date('Y'); ?> CMS Admin</small>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <?php if (!empty($script)): ?>
        <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
    <?php endif; ?>
</body>

</html>