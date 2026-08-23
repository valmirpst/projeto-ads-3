<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Sections Management</h2>
    <button class="btn btn-primary shadow-sm" disabled>
        + Add New Section
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body text-center py-5">
        <h5 class="text-muted mb-3">No sections found</h5>
        <p class="text-muted mb-0">You haven't created any homepage sections yet. (Feature in development)</p>
    </div>
</div>

<?php
$title   = 'Sections Management';
$script  = 'pages/admin/sections.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/admin.php';
?>