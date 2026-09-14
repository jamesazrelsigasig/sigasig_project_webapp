<?php
declare(strict_types=1);
require __DIR__ . '/Database/auth.php';
$status = (string) ($_GET['status'] ?? '');
$sessionOptions = ['Portraits', 'Weddings & Events', 'Brand & Commercial'];
$selectedSession = in_array($_GET['session'] ?? '', $sessionOptions, true) ? (string) $_GET['session'] : '';
$statusToken = (string) ($_GET['token'] ?? '');
$statusMessage = [
  'booking_success' => 'Thanks. Your booking request has been received.',
  'invalid' => 'Please check the form and try again.',
  'invalid_phone' => 'Please enter a valid phone number.',
  'invalid_service' => 'Please choose a valid session type.',
  'invalid_payment_method' => 'Please choose a valid payment method.',
  'invalid_payment_plan' => 'Please choose whether you want to pay in full or partially.',
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
  <link rel="stylesheet" href="styles.css?v=20260914">
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
                <input id="booking-phone" name="phone" type="tel" inputmode="numeric" pattern="[0-9]{1,11}"
                  maxlength="11">
              </div>
              <div class="field">
                <label for="booking-session">Session</label>
                <select id="booking-session" name="session" required>
                  <option value="">Choose a session</option>
                  <?php foreach ($sessionOptions as $sessionOption): ?>
                    <option value="<?= htmlspecialchars($sessionOption, ENT_QUOTES, 'UTF-8') ?>"
                      <?= $selectedSession === $sessionOption ? ' selected' : '' ?>>
                      <?= htmlspecialchars($sessionOption, ENT_QUOTES, 'UTF-8') ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="notice payment-summary full" id="payment-summary" hidden>
                <strong>Payment details</strong>
                <div class="payment-summary-copy">
                  <span id="payment-session"></span>
                  <span id="payment-amount"></span>
                  <span id="payment-choice">No payment preference selected.</span>
                </div>
                <div class="payment-summary-actions">
                  <button class="btn payment-edit" id="open-payment" type="button">Choose payment</button>
                </div>
                <small>No payment is collected until your date is confirmed.</small>
              </div>
              <div class="field full">
                <label for="booking-date">Preferred date</label>
                <input id="booking-date" name="date" type="date" min="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="field full">
                <div class="payment-dialog" id="payment-dialog" role="dialog" aria-modal="true"
                  aria-labelledby="payment-dialog-title" hidden>
                  <div class="payment-dialog-card">
                    <button class="success-modal-close" id="close-payment" type="button"
                      aria-label="Close payment options">&times;</button>
                    <div class="eyebrow teal">Payment preference</div>
                    <h2 id="payment-dialog-title">Choose how you want to pay.</h2>
                    <p>Select full or partial payment and your preferred method. The final price will be confirmed
                      before payment.</p>
                    <div class="field">
                      <label for="booking-payment-plan">Payment amount</label>
                      <select id="booking-payment-plan" name="payment_plan" required>
                        <option value="">Choose a payment preference</option>
                        <option value="full">Pay in full</option>
                        <option value="partial">Pay partially</option>
                      </select>
                    </div>
                    <div class="field">
                      <label for="booking-payment-method">Payment method</label>
                      <select id="booking-payment-method" name="payment_method" required>
                        <option value="">Choose a payment method</option>
                        <option value="gcash">GCash</option>
                        <option value="bank_transfer">Bank transfer</option>
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                      </select>
                    </div>
                    <div class="payment-instructions" id="payment-instructions" hidden aria-live="polite"></div>
                    <div class="payment-dialog-actions">
                      <button class="btn btn-secondary" id="cancel-payment" type="button">Cancel</button>
                      <button class="btn" id="save-payment" type="button">Save payment choice</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="field full">
                <label for="booking-message">Tell me about it</label>
                <textarea id="booking-message" name="message"
                  placeholder="Your idea, location, vibe, and any details that matter." required></textarea>
              </div>
            </div>
            <div class="booking-actions">
              <button class="btn mt-18" id="booking-submit" type="submit">Book Now</button>
            </div>
            <?php if ($statusMessage !== ''): ?>
              <p class="form-status<?= $status === 'booking_success' ? '' : ' is-error' ?>">
                <?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
            <?php if ($status === 'booking_success' && preg_match('/^[a-f0-9]{64}$/', $statusToken)): ?>
              <p class="form-status booking-status-link"><a
                  href="booking-status.php?token=<?= htmlspecialchars($statusToken, ENT_QUOTES, 'UTF-8') ?>">Check your
                  booking status</a></p><?php endif; ?>
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
          <div class="notice">Your request is saved securely. Jims will confirm the date before anything is finalized.
          </div>
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
  <script src="script.js?v=20260914"></script>
</body>

</html>