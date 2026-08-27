<?php
require_once __DIR__ . '/../../backend/models/Setting.php';
$settingModel = new Setting();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentSettings = $settingModel->getSettings();
    $data = [
        'site_name' => $_POST['site_name'] ?? '',
        'site_description' => $_POST['site_description'] ?? '',
        'contact_email' => $_POST['contact_email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'instagram' => $_POST['instagram'] ?? '',
        'facebook' => $_POST['facebook'] ?? '',
        'linkedin' => $_POST['linkedin'] ?? '',
        'logo_media_id' => $currentSettings['logo_media_id'] ?? null,
        'favicon_media_id' => $currentSettings['favicon_media_id'] ?? null,
    ];

    $uploadDir = __DIR__ . '/../../public/uploads/';

    if (isset($_FILES['logo_image'])) {
        $mediaId = handleUpload($_FILES['logo_image'], $uploadDir);
        if ($mediaId) {
            $data['logo_media_id'] = $mediaId;
        }
    }

    if (isset($_FILES['favicon_image'])) {
        $mediaId = handleUpload($_FILES['favicon_image'], $uploadDir);
        if ($mediaId) {
            $data['favicon_media_id'] = $mediaId;
        }
    }

    if ($settingModel->updateSettings($data)) {
        $message = 'Settings updated successfully.';
    } else {
        $error = 'Failed to update settings.';
    }
}

$settings = $settingModel->getSettings();
ob_start();
?>

<div>
    <h2 class="mb-4">Settings</h2>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" class="row g-3" style="max-width: 680px;">
        <div class="col-12">
            <label for="site_name" class="form-label fw-semibold">Site Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="site_name" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
        </div>

        <div class="col-12">
            <label for="site_description" class="form-label fw-semibold">Site Description</label>
            <textarea class="form-control" id="site_description" name="site_description" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
        </div>

        <div class="col-md-6">
            <label for="logo_image" class="form-label fw-semibold">Logo Image</label>
            <input type="file" class="form-control" id="logo_image" name="logo_image" accept="image/*">
            <?php if (!empty($settings['logo_path'])): ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars(baseUrl($settings['logo_path'])) ?>" alt="Logo" style="height: 40px; object-fit: contain;">
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <label for="favicon_image" class="form-label fw-semibold">Favicon Image</label>
            <input type="file" class="form-control" id="favicon_image" name="favicon_image" accept="image/*">
            <?php if (!empty($settings['favicon_path'])): ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars(baseUrl($settings['favicon_path'])) ?>" alt="Favicon" style="height: 40px; object-fit: contain;">
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <label for="contact_email" class="form-label fw-semibold">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label fw-semibold">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="instagram" class="form-label fw-semibold">Instagram URL</label>
            <input type="text" class="form-control" id="instagram" name="instagram" value="<?= htmlspecialchars($settings['instagram'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="facebook" class="form-label fw-semibold">Facebook URL</label>
            <input type="text" class="form-control" id="facebook" name="facebook" value="<?= htmlspecialchars($settings['facebook'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label for="linkedin" class="form-label fw-semibold">LinkedIn URL</label>
            <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?= htmlspecialchars($settings['linkedin'] ?? '') ?>">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>

    </form>
</div>

<?php
$title   = 'Settings';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>