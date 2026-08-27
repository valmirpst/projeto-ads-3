    <footer class="bg-light py-4 mt-auto border-top">
      <div class="container-sm">
        <div class="row gy-3 align-items-center">
          <div class="col-md-6 text-center text-md-start">
            <p class="mb-1 text-muted">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($globalSettings['site_name'] ?? 'CMS'); ?></p>
            <small class="text-secondary">All rights reserved.</small>
          </div>
          <div class="col-md-6 text-center text-md-end">
            <ul class="list-inline mb-0">
              <?php if (!empty($is_admin_layout)): ?>
                <li class="list-inline-item"><a class="text-secondary text-decoration-none" href="<?php echo baseUrl(); ?>">View Site</a></li>
              <?php else: ?>
                <li class="list-inline-item"><a class="text-secondary text-decoration-none" href="<?php echo baseUrl(''); ?>">Home</a></li>
                <li class="list-inline-item px-2"><a class="text-secondary text-decoration-none" href="<?php echo baseUrl('blog'); ?>">Blog</a></li>
                <li class="list-inline-item ms-2 border-start ps-3"><a class="text-secondary text-decoration-none" href="<?php echo baseUrl('admin'); ?>">Admin Panel</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </footer>