<!DOCTYPE html>
<html lang="en">

<?php require __DIR__ . '/../components/head.php'; ?>

<body class="d-flex align-items-center justify-content-center min-vh-100">
    <main class="container">
        <?php echo $content ?? ''; ?>
    </main>

    <?php require __DIR__ . '/../components/scripts.php'; ?>
</body>

</html>