<?php
require_once __DIR__ . '/../../backend/models/Section.php';

$sectionModel = new Section();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $sectionModel->delete($id);
        $message = "Section deleted successfully.";
    } elseif ($action === 'save') {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $type = $_POST['type'] ?? '';
        $enabled = isset($_POST['enabled']) ? 1 : 0;

        // Build config array based on type
        $config = [];
        if ($type === 'hero') {
            $config = [
                'title' => $_POST['title'] ?? '',
                'subtitle' => $_POST['subtitle'] ?? '',
                'backgroundImage' => $_POST['backgroundImage'] ?? '',
                // Keep colors hardcoded or from old config for simplicity, as we simplified the form
                'textColor' => '#ffffff',
                'buttonColor' => '#0d6efd',
                'buttonTextColor' => '#ffffff'
            ];
        }

        $data = [
            'type' => $type,
            'enabled' => $enabled,
            'config' => $config
        ];

        if ($id) {
            $sectionModel->update($id, $data);
            $message = "Section updated successfully.";
        } else {
            $sectionModel->create($data);
            $message = "Section created successfully.";
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

<!-- Lista de sections  -->
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
                $badgeText = $section['enabled'] ? "Ativo" : "Inativo";
                $title = !empty($config['title']) ? $config['title'] : strtoupper($section['type']);
            ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h6 class="mb-1"><?= htmlspecialchars($title) ?> <span class="badge <?= $badgeClass ?> ms-2"><?= $badgeText ?></span></h6>
                        <small class="text-muted">Type: <?= htmlspecialchars($section['type']) ?> | Position: <?= htmlspecialchars($section['position']) ?></small>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary" onclick='editSection(<?= json_encode($section) ?>)'>
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

<!-- Formulário (Criação e Edição) -->
<div class="modal fade" id="sectionFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionFormModalLabel">Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" id="section-id">

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" id="section-type" onchange="showFormTemplate(this.value)" required>
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
                        <label class="form-check-label" for="section-enabled">Ativar Seção</label>
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
        document.getElementById('section-type').disabled = false;
        document.getElementById('section-enabled').checked = true;
        showFormTemplate('');

        // Clear inputs in hero form
        document.getElementById('hero-title').value = '';
        document.getElementById('hero-subtitle').value = '';
        document.getElementById('hero-bg-image').value = '';
        document.getElementById('sectionFormModalLabel').innerText = 'Create New Section';
    }

    function editSection(section) {
        document.getElementById('section-id').value = section.id;
        document.getElementById('section-type').value = section.type;

        // Disable type selection when editing
        const typeSelect = document.getElementById('section-type');
        typeSelect.disabled = true;
        // Create a hidden input to submit the type value since disabled selects don't submit
        let hiddenType = document.getElementById('hidden-section-type');
        if (!hiddenType) {
            hiddenType = document.createElement('input');
            hiddenType.type = 'hidden';
            hiddenType.id = 'hidden-section-type';
            hiddenType.name = 'type';
            typeSelect.parentNode.appendChild(hiddenType);
        }
        hiddenType.value = section.type;

        document.getElementById('section-enabled').checked = section.enabled == 1;

        showFormTemplate(section.type);

        if (section.type === 'hero' && section.config) {
            let config = typeof section.config === 'string' ? JSON.parse(section.config) : section.config;
            document.getElementById('hero-title').value = config.title || '';
            document.getElementById('hero-subtitle').value = config.subtitle || '';
            document.getElementById('hero-bg-image').value = config.backgroundImage || '';
        }

        document.getElementById('sectionFormModalLabel').innerText = 'Edit Section';
        var myModal = new bootstrap.Modal(document.getElementById('sectionFormModal'));
        myModal.show();
    }
</script>

<?php
$title   = 'Sections Management';
// $script  = 'pages/admin/sections.js'; // REMOVED
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>