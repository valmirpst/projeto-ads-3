<header class="navbar-light bg-light">
  <nav class="navbar container-sm">
    <a class="navbar-brand d-flex align-items-center gap-3" href="<?php echo baseUrl(!empty($is_admin_layout) ? 'admin' : ''); ?>">
      <img id="header_logo-image" src="<?php echo baseUrl('assets/images/no-image.jpg'); ?>" style="width: auto; height: 36px; object-fit: contain;" class="d-inline-block align-top" alt="Site Logo">
      <span <?php echo empty($is_admin_layout) ? 'id="header_site-name"' : ''; ?> class="fs-4 lh-1">
        <?php echo !empty($is_admin_layout) ? 'Admin' : 'Loading...'; ?>
      </span>
    </a>

    <div class="d-flex align-items-center gap-3">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
        <?php if (!empty($is_admin_layout)): ?>
          <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin"); ?>">Dashboard</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin/sections"); ?>">Sections</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl("admin/settings"); ?>">Settings</a></li>
          <li class="nav-item ps-4 border-start"><a class="nav-link text-secondary" href="<?php echo baseUrl(); ?>">Back to Home</a></li>
          <li class="nav-item px-2"><a class="nav-link text-danger" href="<?php echo baseUrl("admin/logout"); ?>">Logout</a></li>
        <?php else: ?>
          <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl(''); ?>">Home</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="<?php echo baseUrl('blog'); ?>">Blog</a></li>
          <li class="nav-item ps-4 border-start">
            <?php if (isset($_SESSION['user_id'])): ?>
              <a class="nav-link" href="<?php echo baseUrl('admin'); ?>">Dashboard</a>
            <?php else: ?>
              <a class="nav-link" href="<?php echo baseUrl('admin/login'); ?>">Login</a>
            <?php endif; ?>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>