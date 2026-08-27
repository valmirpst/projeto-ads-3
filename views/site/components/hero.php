<?php

$backgroundImage = $config['backgroundImage'] ?? '';
$textColor = $config['textColor'] ?? '#000';
$title = $config['title'] ?? 'Default Hero Title';
$subtitle = $config['subtitle'] ?? '';
$buttonText = $config['buttonText'] ?? '';
$buttonLink = $config['buttonLink'] ?? '#';
$buttonColor = $config['buttonColor'] ?? '#007bff';
$buttonTextColor = $config['buttonTextColor'] ?? '#fff';

$bgStyle = $backgroundImage ? "background-image: url('" . baseUrl($backgroundImage) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;" : "";
?>

<section style="<?= $bgStyle ?> padding: 4rem 2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh; text-align: center; color: <?= htmlspecialchars($textColor) ?>;">
    <h1 style="font-size: 4rem; margin-bottom: 1rem; max-width: 800px;">
        <?= htmlspecialchars($title) ?>
    </h1>

    <?php if ($subtitle): ?>
        <p style="font-size: 1.5rem; margin-bottom: 2rem; max-width: 800px;">
            <?= htmlspecialchars($subtitle) ?>
        </p>
    <?php endif; ?>

    <?php if ($buttonText): ?>
        <a href="<?= htmlspecialchars($buttonLink) ?>" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: <?= htmlspecialchars($buttonColor) ?>; color: <?= htmlspecialchars($buttonTextColor) ?>; text-decoration: none; border-radius: 0.25rem; font-weight: bold;">
            <?= htmlspecialchars($buttonText) ?>
        </a>
    <?php endif; ?>
</section>