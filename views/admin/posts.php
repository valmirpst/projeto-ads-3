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
            $message = "Post deleted successfully.";
        } else {
            $error = "Failed to delete post.";
        }
    } elseif ($action === 'publish') {
        $id = (int)$_POST['id'];
        if ($postModel->publish($id)) {
            $message = "Post published successfully.";
        } else {
            $error = "Failed to publish post.";
        }
    } elseif ($action === 'save') {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title = $_POST['title'] ?? '';
        $slug = $_POST['slug'] ?? '';
        $content = $_POST['content'] ?? '';
        $status = $_POST['status'] ?? 'draft';
        $coverImage = $_POST['current_cover_image'] ?? null;

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
                    $message = "Post updated successfully.";
                } else {
                    $error = "Failed to update post.";
                }
            } else {
                if ($postModel->create($data)) {
                    $message = "Post created successfully.";
                } else {
                    $error = "Failed to create post.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error (does the slug already exist?): " . $e->getMessage();
        }
    }
}

$posts = $postModel->getAll();

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Posts Management</h2>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#postModal" onclick="resetForm()">
        <i class="bi bi-plus-lg"></i> New Post
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
                <h5 class="text-muted mb-3">No posts found</h5>
                <p class="text-muted mb-0">You haven't created any blog posts yet.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="list-group shadow-sm">
            <?php foreach ($posts as $post):
                $badgeClass = $post['status'] === 'published' ? 'bg-success' : 'bg-secondary';
                $badgeText = $post['status'] === 'published' ? 'Published' : 'Draft';
            ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h6 class="mb-1">
                            <?= htmlspecialchars($post['title']) ?>
                            <span class="badge <?= $badgeClass ?> ms-2"><?= $badgeText ?></span>
                        </h6>
                        <small class="text-muted">Slug: <?= htmlspecialchars($post['slug']) ?> | Date: <?= date('M d, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?></small>
                    </div>
                    <div class="d-flex gap-2">
                        <?php if ($post['status'] === 'draft'): ?>
                            <form method="POST" onsubmit="return confirm('Publish this post?');">
                                <input type="hidden" name="action" value="publish">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-check2-circle"></i> Publish
                                </button>
                            </form>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-outline-primary" onclick='editPost(<?= htmlspecialchars(json_encode($post), ENT_QUOTES, "UTF-8") ?>)'>
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
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
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="post-title" required onkeyup="generateSlug()">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (Friendly URL)</label>
                        <input type="text" class="form-control" name="slug" id="post-slug" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover Image (Upload)</label>
                        <input type="file" class="form-control mb-2" name="cover_image_file" id="post-cover-image-file" accept="image/*">
                        <input type="hidden" name="current_cover_image" id="post-current-cover-image">
                        <div id="post-cover-image-preview" class="d-none">
                            <small class="text-muted d-block mb-1">Current image:</small>
                            <img src="" alt="Cover" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content (HTML allowed)</label>
                        <textarea class="form-control" name="content" id="post-content" rows="10" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="post-status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generateSlug() {
        if (document.getElementById('post-id').value !== '') return;

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

        document.getElementById('postModalLabel').innerText = 'Create New Post';
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

        document.getElementById('postModalLabel').innerText = 'Edit Post';
        var myModal = new bootstrap.Modal(document.getElementById('postModal'));
        myModal.show();
    }
</script>

<?php
$title   = 'Posts Management';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>