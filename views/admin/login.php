<?php ob_start(); ?>

<div class="card card shadow-sm m-auto w-100" style="max-width: 400px;">
    <div class="card-header bg-body py-3">
        <a href="<?php echo baseUrl(); ?>" class="link-secondary"></a>
        <h1 class="card-title h3">Login</h1>
        <p class="card-subtitle text-muted">Sign in to your account</p>
    </div>

    <div class="card-body">
        <form id="login-form" class="d-flex flex-column gap-3 py-2">
            <label for="email" class="d-flex flex-column gap-1">
                <span>Email</span>
                <input type="email" id="email" placeholder="Enter your email" required class="form-control">
            </label>
            <label for="password" class="d-flex flex-column gap-1">
                <span>Password</span>
                <input type="password" id="password" placeholder="Enter your password" required class="form-control">
            </label>
            <p id="error-msg" class="text-danger d-none"></p>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<?php
$title   = 'Login';
$script  = 'pages/admin/login.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>