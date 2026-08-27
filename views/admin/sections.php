<?php
require_once __DIR__ . '/../../backend/models/Section.php';

$sectionModel = new Section();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        if ($sectionModel->delete($id)) {
            $message = "Section deleted successfully.";
        } else {
            $error = "Failed to delete section.";
        }
    } elseif ($action === 'save') {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $type = $_POST['type'] ?? '';
        $enabled = isset($_POST['enabled']) ? 1 : 0;

        $config = [];
        if ($type === 'hero') {
            $backgroundImage = $_POST['currentBackgroundImage'] ?? '';

            if (isset($_FILES['backgroundImage_file']) && $_FILES['backgroundImage_file']['error'] === UPLOAD_ERR_OK) {
                require_once __DIR__ . '/../../backend/core/functions.php';
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $mediaId = handleUpload($_FILES['backgroundImage_file'], $uploadDir);
                if ($mediaId) {
                    require_once __DIR__ . '/../../backend/models/Media.php';
                    $mediaModel = new Media();
                    $media = $mediaModel->getById($mediaId);
                    if ($media) {
                        $backgroundImage = $media['file_path'];
                    }
                }
            }

            $config = [
                'title' => $_POST['title'] ?? '',
                'subtitle' => $_POST['subtitle'] ?? '',
                'backgroundImage' => $backgroundImage,
                'textColor' => $_POST['textColor'] ?? '#ffffff'
            ];

            if (!empty($_POST['buttonText'])) {
                $config['buttonText'] = $_POST['buttonText'];
                $config['buttonLink'] = $_POST['buttonLink'] ?? '#';
                $config['buttonColor'] = $_POST['buttonColor'] ?? '#0d6efd';
                $config['buttonTextColor'] = $_POST['buttonTextColor'] ?? '#ffffff';
            }
        }

        $data = [
            'type' => $type,
            'enabled' => $enabled,
            'config' => $config
        ];

        if ($id) {
            if ($sectionModel->update($id, $data)) {
                $message = "Section updated successfully.";
            } else {
                $error = "Failed to update section.";
            }
        } else {
            if ($sectionModel->create($data)) {
                $message = "Section created successfully.";
            } else {
                $error = "Failed to create section.";
            }
        }
    }
}

$sections = $sectionModel->getAll();

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Sections Management</h2>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#sectionFormModal" onclick="resetForm()">
        + Add New Section
    </button>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div id="sections-list-container">
    <?php if (empty($sections)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h5 class="text-muted mb-3">No sections found</h5>
                <p class="text-muted mb-0">You haven't created any homepage sections yet.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="list-group shadow-sm">
            <?php foreach ($sections as $section):
                $config = json_decode($section['config'], true);
                $badgeClass = $section['enabled'] ? "bg-success" : "bg-secondary";
                $badgeText = $section['enabled'] ? "Active" : "Inactive";
                $title = !empty($config['title']) ? $config['title'] : strtoupper($section['type']);
            ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h6 class="mb-1"><?= htmlspecialchars($title) ?> <span class="badge <?= $badgeClass ?> ms-2"><?= $badgeText ?></span></h6>
                        <small class="text-muted">Type: <?= htmlspecialchars($section['type']) ?> | Position: <?= htmlspecialchars($section['position']) ?></small>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary" onclick='editSection(<?= htmlspecialchars(json_encode($section), ENT_QUOTES, "UTF-8") ?>)'>
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this section?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $section['id'] ?>">
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

<div class="modal fade" id="sectionFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionFormModalLabel">Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" id="section-id">
                    <input type="hidden" name="type" id="hidden-section-type">

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" id="section-type" onchange="document.getElementById('hidden-section-type').value = this.value; showFormTemplate(this.value)" required>
                            <option value="" disabled selected>Select a type...</option>
                            <option value="hero">Hero (Banner principal)</option>
                        </select>
                    </div>

                    <div id="section-form-container">
                        <?php require_once __DIR__ . '/components/sections/hero_form.php'; ?>
                    </div>

                    <hr>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="section-enabled" name="enabled" checked>
                        <label class="form-check-label" for="section-enabled">Enable Section</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showFormTemplate(type) {
        document.querySelectorAll('.section-form-template').forEach(el => el.classList.add('d-none'));
        if (type) {
            const template = document.querySelector(`.section-form-template[data-type="${type}"]`);
            if (template) template.classList.remove('d-none');
        }
    }

    function resetForm() {
        document.getElementById('section-id').value = '';
        document.getElementById('section-type').value = '';
        document.getElementById('hidden-section-type').value = '';
        document.getElementById('section-type').disabled = false;
        document.getElementById('section-enabled').checked = true;
        showFormTemplate('');

        document.getElementById('hero-title').value = '';
        document.getElementById('hero-subtitle').value = '';
        document.getElementById('hero-bg-image-file').value = '';
        document.getElementById('hero-current-bg-image').value = '';
        document.getElementById('hero-bg-image-preview').classList.add('d-none');
        document.getElementById('hero-bg-image-preview').querySelector('img').src = '';
        document.getElementById('hero-text-color').value = '#ffffff';
        document.getElementById('hero-btn-text').value = '';
        document.getElementById('hero-btn-link').value = '';
        document.getElementById('hero-btn-color').value = '#0d6efd';
        document.getElementById('hero-btn-text-color').value = '#ffffff';
        document.getElementById('sectionFormModalLabel').innerText = 'Create New Section';
    }

    function editSection(section) {
        document.getElementById('section-id').value = section.id;
        document.getElementById('section-type').value = section.type;
        document.getElementById('hidden-section-type').value = section.type;
        document.getElementById('section-type').disabled = true;
        document.getElementById('section-enabled').checked = section.enabled == 1;

        showFormTemplate(section.type);

        if (section.type === 'hero' && section.config) {
            let config = typeof section.config === 'string' ? JSON.parse(section.config) : section.config;
            document.getElementById('hero-title').value = config.title || '';
            document.getElementById('hero-subtitle').value = config.subtitle || '';
            document.getElementById('hero-bg-image-file').value = '';
            document.getElementById('hero-current-bg-image').value = config.backgroundImage || '';
            if (config.backgroundImage) {
                document.getElementById('hero-bg-image-preview').classList.remove('d-none');
                document.getElementById('hero-bg-image-preview').querySelector('img').src = '<?= rtrim(baseUrl(), '/') ?>/' + config.backgroundImage;
            } else {
                document.getElementById('hero-bg-image-preview').classList.add('d-none');
            }
            document.getElementById('hero-text-color').value = config.textColor || '#ffffff';
            document.getElementById('hero-btn-text').value = config.buttonText || '';
            document.getElementById('hero-btn-link').value = config.buttonLink || '';
            document.getElementById('hero-btn-color').value = config.buttonColor || '#0d6efd';
            document.getElementById('hero-btn-text-color').value = config.buttonTextColor || '#ffffff';
        }

        document.getElementById('sectionFormModalLabel').innerText = 'Edit Section';
        var myModal = new bootstrap.Modal(document.getElementById('sectionFormModal'));
        myModal.show();
    }
</script>

<?php
$title   = 'Sections Management';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>