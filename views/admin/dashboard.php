<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Dashboard</h2>
</div>

<div class="alert alert-primary border-0 shadow-sm mb-4" role="alert">
    Welcome to your CMS! Choose a task below to get started.
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body" id="analytics-container">
                <p class="text-muted mb-0">Carregando estatísticas...</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Card pra ir para as sectins -->
    <div class="col-md-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Sections Management</h5>
                <p class="card-text text-muted">Create and organize the content sections for your website's homepage.</p>
                <div class="mt-auto">
                    <a href="<?php echo baseUrl('admin/sections'); ?>" class="btn btn-primary">Manage Sections</a>
                </div>
            </div>
        </div>
    </div>

    <!-- card pra ir pras settings -->
    <div class="col-md-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Site Settings</h5>
                <p class="card-text text-muted">Update your site's identity, including name, logo, and social media links.</p>
                <div class="mt-auto">
                    <a href="<?php echo baseUrl('admin/settings'); ?>" class="btn btn-outline-secondary">Edit Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$title   = 'Dashboard';
$script  = 'pages/admin/dashboard.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>