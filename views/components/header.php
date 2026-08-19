<header class="navbar-light bg-light">
  <nav class="navbar container-sm">
    <a class="navbar-brand d-flex align-items-center gap-3" href="<?php echo baseUrl(''); ?>">
      <img id="header_logo-image" src="assets/images/no-image.jpg" width="36" height="36" class="d-inline-block align-top" alt="Site Logo">
      <span id="header_site-name" class="fs-4 lh-1">Loading...</span>
    </a>

    <div class="d-flex align-items-center gap-3">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
        <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo baseUrl(''); ?>">Home</a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link" href="<?php echo baseUrl('blog'); ?>">Blog</a>
        </li>
        <li class="nav-item ps-4 border-start">
          <!-- Login -->
          <?php if (isset($_SESSION['user_id'])): ?>
            <a class="nav-link" href="<?php echo baseUrl('admin'); ?>">Dashboard</a>
          <?php else: ?>
            <a class="nav-link" href="<?php echo baseUrl('admin/login'); ?>">Login</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </nav>
</header>

<script type="module" src="<?php echo baseUrl('assets/js/components/header.js'); ?>"></script>