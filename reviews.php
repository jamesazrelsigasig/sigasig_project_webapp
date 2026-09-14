<?php
require __DIR__ . '/Database/auth.php';
require __DIR__ . '/Database/config.php';
$status = (string) ($_GET['status'] ?? '');
$statusMessage = [
  'review_success' => 'Thanks. Your review has been submitted and is awaiting approval.',
  'success' => 'Thanks. Your review has been submitted and is awaiting approval.',
  'invalid' => 'Please check the form and try again.',
  'invalid_message' => 'Please write a longer review message.',
  'invalid_rating' => 'Please choose a valid star rating.',
  'error' => 'We could not save your review right now. Please try again.'
][$status] ?? '';
$publicReviews = $conn->query('SELECT name, rating, session_type, message FROM reviews WHERE is_approved = 1 ORDER BY created_at DESC LIMIT 12')->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Client reviews for JIMS Photography">
    <title>Reviews - JIMS Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body class="page-reviews">
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="index.php">
                <img src="assets/site/Logo Black.png" alt="JIMS Photography" style="height: 58px; width: auto;">
            </a>
            <nav class="nav-links">
                <a href="services.php">Services</a>
                <a href="process.php">Process</a>
                <a href="portfolio.php">Portfolio</a>
                <a class="active" href="reviews.php">Reviews</a>
                <a href="contact.php">Contact</a>
                <?= authNavigation() ?>
                <a class="btn" href="booking.php">Book Now</a>
            </nav>
            <button class="hamb" type="button" aria-label="Open navigation" aria-expanded="false">&#9776;</button>
        </div>
    </header>

    <section class="page-hero">
        <div class="container">
            <div class="eyebrow yellow">What clients are saying</div>
            <h1>Real people. Real moments.</h1>
            <p>Every session is different, but the best ones leave people feeling seen, relaxed, and proud of what we
                created together.</p>
            <a class="btn" href="booking.php">Book a Session</a>
        </div>
    </section>

    <main>
        <section class="section">
            <div class="container contact-grid">
                <div class="contact-card">
                    <h2>Leave a review</h2>
                    <form action="Database/review-submit.php" method="POST" class="contact-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="form-grid">
                            <div class="field">
                                <label for="review-name">Name</label>
                                <input id="review-name" name="name" required>
                            </div>
                            <div class="field">
                                <label for="review-rating">Rating</label>
                                <select id="review-rating" name="rating" required>
                                    <option value="">Choose a rating</option>
                                    <option value="5">5 stars</option>
                                    <option value="4">4 stars</option>
                                    <option value="3">3 stars</option>
                                    <option value="2">2 stars</option>
                                    <option value="1">1 star</option>
                                </select>
                            </div>
                            <div class="field full">
                                <label for="review-session">Session type</label>
                                <select id="review-session" name="session_type" required>
                                    <option value="">Choose a session type</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Portrait">Portrait</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="field full">
                                <label for="review-message">Your review</label>
                                <textarea id="review-message" name="message" placeholder="Tell us about your experience..." required></textarea>
                            </div>
                        </div>
                        <button class="btn mt-18" type="submit">Submit review</button>
                        <?php if ($statusMessage !== ''): ?>
                            <p class="form-status<?= $status === 'review_success' || $status === 'success' ? '' : ' is-error' ?>">
                                <?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?>
                            </p><?php endif; ?>
                    </form>
                </div>
                <div>
                    <div class="eyebrow teal">Client feedback</div>
                    <h2 class="section-title">Every session is shaped around real moments.</h2>
                    <div class="notice">Your review is saved and then approved before it appears publicly on the site.</div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="reviews-grid" aria-live="polite">
                    <?php if ($publicReviews): ?>
                        <?php foreach ($publicReviews as $review): ?>
                            <article class="review">
                                <div class="review-stars"><?= str_repeat('★', (int) $review['rating']) ?></div>
                                <p>&quot;<?= htmlspecialchars($review['message'], ENT_QUOTES, 'UTF-8') ?>&quot;</p>
                                <strong><?= htmlspecialchars($review['name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                                <small><?= htmlspecialchars($review['session_type'], ENT_QUOTES, 'UTF-8') ?></small>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;Jim made our wedding day feel effortless. We forgot he was even there until we saw the
                                gallery.&quot;</p>
                            <strong>Ana &amp; Miguel</strong><br><small>Wedding</small>
                        </article>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;Fast turnaround, zero awkwardness, and the photos actually look like us.&quot;</p>
                            <strong>Carla D.</strong><br><small>Portrait Session</small>
                        </article>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;Professional, punctual, and the brand shoot completely elevated our shop's
                                socials.&quot;</p>
                            <strong>Reo's Coffee Co.</strong><br><small>Commercial</small>
                        </article>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;The session felt relaxed from the first minute. The final gallery captured the energy
                                perfectly.&quot;</p>
                            <strong>Mia &amp; Theo</strong><br><small>Engagement Session</small>
                        </article>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;Clear communication, beautiful light, and a gallery we are excited to share with
                                everyone.&quot;</p>
                            <strong>Northbay Events</strong><br><small>Event Coverage</small>
                        </article>
                        <article class="review">
                            <div class="review-stars">★★★★★</div>
                            <p>&quot;Jims understood the look we wanted and delivered images that felt unmistakably like our
                                brand.&quot;</p>
                            <strong>Studio One</strong><br><small>Brand Session</small>
                        </article>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="container">
                <h2>Ready to make your own story?</h2>
                <p>Tell me what you are planning and we can shape the right session together.</p>
                <a class="btn light" href="mailto:jimsphotography@gmail.com?subject=Photography%20enquiry">Start an
                    enquiry</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="brand" href="index.php">
                        <img src="assets/site/Logo White.png" alt="JIMS Photography"
                            style="height: 150px; width: auto;">
                    </a>
                    <p>Freelance photography, based in Dumaguete - available worldwide.</p>
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
                        <a href="index.php#top">Back to home</a>
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
                <span>&copy; 2026 JIMS Photography. All rights reserved.</span>
                <div class="socials"><span>IG</span><span>FB</span><span>PIN</span></div>
            </div>
        </div>
    </footer>
    <?= renderStatusModal() ?>
    <script src="script.js?v=20260913"></script>
</body>

</html>