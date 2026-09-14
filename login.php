<?php
declare(strict_types=1);
require __DIR__ . '/Database/auth.php';
$user = authUser();
$status = (string) ($_GET['status'] ?? '');
$statusMessage = [
    'invalid' => 'Please enter a valid email and password.',
    'credentials' => 'The email or password is incorrect.',
    'admin_login' => 'Please log in with an administrator account.'
][$status] ?? '';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Log in · JIMS Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body class="auth-page">
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="index.php"><img src="assets/site/Logo Black.png" alt="JIMS Photography"
                    style="height: 58px; width: auto;"></a>
            <nav class="nav-links">
                <a href="services.php">Services</a><a href="process.php">Process</a><a
                    href="portfolio.php">Portfolio</a><a href="reviews.php">Reviews</a><a href="contact.php">Contact</a>
                <?php if ($user): ?><a class="auth-button outline" href="logout.php">Log out</a><?php else: ?><a
                        class="auth-button" href="register.php">Register</a><?php endif; ?>
                <a class="btn" href="booking.php">Book Now</a>
            </nav>
            <button class="hamb" type="button" aria-label="Open navigation">☰</button>
        </div>
    </header>
    <main>
        <section class="auth-section section">
            <div class="auth-card contact-card">
                <div class="eyebrow orange">Welcome back</div>
                <h1 class="section-title">Log in to JIMS.</h1>
                <p class="section-copy">Access your account and keep your enquiries in one place.</p>
                <form class="auth-form" action="Database/login-submit.php" method="POST">
                    <input type="hidden" name="csrf_token"
                        value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="field"><label for="login-email">Email</label><input id="login-email" name="email"
                            type="email" autocomplete="email" required></div>
                    <div class="field"><label for="login-password">Password</label><input id="login-password"
                            name="password" type="password" autocomplete="current-password" required></div>
                    <button class="btn mt-18" type="submit">Log in</button>
                    <?php if ($statusMessage !== ''): ?>
                        <p class="form-status is-error">
                            <?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?>
                        </p><?php endif; ?>
                </form>
                <p class="auth-switch">No account yet? <a href="register.php">Register</a></p>
            </div>
        </section>
    </main>
    <?= renderStatusModal() ?>
    <script src="script.js?v=20260913"></script>
</body>

</html>