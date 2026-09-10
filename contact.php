<?php
declare(strict_types=1);
require __DIR__ . '/Database/auth.php';
$status = (string) ($_GET['status'] ?? '');
$statusMessage = [
  'success' => 'Thanks. Your enquiry has been received.',
  'invalid' => 'Please check the form and try again.',
  'invalid_phone' => 'Please enter a valid phone number.',
  'invalid_service' => 'Please choose a valid session type.',
  'error' => 'We could not save your enquiry right now. Please try again.'
][$status] ?? '';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Contact · JIMS Photography</title>
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
<a class="active" href="contact.php">Contact</a>
<?= authNavigation() ?>
<a class="btn" href="booking.php">Book Now</a>
</nav>
<button class="hamb">☰</button>
</div>
</header>
<section class="page-hero">
  <div class="container">
  <div class="eyebrow orange">Contact</div>
<h1>Let’s make something worth remembering.</h1>
<p>Tell me what you have in mind - I’ll take it from there.</p>
</div>
</section>
<section class="section">
  <div class="container contact-grid">
    <div class="contact-card">
    <h2>Start with a quick message.</h2>
    <form action="Database/contact-submit.php" method="POST" class="contact-form" data-form-purpose="inquiry">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
      <div class="form-grid">
        <div class="field">
        <label for="name">Name</label>
        <input id="name" name="name" required>
      </div>
      <div class="field">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" required>
    </div>
    <div class="field">
    <label for="phone">Phone</label>
    <input id="phone" name="phone" type="tel" inputmode="numeric" pattern="[0-9]{1,11}" maxlength="11">
  </div>
  <div class="field">
  <label for="type">Session</label>
  <select id="type" name="session">
  <option>Portraits</option>
<option>Weddings & Events</option>
<option>Brand & Commercial</option>
</select>
</div>
<div class="field full">
<label for="message">Tell me about it</label>
<textarea id="message" name="message" placeholder="Your idea, location, vibe, and any details that matter." required></textarea>
</div>
</div>
<button class="btn mt-18" type="submit">Send Enquiry</button>
<?php if ($statusMessage !== ''): ?><p class="form-status<?= $status === 'success' ? '' : ' is-error' ?>"><?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
</form>
</div>
<div>
<div class="eyebrow teal">Contact details</div>
<h2 class="section-title">Dumaguete based · travels worldwide.</h2>
<div class="info-list">
  <div class="info-item">
  <span>Email</span>
  <strong>
  <a href="mailto:jimsphotography@gmail.com">jimsphotography@gmail.com</a>
</strong>
</div>
<div class="info-item">
<span>Phone</span>
<strong>
<a href="tel:+639993736911">+63 999 373 6911</a>
</strong>
</div>
<div class="info-item">
<span>Location</span>
<strong>Dumaguete City, Philippines</strong>
</div>
<div class="info-item">
<span>Availability</span>
<strong>Now booking</strong>
</div>
</div>
<div class="notice">Your enquiry is saved securely and Jims will reply using the contact details you provide.</div>
</div>
</div>
</section>
<section class="cta">
  <div class="container">
<h2>Have a question?</h2>
<p>Send an enquiry and Jims will help you figure out the right next step.</p>
<a class="btn light" href="mailto:jimsphotography@gmail.com?subject=Photography%20Enquiry">Email Jims</a>
</div>
</section>
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a class="brand" href="index.php">
          <img src="assets/site/Logo White.png" alt="JIMS Photography" style="height: 150px; width: auto;">
        </a>
  <p>Freelance photography, based in Dumaguete · available worldwide.</p>
</div>
<div>
<h4>Explore</h4>
<div class="footer-links">
<a href="services.php">Services</a>
<a href="process.php">Process</a>
<a href="portfolio.php">Portfolio</a>
<a href="reviews.php">Reviews</a>
</div>
</div>
<div>
<h4>Studio</h4>
<div class="footer-links">
<a href="booking.php">Book a Session</a>
<a href="services.php#faq">FAQs</a>
<a href="contact.php">Contact</a>
</div>
</div>
<div>
<h4>Contact</h4>
<div class="footer-links">
<a href="mailto:jimsphotography@gmail.com">jimsphotography@gmail.com</a>
<a href="tel:+639993736911">+63 999 373 6911</a>
<span>Dumaguete City, Philippines</span>
</div>
</div>
</div>
<div class="footer-bottom">
<span>© 2026 JIMS Photography. All rights reserved.</span>
<div class="socials">
<span>IG</span>
<span>FB</span>
<span>PIN</span>
</div>
</div>
</div>
</footer>
<?= renderStatusModal() ?>
<script src="script.js?v=20260910"></script>
</body>
</html>
