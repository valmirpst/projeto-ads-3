<!DOCTYPE html>
<html lang="en">

<?php require __DIR__ . '/../components/head.php'; ?>

<body class="d-flex flex-column min-vh-100">
    <?php $is_admin_layout = true;
    require __DIR__ . '/../components/header.php'; ?>

    <main class="container-sm mb-5 flex-grow-1 mt-4">
        <?php echo $content ?? ''; ?>
    </main>

    <?php require __DIR__ . '/../components/footer.php'; ?>

    <?php require __DIR__ . '/../components/scripts.php'; ?>
</body>

</html>