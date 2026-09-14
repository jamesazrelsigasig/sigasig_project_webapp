<?php
declare(strict_types=1);
require __DIR__ . '/Database/config.php';
require __DIR__ . '/Database/auth.php';

$token = strtolower(trim((string) ($_GET['token'] ?? '')));
$booking = null;
if (preg_match('/^[a-f0-9]{64}$/', $token)) {
    $stmt = $conn->prepare('SELECT b.session_type, b.event_date, b.status, b.requested_payment_plan, b.requested_payment_method, c.name FROM bookings b INNER JOIN clients c ON c.id = b.client_id WHERE b.status_token = ? LIMIT 1');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $booking = $stmt->get_result()->fetch_assoc() ?: null;
    $stmt->close();
    if ($booking) {
        $_SESSION['booking_status_token'] = $token;
    }
}
$statusLabels = [
    'pending' => 'Pending review',
    'confirmed' => 'Confirmed',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled'
];
$statusLabel = $booking ? ($statusLabels[$booking['status']] ?? ucfirst($booking['status'])) : '';
$paymentInstructions = [
    'gcash' => 'Send to GCash: James Azrel T. Sigasig - 09937369734.',
    'bank_transfer' => 'Bank transfer: Visa | James Azrel T. Sigasig | Account 2453 5864 9899 2145.',
    'cash' => 'Cash payment is collected after the session.',
    'card' => 'Card payment instructions will be provided after your booking is confirmed.'
];
$paymentMethod = (string) ($booking['requested_payment_method'] ?? '');
$paymentMethodLabel = ucfirst(str_replace('_', ' ', $paymentMethod));
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking status · JIMS Photography</title>
    <link rel="stylesheet" href="styles.css?v=20260914">
</head>

<body class="page-contact booking-status-page">
    <header class="site-header">
        <div class="container nav">
            <a class="brand" href="index.php"><img src="assets/site/Logo Black.png" alt="JIMS Photography"
                    style="height: 58px; width: auto;"></a>
                <nav class="nav-links"><a href="index.php">Home</a><a href="booking.php">Book a session</a><a href="contact.php">Contact</a><?= authNavigation(false) ?></nav>
            <button class="hamb" type="button" aria-label="Open navigation">☰</button>
        </div>
    </header>
    <main>
        <section class="page-hero">
            <div class="container">
                <div class="eyebrow teal">Booking status</div>
                <h1><?= $booking ? htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') : 'Booking not found' ?></h1>
                <p><?= $booking ? 'Your booking information is up to date.' : 'This status link is invalid or no longer available.' ?>
                </p>
            </div>
        </section>
        <?php if ($booking): ?>
            <section class="section">
                <div class="container contact-grid">
                    <div class="contact-card">
                        <h2><?= htmlspecialchars($booking['name'], ENT_QUOTES, 'UTF-8') ?>'s booking</h2>
                        <div class="info-list">
                            <div class="info-item">
                                <span>Session</span><strong><?= htmlspecialchars($booking['session_type'], ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                            <div class="info-item">
                                <span>Date</span><strong><?= htmlspecialchars((string) ($booking['event_date'] ?? 'To be confirmed'), ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                            <div class="info-item"><span>Payment
                                    preference</span><strong><?= htmlspecialchars(ucfirst($booking['requested_payment_plan']) . ' via ' . $paymentMethodLabel, ENT_QUOTES, 'UTF-8') ?></strong>
                            </div>
                                <div class="info-item"><span>Where to pay</span><strong><?= htmlspecialchars($paymentInstructions[$paymentMethod] ?? 'Payment details will be provided after confirmation.', ENT_QUOTES, 'UTF-8') ?></strong></div>
                        </div>
                    </div>
                    <div>
                        <div class="eyebrow orange">Next step</div>
                        <h2 class="section-title">
                            <?= $booking['status'] === 'confirmed' ? 'Your date is confirmed.' : 'We will update this page when the status changes.' ?>
                        </h2>
                        <p class="section-copy">Keep this page link so you can check your booking status again.</p>
                        <a class="btn" href="index.php">Return to Home</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <script src="script.js?v=20260914"></script>
</body>

</html>
<?php $conn->close(); ?>