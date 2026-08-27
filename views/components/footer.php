    <footer class="bg-light py-5 mt-auto border-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-md-6 text-center text-md-start">
            <h5 class="fw-bold text-dark mb-2"><?php echo htmlspecialchars($globalSettings['site_name'] ?? 'CMS'); ?></h5>
            <p class="text-muted small mb-3">&copy; <?php echo date('Y'); ?> All rights reserved.</p>

            <?php if (!empty($globalSettings['instagram']) || !empty($globalSettings['facebook']) || !empty($globalSettings['linkedin'])): ?>
              <div class="d-flex justify-content-center justify-content-md-start gap-3">
                <?php if (!empty($globalSettings['instagram'])): ?>
                  <a href="<?php echo htmlspecialchars($globalSettings['instagram']); ?>" target="_blank" class="link-secondary fs-5"><i class="bi bi-instagram"></i></a>
                <?php endif; ?>
                <?php if (!empty($globalSettings['facebook'])): ?>
                  <a href="<?php echo htmlspecialchars($globalSettings['facebook']); ?>" target="_blank" class="link-secondary fs-5"><i class="bi bi-facebook"></i></a>
                <?php endif; ?>
                <?php if (!empty($globalSettings['linkedin'])): ?>
                  <a href="<?php echo htmlspecialchars($globalSettings['linkedin']); ?>" target="_blank" class="link-secondary fs-5"><i class="bi bi-linkedin"></i></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>

          <div class="col-md-6 text-center text-md-end">
            <?php if (!empty($globalSettings['contact_email']) || !empty($globalSettings['phone'])): ?>
              <div class="mb-3 d-flex flex-column align-items-center align-items-md-end">
                <?php if (!empty($globalSettings['contact_email'])): ?>
                  <a href="mailto:<?php echo htmlspecialchars($globalSettings['contact_email']); ?>" class="link-secondary text-decoration-none small mb-1"><i class="bi bi-envelope me-1"></i> <?php echo htmlspecialchars($globalSettings['contact_email']); ?></a>
                <?php endif; ?>
                <?php if (!empty($globalSettings['phone'])): ?>
                  <a href="tel:<?php echo htmlspecialchars($globalSettings['phone']); ?>" class="link-secondary text-decoration-none small"><i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($globalSettings['phone']); ?></a>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <ul class="list-inline mb-0 mt-3">
              <?php if (!empty($is_admin_layout)): ?>
                <li class="list-inline-item"><a class="link-secondary text-decoration-none" href="<?php echo baseUrl(); ?>">View Site</a></li>
              <?php else: ?>
                <li class="list-inline-item"><a class="link-secondary text-decoration-none" href="<?php echo baseUrl(''); ?>">Home</a></li>
                <li class="list-inline-item px-2"><a class="link-secondary text-decoration-none" href="<?php echo baseUrl('blog'); ?>">Blog</a></li>
                <li class="list-inline-item ms-2 border-start ps-3"><a class="link-secondary text-decoration-none" href="<?php echo baseUrl('admin'); ?>">Admin Panel</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </footer>