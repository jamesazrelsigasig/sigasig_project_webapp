<?php
declare(strict_types=1);
require __DIR__ . '/../database/auth.php';
$admin = requireAdmin();
require __DIR__ . '/../database/config.php';

$statusMessages = [
  'login_success' => 'Welcome to the admin dashboard.',
  'review_updated' => 'Review visibility updated.',
  'booking_updated' => 'Booking status updated.',
  'payment_updated' => 'Payment details updated.',
  'inquiry_deleted' => 'Inquiry deleted.',
  'review_deleted' => 'Review deleted.',
  'invalid' => 'That admin action was invalid.',
  'error' => 'The admin action could not be completed.'
];
$status = (string) ($_GET['status'] ?? '');

$inquiries = $conn->query('SELECT id, name, email, phone, session_type, message, created_at FROM inquiries 
                            ORDER BY created_at DESC LIMIT 20')->fetch_all(MYSQLI_ASSOC);
$bookings = $conn->query("SELECT b.id, b.status_token, b.session_type, b.event_date, b.status, b.requested_payment_plan, b.requested_payment_method, b.payment_status, 
                                  b.payment_amount, b.payment_method, b.payment_reference, b.paid_at, b.notes, b.created_at, c.name, c.email, c.phone 
                            FROM bookings b INNER JOIN clients c ON c.id = b.client_id WHERE b.status NOT IN ('completed', 'cancelled') 
                            ORDER BY b.created_at DESC LIMIT 20")->fetch_all(MYSQLI_ASSOC);
$reviews = $conn->query('SELECT id, name, rating, session_type, message, is_approved, created_at 
                            FROM reviews ORDER BY created_at DESC LIMIT 20')->fetch_all(MYSQLI_ASSOC);
$counts = [
  'inquiries' => (int) ($conn->query('SELECT COUNT(*) AS total FROM inquiries')->fetch_assoc()['total'] ?? 0),
  'bookings' => (int) ($conn->query("SELECT COUNT(*) AS total FROM bookings WHERE status NOT IN ('completed', 'cancelled')")->fetch_assoc()['total'] ?? 0),
  'reviews' => (int) ($conn->query('SELECT COUNT(*) AS total FROM reviews')->fetch_assoc()['total'] ?? 0)
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin · JIMS Photography</title>
    <link rel="stylesheet" href="../styles.css?v=20260908">
    <link rel="stylesheet" href="admin.css?v=20260910">
</head>

<body>
    <main class="admin-wrap">
        <div class="admin-header">
            <div>
                <div class="eyebrow orange">JIMS Photography</div>
                <h1>Admin dashboard</h1>
                <p>Signed in as <?= htmlspecialchars($admin['name'], ENT_QUOTES, 'UTF-8') ?>.</p>
            </div>
            <div class="admin-links"><a href="../index.php">View site</a><a href="../logout.php">Log out</a></div>
        </div>
        <?php if (isset($statusMessages[$status])): ?>
        <div class="admin-alert"><?= htmlspecialchars($statusMessages[$status], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <div class="admin-stats">
            <div class="admin-stat"><span>Inquiries</span><strong><?= $counts['inquiries'] ?></strong></div>
            <div class="admin-stat"><span>Bookings</span><strong><?= $counts['bookings'] ?></strong></div>
            <div class="admin-stat"><span>Reviews</span><strong><?= $counts['reviews'] ?></strong></div>
        </div>

        <div class="admin-grid">
            <section class="admin-card admin-card-wide">
                <h2>Recent inquiries</h2>
                <?php if (!$inquiries): ?>
                <p>No inquiries yet.</p><?php else: ?>
                <div class="admin-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Client status</th>
                                <th>Session</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inquiries as $row): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($row['name']) ?><small><?= htmlspecialchars($row['email']) 
                      ?><?= $row['phone'] ? ' · ' . htmlspecialchars($row['phone']) : '' ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['session_type']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                                <td>
                                    <form class="admin-form" action="admin-action.php" method="post"
                                        onsubmit="return confirm('Delete this inquiry permanently?');"><input
                                            type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"><input
                                            type="hidden" name="action" value="delete_inquiry"><input type="hidden"
                                            name="inquiry_id" value="<?= (int) $row['id'] ?>"><button
                                            class="admin-delete" type="submit">Delete</button></form>
                                </td>
                            </tr><?php endforeach; ?>
                        </tbody>
                    </table>
                </div><?php endif; ?>
            </section>

            <section class="admin-card admin-card-wide">
                <h2>Bookings</h2>
                <?php if (!$bookings): ?>
                <p>No bookings yet.</p><?php else: ?>
                <div class="admin-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Session</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?><small><?= htmlspecialchars($row['email']) ?></small>
                                </td>
                                <td>
                                    <?php if (preg_match('/^[a-f0-9]{64}$/', (string) $row['status_token'])): ?>
                                    <a class="admin-status-link" href="../booking-status.php?token=<?= rawurlencode($row['status_token']) ?>" target="_blank" rel="noopener">Open status</a>
                                    <?php else: ?>
                                    <small>Unavailable</small>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['session_type']) ?></td>
                                <td><?= htmlspecialchars((string) ($row['event_date'] ?? '—')) ?></td>
                                <td>
                                    <form class="admin-form" action="admin-action.php" method="post"><input
                                            type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"><input
                                            type="hidden" name="action" value="booking"><input type="hidden"
                                            name="booking_id" value="<?= (int) $row['id'] ?>"><select
                                            name="booking_status" aria-label="Booking status">
                                            <option value="pending"
                                                <?= $row['status'] === 'pending' ? ' selected' : '' ?>>Pending</option>
                                            <option value="confirmed"
                                                <?= $row['status'] === 'confirmed' ? ' selected' : '' ?>>Confirmed
                                            </option>
                                            <option value="completed"
                                                <?= $row['status'] === 'completed' ? ' selected' : '' ?>>Completed
                                            </option>
                                            <option value="cancelled"
                                                <?= $row['status'] === 'cancelled' ? ' selected' : '' ?>>Cancelled
                                            </option>
                                        </select><button class="admin-save" type="submit">Save</button></form>
                                </td>
                                <td>
                                    <small>Client prefers:
                                        <?= htmlspecialchars(ucfirst((string) $row['requested_payment_plan']) . ' · ' . ucfirst(str_replace('_', ' ', (string) ($row['requested_payment_method'] ?? 'not specified')))) ?></small>
                                    <form class="admin-form admin-payment-form" action="admin-action.php" method="post">
                                        <input type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="payment">
                                        <input type="hidden" name="booking_id" value="<?= (int) $row['id'] ?>">
                                        <select name="payment_status" aria-label="Payment status">
                                            <?php foreach (['unpaid' => 'Unpaid', 'partial' => 'Partial', 'paid' => 'Paid', 'refunded' => 'Refunded', 'failed' => 'Failed', 'waived' => 'Waived'] as $paymentValue => $paymentLabel): ?>
                                            <option value="<?= $paymentValue ?>"
                                                <?= $row['payment_status'] === $paymentValue ? ' selected' : '' ?>>
                                                <?= $paymentLabel ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input name="payment_amount" type="number" min="0" step="0.01"
                                            placeholder="Amount"
                                            value="<?= htmlspecialchars((string) ($row['payment_amount'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                            aria-label="Payment amount">
                                        <select name="payment_method" aria-label="Payment method">
                                            <?php foreach (['' => 'Method', 'gcash' => 'GCash', 'bank_transfer' => 'Bank transfer', 'cash' => 'Cash', 'card' => 'Card', 
                                                          'other' => 'Other'] as $methodValue => $methodLabel): ?>
                                            <option value="<?= $methodValue ?>"
                                                <?= ($row['payment_method'] ?? '') === $methodValue ? ' selected' : '' ?>>
                                                <?= $methodLabel ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input name="payment_reference" type="text" maxlength="120"
                                            placeholder="Reference"
                                            value="<?= htmlspecialchars((string) ($row['payment_reference'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                            aria-label="Payment reference">
                                        <button class="admin-save" type="submit">Save</button>
                                    </form>
                                    <?php if (!empty($row['paid_at'])): ?><small>Paid
                                        <?= htmlspecialchars((string) $row['paid_at']) ?></small><?php endif; ?>
                                </td>
                            </tr><?php endforeach; ?>
                        </tbody>
                    </table>
                </div><?php endif; ?>
            </section>

            <section class="admin-card admin-card-wide">
                <h2>Reviews</h2>
                <?php if (!$reviews): ?>
                <p>No reviews yet.</p><?php else: ?>
                <div class="admin-table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Reviewer</th>
                                <th>Review</th>
                                <th>Visibility</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']) ?><small><?= htmlspecialchars($row['session_type']) ?>
                                        ·
                                        <?= str_repeat('★', (int) $row['rating']) ?></small></td>
                                <td class="admin-review"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                                <td>
                                    <div class="admin-actions">
                                        <form class="admin-form" action="admin-action.php" method="post"><input
                                                type="hidden" name="csrf_token"
                                                value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"><input
                                                type="hidden" name="action" value="review"><input type="hidden"
                                                name="review_id" value="<?= (int) $row['id'] ?>"><input type="hidden"
                                                name="approved" value="<?= $row['is_approved'] ? '0' : '1' ?>"><button
                                                class="admin-toggle"
                                                type="submit"><?= $row['is_approved'] ? 'Hide' : 'Publish' ?></button>
                                        </form>
                                        <form class="admin-form" action="admin-action.php" method="post"
                                            onsubmit="return confirm('Delete this review permanently?');"><input
                                                type="hidden" name="csrf_token"
                                                value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>"><input
                                                type="hidden" name="action" value="delete_review"><input type="hidden"
                                                name="review_id" value="<?= (int) $row['id'] ?>"><button
                                                class="admin-delete" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr><?php endforeach; ?>
                        </tbody>
                    </table>
                </div><?php endif; ?>
            </section>
        </div>
    </main>
</body>

</html>
<?php $conn->close(); ?>