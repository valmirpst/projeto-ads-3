<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Site</title>
</head>

<body>
    <header>
        <h1>Meu Site</h1>
    </header>
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    <script type="module" src="<?php echo baseUrl('assets/js/pages/home.js'); ?>"></script>
</body>

</html>