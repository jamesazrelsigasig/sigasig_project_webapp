<!doctype html>
<html lang="en">

<head>
    <?php require __DIR__ . '/Database/auth.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Process · JIMS Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body class="page-process">
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="index.php">
                <img src="assets/site/Logo Black.png" alt="JIMS Photography" style="height: 58px; width: auto;">
            </a>
            <nav class="nav-links">
                <a href="services.php">Services</a>
                <a class="active" href="process.php">Process</a>
                <a href="portfolio.php">Portfolio</a>
                <a href="reviews.php">Reviews</a>
                <a href="contact.php">Contact</a>
                <?= authNavigation() ?>
                <a class="btn" href="booking.php">Book Now</a>
            </nav>
            <button class="hamb">☰</button>
        </div>
    </header>
    <section class="page-hero">
        <div class="container">
            <div class="eyebrow orange">Process</div>
            <h1>How a session comes together.</h1>
            <p>A simple four-step flow designed to keep things relaxed, clear, and focused on real moments.</p>
            <a class="btn" href="contact.php">Start an Enquiry</a>
        </div>
    </section>
    <section class="section dark">
        <div class="container">
            <div class="process-grid">
                <div class="process-step">
                    <div class="num">01</div>
                    <h3>Enquire</h3>
                    <p>Tell me your date, vision and vibe through a quick form.</p>
                </div>
                <div class="process-step">
                    <div class="num">02</div>
                    <h3>Plan</h3>
                    <p>We lock location, timing, moodboard and package.</p>
                </div>
                <div class="process-step">
                    <div class="num">03</div>
                    <h3>Shoot</h3>
                    <p>Relaxed and unscripted - real moments over stiff poses.</p>
                </div>
                <div class="process-step">
                    <div class="num">04</div>
                    <h3>Deliver</h3>
                    <p>Edited gallery delivered within 10 business days, ready to share.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section paper">
        <div class="container about">
            <img class="about-photo" src="assets/site/about.jpg" alt="Jims with a camera">
            <div>
                <div class="eyebrow teal">What the experience feels like</div>
                <h2 class="section-title">Good light. Good timing. Genuine moments.</h2>
                <p class="section-copy">The homepage mockup describes the approach as relaxed and unscripted, with no
                    forced smiles or rigid checklists. The process is built to let the photographer notice the moments
                    rather than over-pose them.</p>
                <p class="quote">My job isn’t to pose you; it’s to notice you.</p>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="eyebrow yellow">After the shoot</div>
            <h2 class="section-title">A gallery that is ready to share.</h2>
            <p class="section-copy">Edited photos are delivered in a private online gallery. The supplied service mockup
                specifies a 10-business-day standard delivery for portraits and a faster 5-business-day turnaround for
                brand work.</p>
            <div class="mt-28">
                <a class="btn" href="services.php">Compare packages</a>
            </div>
        </div>
    </section>
    <section class="cta">
        <div class="container">
            <h2>Ready when you are.</h2>
            <p>Tell me the date, the idea, and the vibe.</p>
            <a class="btn light" href="booking.php">Check Availability</a>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="brand" href="index.php">
                        <img src="assets/site/Logo White.png" alt="JIMS Photography"
                            style="height: 150px; width: auto;">
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
    <script src="script.js?v=20260913"></script>
</body>

</html>