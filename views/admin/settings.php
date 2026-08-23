<?php ob_start(); ?>

<div class="">
    <h2 class="mb-4">Settings</h2>

    <div id="settings-alert" class="d-none"></div>

    <form id="settings-form" class="row g-3" style="max-width: 680px;">

        <div class="col-12">
            <label for="site_name" class="form-label fw-semibold">Site Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="site_name" name="site_name" required>
        </div>

        <div class="col-12">
            <label for="site_description" class="form-label fw-semibold">Site Description</label>
            <textarea class="form-control" id="site_description" name="site_description" rows="3"></textarea>
        </div>

        <div class="col-md-6">
            <label for="logo_image" class="form-label fw-semibold">Logo Image</label>
            <input type="file" class="form-control" id="logo_image" accept="image/*">
            <input type="hidden" id="logo_media_id" name="logo_media_id">
        </div>

        <div class="col-md-6">
            <label for="favicon_image" class="form-label fw-semibold">Favicon Image</label>
            <input type="file" class="form-control" id="favicon_image" accept="image/*">
            <input type="hidden" id="favicon_media_id" name="favicon_media_id">
        </div>

        <div class="col-md-6">
            <label for="contact_email" class="form-label fw-semibold">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email">
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label fw-semibold">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>

        <div class="col-md-4">
            <label for="instagram" class="form-label fw-semibold">Instagram URL</label>
            <input type="text" class="form-control" id="instagram" name="instagram">
        </div>

        <div class="col-md-4">
            <label for="facebook" class="form-label fw-semibold">Facebook URL</label>
            <input type="text" class="form-control" id="facebook" name="facebook">
        </div>

        <div class="col-md-4">
            <label for="linkedin" class="form-label fw-semibold">LinkedIn URL</label>
            <input type="text" class="form-control" id="linkedin" name="linkedin">
        </div>

        <div class="col-12">
            <button type="submit" id="settings-submit-btn" class="btn btn-primary">Save Settings</button>
        </div>

    </form>
</div>

<?php
$title   = 'Settings';
$script  = 'pages/admin/settings.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>