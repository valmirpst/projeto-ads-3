<?php
require_once __DIR__ . '/../../backend/models/Media.php';
require_once __DIR__ . '/../../backend/core/functions.php';

$mediaModel = new Media();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        $media = $mediaModel->getById($id);

        if ($media) {
            $filePath = __DIR__ . '/../../public/' . $media['file_path'];

            // Tenta deletar o arquivo físico se existir
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Deleta do banco
            if ($mediaModel->delete($id)) {
                $message = "Mídia excluída com sucesso.";
            } else {
                $error = "Erro ao excluir do banco de dados.";
            }
        } else {
            $error = "Mídia não encontrada.";
        }
    } elseif ($action === 'upload') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            $mediaId = handleUpload($_FILES['file'], $uploadDir);

            if ($mediaId) {
                $message = "Arquivo enviado com sucesso.";
            } else {
                $error = "Erro ao enviar o arquivo.";
            }
        } else {
            $error = "Nenhum arquivo selecionado ou erro no upload.";
        }
    }
}

$mediaItems = $mediaModel->getAll();

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Gerenciador de Mídia</h2>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
        <i class="bi bi-upload"></i> Fazer Upload
    </button>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div id="media-list-container">
    <?php if (empty($mediaItems)): ?>
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h5 class="text-muted mb-3">Nenhuma mídia encontrada</h5>
                <p class="text-muted mb-0">Você ainda não enviou nenhum arquivo.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
            <?php foreach ($mediaItems as $item):
                $fileUrl = baseUrl($item['file_path']);
                $isImage = strpos($item['file_type'], 'image/') === 0;
            ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 120px;">
                            <?php if ($isImage): ?>
                                <img src="<?= $fileUrl ?>" alt="<?= htmlspecialchars($item['file_name']) ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                            <?php else: ?>
                                <i class="bi bi-file-earmark fs-1 text-secondary"></i>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-2 d-flex flex-column">
                            <small class="card-title text-truncate mb-2" title="<?= htmlspecialchars($item['file_name']) ?>">
                                <?= htmlspecialchars($item['file_name']) ?>
                            </small>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Ver Arquivo">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta mídia?');" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload de Mídia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="upload">
                    <div class="mb-3">
                        <label for="file" class="form-label">Selecione o arquivo</label>
                        <input class="form-control" type="file" id="file" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Fazer Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$title   = 'Gerenciador de Mídia';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>