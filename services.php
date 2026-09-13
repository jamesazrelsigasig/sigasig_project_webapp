<!doctype html>
<html lang="en">

<head>
        <?php require __DIR__ . '/Database/auth.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Services · JIMS Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body class="page-services">
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="index.php">
                <img src="assets/site/Logo Black.png" alt="JIMS Photography" style="height: 58px; width: auto;">
            </a>
            <nav class="nav-links">
                <a class="active" href="services.php">Services</a>
                <a href="process.php">Process</a>
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
            <h1>Photography, tailored to the moment.</h1>
            <p>Three starting points - portraits, weddings & events, and brand work - each shaped around how you
                actually want to be photographed.</p>
            <a class="btn" href="booking.php">Check Availability</a>
        </div>
    </section>
    <main>
        <section class="service-detail" id="portraits">
            <div class="media">
                <img src="assets/site/portrait.jpg" alt="Portrait session">
            </div>
            <div class="detail">
                <h2>Portraits</h2>
                <p>Solo, couple, or family sessions that feel like you - not a studio backdrop. Shot on location or in
                    natural light indoors, with an unscripted, relaxed pace.</p>
                <ul class="checklist">
                    <li>60–90 minute session</li>
                    <li>1–2 outfit changes</li>
                    <li>20+ fully edited images</li>
                    <li>Private online gallery + downloads</li>
                    <li>Print release included</li>
                </ul>
                <div class="price">Starting at 6,500</div>
                <a class="btn teal" href="booking.php">Book a Portrait Session</a>
            </div>
        </section>
        <section class="service-detail reverse" id="weddings">
            <div class="media">
                <img src="assets/site/wedding.jpg" alt="Wedding event">
            </div>
            <div class="detail">
                <h2>Weddings & Events</h2>
                <p>Full-day coverage built around the moments that actually happen - not just the posed ones. 
                  Fromgetting-ready shots to the last dance, documented start to finish.</p>
                <ul class="checklist">
                    <li>Full-day coverage (up to 10 hrs)</li>
                    <li>Second shooter available</li>
                    <li>150+ edited images</li>
                    <li>Same-day preview gallery</li>
                    <li>Engagement session add-on</li>
                </ul>
                <div class="price">Starting at 35,000</div>
                <a class="btn" href="booking.php">Book Your Date</a>
            </div>
        </section>
        <section class="service-detail" id="brand">
            <div class="media">
                <img src="assets/site/brand.jpg" alt="Brand product shoot">
            </div>
            <div class="detail">
                <h2>Brand & Commercial</h2>
                <p>Product, lifestyle, and headshot photography for growing businesses - clean, on-brand imagery ready
                    for web, social, and print.</p>
                <ul class="checklist">
                    <li>Product or lifestyle shoot</li>
                    <li>Usage rights for web & social</li>
                    <li>Half-day or full-day options</li>
                    <li>Fast 5-business-day turnaround</li>
                    <li>On-location or studio</li>
                </ul>
                <div class="price">Custom quote</div>
                <a class="btn yellow" href="contact.php">Request a Quote</a>
            </div>
        </section>
        <section class="addons">
            <div class="container">
                <div class="eyebrow yellow">Popular add-ons</div>
                <h2 class="section-title">Round out your package</h2>
                <div class="addons-grid">
                    <div class="addon">
                        <strong>Extra Hour</strong>
                        <span>+1,500</span>
                    </div>
                    <div class="addon">
                        <strong>Second Shooter</strong>
                        <span>+5,000</span>
                    </div>
                    <div class="addon">
                        <strong>Rush Delivery (48 hrs)</strong>
                        <span>+2,000</span>
                    </div>
                    <div class="addon">
                        <strong>Printed Album</strong>
                        <span>+3,500</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="faq" id="faq">
            <div class="container">
                <div class="eyebrow teal">FAQ</div>
                <h2 class="section-title">Frequently asked questions</h2>
                <div class="faq-item open">
                    <button class="faq-q">How far in advance should I book?<span>−</span>
                    </button>
                    <div class="faq-a">Most sessions book 2–4 weeks out; weddings and peak-season dates 3–6 months
                        ahead.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What's the turnaround time?<span>+</span>
                    </button>
                    <div class="faq-a">Standard gallery delivery is within 10 business days; brand work has a fast
                        5-business-day option listed above.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you travel outside Dumaguete?<span>+</span>
                    </button>
                    <div class="faq-a">JIMS Photography is Dumaguete based and available worldwide. Travel planning can
                        be discussed during enquiry.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What's the payment and deposit policy?<span>+</span>
                    </button>
                    <div class="faq-a">Payment details are not specified in the provided mockup; confirm the current
                        deposit policy directly when enquiring.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I customize a package?<span>+</span>
                    </button>
                    <div class="faq-a">Yes - packages are starting points and can be shaped around your session through
                        the enquiry and planning steps.</div>
                </div>
            </div>
        </section>
        <section class="cta">
            <div class="container">
                <h2>Ready to book your session?</h2>
                <p>Tell me your date and vision - I’ll take it from there.</p>
                <a class="btn light" href="booking.php">Check Availability</a>
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