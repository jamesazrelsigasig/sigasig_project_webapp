<!doctype html>
<html lang="en">

<head>
    <?php require __DIR__ . '/Database/auth.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="JIMS Photography - Dumaguete freelance photography">
    <title>JIMS Photography · Freelance Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260908">
</head>

<body id="top">
    <header class="site-header">
        <div class="container nav d-flex align-items-center justify-content-between">
            <a class="brand" href="#top">
                <img src="assets/site/Logo Black.png" alt="JIMS Photography" style="height: 58px; width: auto;">
            </a>
            <nav class="nav-links">
                <a href="services.php">Services</a>
                <a href="process.php">Process</a>
                <a href="portfolio.php">Portfolio</a>
                <a href="reviews.php">Reviews</a>
                <a href="contact.php">Contact</a>
                <?= authNavigation() ?>
                    <a class="btn fw-bold transition duration-200" href="contact.php">Book Now</a>
            </nav>
            <button class="hamb" aria-label="Open navigation">☰</button>
        </div>
    </header>
    <main>
        <section class="hero hero-home">
            <div class="container hero-inner">
                <div>
                    <div class="eyebrow teal">Freelance photography · Dumaguete</div>
                    <h1>Photos that feel like the moment happened twice.</h1>
                    <p>JIMS Photography is a freelance studio for portraits, weddings, and events - real moments,
                        delivered fast, without the endless portfolio scroll.</p>
                    <div class="hero-actions">
                        <a class="btn fw-bold transition duration-200" href="contact.php">Book a Session</a>
                        <a class="text-link" href="process.php">See How It Works</a>
                    </div>
                    <div class="hero-note">
                        <span class="stars">★★★★★</span>
                        <span>4.9 from 50+ sessions</span>
                        <span>|</span>
                        <span>Now booking</span>
                    </div>
                </div>
                <div class="hero-art">
                    <img class="hero-photo" src="assets/site/hero.jpg" alt="Motorcycle riders at golden hour">
                    <div class="hero-tag">NOW BOOKING<br>Golden Hour Ride</div>
                    <div class="aperture">
                    </div>
                </div>
            </div>
        </section>
        <section class="trust">
            <div class="container">
                <div class="trust-title">Trusted by couples, families & brands across Cebu</div>
                <div class="trust-logos">
                    <span>STUDIO ONE</span>
                    <span>REO'S COFFEE CO.</span>
                    <span>LUMEN & CO.</span>
                    <span>MARIA + LUIS</span>
                    <span>NORTHBAY EVENTS</span>
                </div>
            </div>
        </section>
        <section class="section" id="services">
            <div class="container">
                <div class="eyebrow teal">Services</div>
                <h2 class="section-title">Three ways to work together</h2>
                <p class="section-copy">Pick a starting point - every package is shaped around how you actually want to
                    be photographed.</p>
                <div class="cards3">
                    <a class="service-card" href="services.php#portraits">
                        <img src="assets/site/portrait.jpg" alt="Portrait session">
                        <div class="overlay">
                            <h3>Portraits</h3>
                            <p>Solo, couple, or family sessions that feel like you - not a studio backdrop.</p>
                            <span class="price">Starting at 6,500</span>
                            <span class="mini-link">Learn more →</span>
                        </div>
                    </a>
                    <a class="service-card" href="services.php#weddings">
                        <img src="assets/site/wedding.jpg" alt="Wedding reception">
                        <div class="overlay">
                            <h3>Weddings & Events</h3>
                            <p>Full-day coverage built around the real moments, not just the posed ones.</p>
                            <span class="price">Starting at 35,000</span>
                            <span class="mini-link">Learn more →</span>
                        </div>
                    </a>
                    <a class="service-card" href="services.php#brand">
                        <img src="assets/site/brand.jpg" alt="Brand photography">
                        <div class="overlay">
                            <h3>Brand & Commercial</h3>
                            <p>Product, lifestyle, and headshot photography for growing businesses.</p>
                            <span class="price">Custom quote</span>
                            <span class="mini-link">Learn more →</span>
                        </div>
                    </a>
                </div>
                <div class="mt-28">
                    <a class="btn outline" href="services.php">View all services</a>
                </div>
            </div>
        </section>
        <section class="section dark" id="process">
            <div class="container">
                <div class="eyebrow yellow">Process</div>
                <h2 class="section-title">How a session comes together</h2>
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
                <div class="mt-28">
                    <a class="btn light" href="contact.php">Start a conversation</a>
                </div>
            </div>
        </section>
        <section class="section paper">
            <div class="container about">
                <img class="about-photo" src="assets/site/about.jpg" alt="Photographer holding a camera">
                <div>
                    <div class="eyebrow orange">The person behind the lens</div>
                    <h2 class="section-title">Hi, I’m Jims - welcome in.</h2>
                    <p class="section-copy">I started JIMS Photography after noticing the best pictures happen when
                        people forget the camera is there. No forced smiles, no rigid checklists - just good light, good
                        timing, and a genuine moment.</p>
                    <p class="quote">My job isn’t to pose you; it’s to notice you.</p>
                    <div class="quote-author">- Jims, Owner of JIMS Photography</div>
                    <div class="stats">
                        <div class="stat">
                            <strong>4 yrs</strong>
                            <span>experience</span>
                        </div>
                        <div class="stat">
                            <strong>50+</strong>
                            <span>sessions delivered</span>
                        </div>
                        <div class="stat">
                            <strong>Dumaguete</strong>
                            <span>based · travels worldwide</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section" id="reviews">
            <div class="container">
                <h2 class="section-title">What clients are saying</h2>
                <div class="reviews-grid" aria-live="polite">
                    <article class="review">
                        <div class="review-stars">★★★★★</div>
                        <p>“Jim made our wedding day feel effortless. We forgot he was even there until we saw the
                            gallery.”</p>
                        <strong>Ana & Miguel</strong>
                        <br>
                        <small>Wedding</small>
                    </article>
                    <article class="review">
                        <div class="review-stars">★★★★★</div>
                        <p>“Fast turnaround, zero awkwardness, and the photos actually look like us.”</p>
                        <strong>Carla D.</strong>
                        <br>
                        <small>Portrait Session</small>
                    </article>
                    <article class="review">
                        <div class="review-stars">★★★★★</div>
                        <p>“Professional, punctual, and the brand shoot completely elevated our shop’s socials.”</p>
                        <strong>Reo’s Coffee Co.</strong>
                        <br>
                        <small>Commercial</small>
                    </article>
                </div>
                <div class="mt-28">
                    <a class="btn outline" href="reviews.php">Read all reviews</a>
                </div>
            </div>
        </section>
        <section class="section dark" id="portfolio">
            <div class="container story">
                <div>
                    <div class="eyebrow yellow">A glimpse</div>
                    <h2 class="section-title">One story, told in full.</h2>
                    <p class="section-copy">This is a single frame from a recent session. The full gallery start to
                        finish lives in the portfolio, not on the homepage.</p>
                    <a class="btn" href="portfolio.php">See the Full Story</a>
                </div>
                <div class="story-media">
                    <img src="assets/site/wedding2.jpg" alt="Couple playing ukulele outdoors">
                </div>
            </div>
        </section>
        <section class="cta">
            <div class="container">
                <h2>Let’s make something worth remembering.</h2>
                <p>Sessions fill up fast - especially Autumn weekends.</p>
                <a class="btn light" href="contact.php">Check Availability</a>
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a class="brand" href="#top">
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
                        <a href="contact.php">Book a Session</a>
                        <a href="contact.php">Contact</a>
                        <a href="#top">Back to top</a>
                    </div>
                </div>
                <div id="contact">
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