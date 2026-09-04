<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Dashboard</h2>
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

<script type="module" src="<?php echo baseUrl('assets/js/pages/admin/dashboard.js'); ?>"></script>

<?php
$title   = 'Dashboard';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>