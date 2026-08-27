<header class="navbar-light bg-light">
  <nav class="navbar container-sm">
    <a class="navbar-brand d-flex align-items-center gap-3" href="<?php echo baseUrl(!empty($is_admin_layout) ? 'admin' : ''); ?>">
      <?php $logoUrl = !empty($globalSettings['logo_path']) ? baseUrl($globalSettings['logo_path']) : baseUrl('assets/images/no-image.jpg'); ?>
      <img src="<?php echo $logoUrl; ?>" style="width: auto; height: 36px; object-fit: contain;" class="d-inline-block align-top" alt="Site Logo">
      <span class="fs-4 lh-1">
        <?php echo !empty($is_admin_layout) ? 'Admin' : htmlspecialchars($globalSettings['site_name'] ?? 'CMS'); ?>
      </span>
    </a>

    <div class="d-flex align-items-center gap-3">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
        <?php if (!empty($is_admin_layout)): ?>
          <li class="nav-item px-1"><a class="nav-link" href="<?php echo baseUrl("admin"); ?>">Dashboard</a></li>
          <li class="nav-item px-1"><a class="nav-link" href="<?php echo baseUrl("admin/sections"); ?>">Sections</a></li>
          <li class="nav-item px-1"><a class="nav-link" href="<?php echo baseUrl("admin/settings"); ?>">Settings</a></li>
          <li class="nav-item ps-3 ms-2 border-start d-flex align-items-center">
            <a class="nav-link text-secondary" href="<?php echo baseUrl(); ?>">View Site</a>
          </li>
          <li class="nav-item px-2 d-flex align-items-center">
            <a class="btn btn-outline-danger btn-sm" href="<?php echo baseUrl("admin/logout"); ?>">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item px-1"><a class="nav-link" href="<?php echo baseUrl(''); ?>">Home</a></li>
          <li class="nav-item px-1"><a class="nav-link" href="<?php echo baseUrl('blog'); ?>">Blog</a></li>
          <li class="nav-item ps-3 ms-2 border-start d-flex align-items-center">
            <?php if (isset($_SESSION['user_id'])): ?>
              <a class="btn btn-outline-primary btn-sm" href="<?php echo baseUrl('admin'); ?>">Dashboard</a>
            <?php else: ?>
              <a class="btn btn-primary btn-sm" href="<?php echo baseUrl('admin/login'); ?>">Login</a>
            <?php endif; ?>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>