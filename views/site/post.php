<?php
require_once __DIR__ . '/../../backend/models/Post.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    header('Location: ' . baseUrl('blog'));
    exit;
}

$postModel = new Post();
$post = $postModel->getBySlug($slug);

// Verifica se o post existe e se está publicado (ou se o admin está logado)
$isAdmin = isset($_SESSION['user_id']);
if (!$post || ($post['status'] !== 'published' && !$isAdmin)) {
    http_response_code(404);
    die('Post não encontrado.');
}

ob_start();
?>

<div class="container-sm py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= baseUrl('blog') ?>">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($post['title']) ?></li>
                </ol>
            </nav>

            <?php if ($post['status'] !== 'published'): ?>
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle"></i> Este post é um rascunho. Só você (Admin) pode vê-lo.
                </div>
            <?php endif; ?>

            <article>
                <header class="mb-4">
                    <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($post['title']) ?></h1>
                    <div class="text-muted mb-4">
                        <i class="bi bi-calendar3"></i> Publicado em <?= date('d/m/Y \à\s H:i', strtotime($post['created_at'])) ?>
                    </div>
                </header>

                <?php if (!empty($post['cover_image'])): ?>
                    <figure class="mb-5">
                        <img src="<?= baseUrl($post['cover_image']) ?>" class="img-fluid rounded shadow-sm w-100" alt="<?= htmlspecialchars($post['title']) ?>">
                    </figure>
                <?php endif; ?>

                <section class="post-content lh-lg fs-5">
                    <?= $post['content'] ?> <!-- Renderiza o HTML do conteúdo -->
                </section>
            </article>

            <div class="mt-5 pt-4 border-top text-center">
                <a href="<?= baseUrl('blog') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar para o Blog
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .post-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem;
    }
</style>

<?php
$title   = htmlspecialchars($post['title']);
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>