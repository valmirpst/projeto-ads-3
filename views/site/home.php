<?php ob_start(); ?>

<div class="site-settings">
    <h1 id="site-name">Loading...</h1>
    <p id="site-description"></p>

    <div class="site-contact" style="margin-top: 2rem;">
        <h3>Contact</h3>
        <ul>
            <li><strong>Email:</strong> <span id="contact-email">-</span></li>
            <li><strong>Phone:</strong> <span id="contact-phone">-</span></li>
        </ul>
    </div>

    <div class="site-socials" style="margin-top: 2rem;">
        <h3>Social Media</h3>
        <ul style="list-style: none; padding: 0; display: flex; gap: 1rem;">
            <li><a href="#" id="link-instagram" target="_blank" style="display:none;">Instagram</a></li>
            <li><a href="#" id="link-facebook" target="_blank" style="display:none;">Facebook</a></li>
            <li><a href="#" id="link-linkedin" target="_blank" style="display:none;">LinkedIn</a></li>
        </ul>
    </div>
</div>
<?php
$title   = 'Home';
$script  = 'pages/home.js';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/site.php';
?>