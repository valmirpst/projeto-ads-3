<!DOCTYPE html>
<html lang="en">

<?php require __DIR__ . '/../components/head.php'; ?>

<body class="d-flex flex-column min-vh-100">
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <main class="flex-grow-1 mb-5 d-flex flex-column">
        <?php echo $content ?? ''; ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>

    <?php require __DIR__ . '/../components/scripts.php'; ?>
</body>

</html>