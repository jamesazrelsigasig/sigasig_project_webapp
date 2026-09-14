<?php
declare(strict_types=1);
require __DIR__ . '/Database/auth.php';
$user = authUser();
$status = (string) ($_GET['status'] ?? '');
$statusMessage = [
  'invalid' => 'Please enter a valid name and email address.',
  'password' => 'Passwords must match and contain 8 to 255 characters.',
  'exists' => 'An account with that email already exists.',
  'error' => 'We could not create your account right now. Please try again.'
][$status] ?? '';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register · JIMS Photography</title>
  <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body class="auth-page">
  <header class="site-header">
    <div class="container nav">
      <a class="brand" href="index.php"><img src="assets/site/Logo Black.png" alt="JIMS Photography"
          style="height: 58px; width: auto;"></a>
      <nav class="nav-links">
        <a href="services.php">Services</a><a href="process.php">Process</a><a href="portfolio.php">Portfolio</a><a
          href="reviews.php">Reviews</a><a href="contact.php">Contact</a>
        <?php if ($user): ?><a class="auth-button outline" href="logout.php">Log out</a><?php else: ?><a
            class="auth-button outline" href="login.php">Log in</a><?php endif; ?>
        <a class="btn" href="booking.php">Book Now</a>
      </nav>
      <button class="hamb" type="button" aria-label="Open navigation">☰</button>
    </div>
  </header>
  <main>
    <section class="auth-section section">
      <div class="auth-card contact-card">
        <div class="eyebrow teal">Create an account</div>
        <h1 class="section-title">Register with JIMS.</h1>
        <p class="section-copy">Create an account to keep your photography enquiries connected.</p>
        <form class="auth-form" action="Database/register-submit.php" method="POST">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
          <div class="field"><label for="register-name">Name</label><input id="register-name" name="name" type="text"
              autocomplete="name" required></div>
          <div class="field"><label for="register-email">Email</label><input id="register-email" name="email"
              type="email" autocomplete="email" required></div>
          <div class="field"><label for="register-password">Password</label><input id="register-password"
              name="password" type="password" minlength="8" autocomplete="new-password" required><small>Use at least 8
              characters.</small></div>
          <div class="field"><label for="register-confirm">Confirm password</label><input id="register-confirm"
              name="password_confirm" type="password" minlength="8" autocomplete="new-password" required></div>
          <button class="btn mt-18" type="submit">Create account</button>
          <?php if ($statusMessage !== ''): ?>
            <p class="form-status is-error"><?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?></p>
          
          <?php endif; ?>
        </form>
        <p class="auth-switch">Already registered? <a href="login.php">Log in</a></p>
      </div>
    </section>
  </main>
  <?= renderStatusModal() ?>
  <script src="script.js?v=20260913"></script>
</body>

</html>