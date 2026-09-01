    <footer class="bg-light py-5 mt-auto border-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-md-6 text-center text-md-start">
            <h5 class="fw-bold text-dark mb-2"><?php echo htmlspecialchars($globalSettings['site_name'] ?? 'CMS'); ?></h5>
            <?php if (!empty($globalSettings['site_description'])): ?>
              <p class="text-muted small mb-3"><?php echo htmlspecialchars($globalSettings['site_description']); ?></p>
            <?php endif; ?>
            <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> All rights reserved.</p>
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

            <?php if (!empty($globalSettings['instagram']) || !empty($globalSettings['facebook']) || !empty($globalSettings['linkedin'])): ?>
              <div class="d-flex justify-content-center justify-content-md-end gap-3 mt-3">
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
        </div>
      </div>
    </footer>