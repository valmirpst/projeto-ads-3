<?php
require_once __DIR__ . '/../../backend/models/Post.php';
require_once __DIR__ . '/../../backend/core/functions.php';

$postModel = new Post();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        if ($postModel->delete($id)) {
            $message = "Post excluído com sucesso.";
        } else {
            $error = "Erro ao excluir o post.";
        }
    } elseif ($action === 'save') {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $coverImage = $_POST['current_cover_image'] ?? null;

        // limpa o slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $slug)));

        if (isset($_FILES['cover_image_file']) && $_FILES['cover_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            $mediaId = handleUpload($_FILES['cover_image_file'], $uploadDir);

            if ($mediaId) {
                require_once __DIR__ . '/../../backend/models/Media.php';
                $mediaModel = new Media();
                $media = $mediaModel->getById($mediaId);
                if ($media) {
                    $coverImage = $media['file_path'];
                }
            }
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'cover_image' => $coverImage,
            'status' => $status
        ];

        try {
            if ($id) {
                if ($postModel->update($id, $data)) {
                    $message = "Post atualizado com sucesso.";
                } else {
                    $error = "Erro ao atualizar o post.";
                }
            } else {
                if ($postModel->create($data)) {
                    $message = "Post criado com sucesso.";
                } else {
                    $error = "Erro ao criar o post.";
                }
            }
        } catch (PDOException $e) {
            $error = "Erro no banco de dados (o slug já existe?): " . $e->getMessage();
        }
    }
}

$posts = $postModel->getAll();

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Gerenciador de Posts</h2>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#postModal" onclick="resetForm()">
        <i class="bi bi-plus-lg"></i> Novo Post
    </button>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div id="posts-list-container">
    <?php if (empty($posts)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h5 class="text-muted mb-3">Nenhum post encontrado</h5>
                <p class="text-muted mb-0">Você ainda não criou nenhum post no blog.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="list-group shadow-sm">
            <?php foreach ($posts as $post):
                $badgeClass = $post['status'] === 'published' ? 'bg-success' : 'bg-secondary';
                $badgeText = $post['status'] === 'published' ? 'Publicado' : 'Rascunho';
            ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h6 class="mb-1">
                            <?= htmlspecialchars($post['title']) ?>
                            <span class="badge <?= $badgeClass ?> ms-2"><?= $badgeText ?></span>
                        </h6>
                        <small class="text-muted">Slug: <?= htmlspecialchars($post['slug']) ?> | Data: <?= date('d/m/Y', strtotime($post['created_at'])) ?></small>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary" onclick='editPost(<?= htmlspecialchars(json_encode($post), ENT_QUOTES, "UTF-8") ?>)'>
                            <i class="bi bi-pencil"></i> Editar
                        </button>
                        <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este post?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" id="post-id">

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" name="title" id="post-title" required onkeyup="generateSlug()">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (URL amigável)</label>
                        <input type="text" class="form-control" name="slug" id="post-slug" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagem de Capa (Upload)</label>
                        <input type="file" class="form-control mb-2" name="cover_image_file" id="post-cover-image-file" accept="image/*">
                        <input type="hidden" name="current_cover_image" id="post-current-cover-image">
                        <div id="post-cover-image-preview" class="d-none">
                            <small class="text-muted d-block mb-1">Imagem atual:</small>
                            <img src="" alt="Capa" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Conteúdo (HTML permitido)</label>
                        <textarea class="form-control" name="content" id="post-content" rows="10" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="post-status">
                            <option value="draft">Rascunho</option>
                            <option value="published">Publicado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generateSlug() {
        if (document.getElementById('post-id').value !== '') return; // não muda auto se for edição

        const title = document.getElementById('post-title').value;
        const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        document.getElementById('post-slug').value = slug;
    }

    function resetForm() {
        document.getElementById('post-id').value = '';
        document.getElementById('post-title').value = '';
        document.getElementById('post-slug').value = '';
        document.getElementById('post-content').value = '';
        document.getElementById('post-status').value = 'draft';

        document.getElementById('post-cover-image-file').value = '';
        document.getElementById('post-current-cover-image').value = '';
        document.getElementById('post-cover-image-preview').classList.add('d-none');
        document.getElementById('post-cover-image-preview').querySelector('img').src = '';

        document.getElementById('postModalLabel').innerText = 'Criar Novo Post';
    }

    function editPost(post) {
        document.getElementById('post-id').value = post.id;
        document.getElementById('post-title').value = post.title;
        document.getElementById('post-slug').value = post.slug;
        document.getElementById('post-content').value = post.content;
        document.getElementById('post-status').value = post.status;

        document.getElementById('post-cover-image-file').value = '';
        document.getElementById('post-current-cover-image').value = post.cover_image || '';

        if (post.cover_image) {
            document.getElementById('post-cover-image-preview').classList.remove('d-none');
            document.getElementById('post-cover-image-preview').querySelector('img').src = '<?= rtrim(baseUrl(), '/') ?>/' + post.cover_image;
        } else {
            document.getElementById('post-cover-image-preview').classList.add('d-none');
        }

        document.getElementById('postModalLabel').innerText = 'Editar Post';
        var myModal = new bootstrap.Modal(document.getElementById('postModal'));
        myModal.show();
    }
</script>

<?php
$title   = 'Gerenciador de Posts';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>