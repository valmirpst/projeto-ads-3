<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo baseUrl(); ?>">
    <link rel="icon" type="image/png" href="<?php echo baseUrl('assets/images/no-image.jpg'); ?>">
    <title><?php echo $title ?? 'Admin'; ?> | CMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="navbar-light bg-light border-bottom">
        <nav class="navbar container-sm">
            <a class="navbar-brand d-flex align-items-center gap-3 mb-0" href="<?php echo baseUrl("admin"); ?>">
                <img src="<?php echo baseUrl('assets/images/no-image.jpg'); ?>" width="36" height="36" class="d-inline-block align-top" alt="Site Logo">
                <span class="fs-4 lh-1 text-dark">Admin</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
                    <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin"); ?>">Dashboard</a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin/sections"); ?>">Sections</a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin/settings"); ?>">Settings</a></li>
                    <li class="nav-item ps-4 border-start"><a class="nav-link text-secondary" href="<?php echo baseUrl(); ?>">Back to Home</a></li>
                    <li class="nav-item px-2"><a class="nav-link text-danger" href="<?php echo baseUrl("admin/logout"); ?>">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container-sm mb-5 flex-grow-1 mt-4">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-light py-4 mt-auto border-top">
        <div class="container-sm">
            <div class="row gy-3 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-1 text-muted">&copy; <?php echo date('Y'); ?> CMS Admin</p>
                    <small class="text-secondary">Todos os direitos reservados.</small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a class="text-secondary text-decoration-none" href="<?php echo baseUrl(); ?>">Back to Home</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <?php if (!empty($script)): ?>
        <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
    <?php endif; ?>
</body>

</html>