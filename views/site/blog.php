<?php
require_once __DIR__ . '/../../backend/models/Post.php';

$postModel = new Post();
$posts = $postModel->getPublished();

ob_start();
?>

<div class="container-sm py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold">Blog</h1>
            <p class="lead text-muted">Read our latest news and articles.</p>
        </div>
    </div>

    <?php if (empty($posts)): ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-journal-x display-1 d-block mb-3"></i>
            <p class="fs-5">No posts published yet.</p>
            <p>Check back soon for updates!</p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($posts as $post):
                $coverUrl = !empty($post['cover_image']) ? baseUrl($post['cover_image']) : baseUrl('assets/images/no-image.jpg');
            ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                            <img src="<?= htmlspecialchars($coverUrl) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-3"><?= htmlspecialchars($post['title']) ?></h5>
                            <p class="card-text text-muted small mb-4">
                                <i class="bi bi-calendar3"></i> <?= date('M d, Y', strtotime($post['created_at'])) ?>
                            </p>
                            <a href="<?= baseUrl('post?slug=' . urlencode($post['slug'])) ?>" class="btn btn-outline-primary mt-auto stretched-link">Read more</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>

<?php
$title   = 'Blog';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>