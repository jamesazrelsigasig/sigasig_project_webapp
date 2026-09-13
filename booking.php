<?php
declare(strict_types=1);
require __DIR__ . '/Database/auth.php';
$status = (string) ($_GET['status'] ?? '');
$statusMessage = [
    'success' => 'Thanks. Your date request has been received.',
    'invalid' => 'Please check the form and try again.',
    'invalid_phone' => 'Please enter a valid phone number.',
    'invalid_service' => 'Please choose a valid session type.',
    'invalid_date' => 'Please choose a future date.',
    'invalid_date_taken' => 'That date is already requested. Please choose another date.',
    'error' => 'We could not save your booking request right now. Please try again.'
][$status] ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Book a Session · JIMS Photography</title>
  <link rel="stylesheet" href="styles.css?v=20260908">
</head>
<body class="page-contact">
  <header class="site-header">
    <div class="container nav">
      <a class="brand" href="index.php">
        <img src="assets/site/Logo Black.png" alt="JIMS Photography" style="height: 58px; width: auto;">
      </a>
      <nav class="nav-links">
        <a href="services.php">Services</a>
        <a href="process.php">Process</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="reviews.php">Reviews</a>
        <a href="contact.php">Contact</a>
        <?= authNavigation() ?>
        <a class="btn" href="booking.php">Book Now</a>
      </nav>
      <button class="hamb" type="button" aria-label="Open navigation">☰</button>
    </div>
  </header>

  <section class="page-hero">
    <div class="container">
      <div class="eyebrow orange">Book a session</div>
      <h1>Choose a date and make it real.</h1>
      <p>Send the details and Jims will confirm availability with you.</p>
    </div>
  </section>

  <main>
    <section class="section">
      <div class="container contact-grid">
        <div class="contact-card">
          <h2>Start with your date.</h2>
          <form action="Database/booking-submit.php" method="POST" class="booking-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-grid">
              <div class="field">
                <label for="booking-name">Name</label>
                <input id="booking-name" name="name" required>
              </div>
              <div class="field">
                <label for="booking-email">Email</label>
                <input id="booking-email" name="email" type="email" required>
              </div>
              <div class="field">
                <label for="booking-phone">Phone</label>
                <input id="booking-phone" name="phone" type="tel" inputmode="numeric" pattern="[0-9]{1,11}" maxlength="11">
              </div>
              <div class="field">
                <label for="booking-session">Session</label>
                <select id="booking-session" name="session" required>
                  <option value="">Choose a session</option>
                  <option>Portraits</option>
                  <option>Weddings &amp; Events</option>
                  <option>Brand &amp; Commercial</option>
                </select>
              </div>
              <div class="field full">
                <label for="booking-date">Preferred date</label>
                <input id="booking-date" name="date" type="date" min="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="field full">
                <label for="booking-message">Tell me about it</label>
                <textarea id="booking-message" name="message" placeholder="Your idea, location, vibe, and any details that matter." required></textarea>
              </div>
            </div>
            <button class="btn mt-18" type="submit">Request This Date</button>
            <?php if ($statusMessage !== ''): ?><p class="form-status<?= $status === 'success' ? '' : ' is-error' ?>"><?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
          </form>
        </div>
        <div>
          <div class="eyebrow teal">Good to know</div>
          <h2 class="section-title">Relaxed, clear, and built around your story.</h2>
          <div class="info-list">
            <div class="info-item"><span>Response time</span><strong>Usually within one business day</strong></div>
            <div class="info-item"><span>Location</span><strong>Dumaguete City, Philippines</strong></div>
            <div class="info-item"><span>Availability</span><strong>Now booking</strong></div>
          </div>
          <div class="notice">Your request is saved securely. Jims will confirm the date before anything is finalized.</div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <span>&copy; 2026 JIMS Photography. All rights reserved.</span>
        <a href="index.php">Back to home</a>
      </div>
    </div>
  </footer>
  <?= renderStatusModal() ?>
  <script src="script.js?v=20260913"></script>
</body>
</html>
