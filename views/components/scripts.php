<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script type="module" src="<?php echo baseUrl('assets/js/components/header.js'); ?>"></script>
<?php if (!empty($script)): ?>
    <script type="module" src="<?php echo baseUrl("assets/js/{$script}"); ?>"></script>
<?php endif; ?>