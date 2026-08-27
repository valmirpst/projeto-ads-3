<?php
require_once __DIR__ . '/../../backend/models/User.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $user = $userModel->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: ' . baseUrl('admin'));
        exit;
    } else {
        $error = 'Email ou senha inválidos.';
    }
}

ob_start();
?>

<div class="card card shadow-sm m-auto w-100" style="max-width: 400px;">
    <div class="card-header bg-body py-3 border-bottom-0">
        <a href="<?php echo baseUrl(); ?>" class="link-secondary text-decoration-none small mb-2 d-inline-block">&larr; Back to Home</a>
        <h1 class="card-title h3 mt-1">Login</h1>
        <p class="card-subtitle text-muted">Sign in to your account</p>
    </div>

    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="" class="d-flex flex-column gap-3 py-2">
            <label for="email" class="d-flex flex-column gap-1">
                <span>Email</span>
                <input type="email" id="email" name="email" placeholder="Enter your email" required class="form-control">
            </label>
            <label for="password" class="d-flex flex-column gap-1">
                <span>Password</span>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="form-control">
            </label>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</div>

<?php
$title   = 'Login';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>