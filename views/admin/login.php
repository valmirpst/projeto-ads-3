<?php ob_start(); ?>

<h1>Login</h1>

<form id="login-form">
    <input type="email" id="email" placeholder="E-mail" required>
    <input type="password" id="password" placeholder="Senha" required>
    <p id="error-msg" style="display:none; color:red;"></p>
    <button type="submit">Entrar</button>
</form>

<?php
$title   = 'Login';
$script  = 'pages/admin/login.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>