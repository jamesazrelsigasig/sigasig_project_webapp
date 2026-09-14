<?php
declare(strict_types=1);
require __DIR__ . '/../database/config.php';
require __DIR__ . '/../database/auth.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) {
    header('Location: admin.php?status=invalid');
    exit;
}

$action = (string) ($_POST['action'] ?? '');

try {
    if ($action === 'review') {
        $reviewId = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);
        $approved = filter_input(INPUT_POST, 'approved', FILTER_VALIDATE_INT);
        if (!$reviewId || !in_array($approved, [0, 1], true)) {
            throw new InvalidArgumentException('Invalid review action.');
        }
        $stmt = $conn->prepare('UPDATE reviews SET is_approved = ? WHERE id = ?');
        $stmt->bind_param('ii', $approved, $reviewId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php?status=review_updated');
        exit;
    }

    if ($action === 'booking') {
        $bookingId = filter_input(INPUT_POST, 'booking_id', FILTER_VALIDATE_INT);
        $bookingStatus = (string) ($_POST['booking_status'] ?? '');
        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (!$bookingId || !in_array($bookingStatus, $validStatuses, true)) {
            throw new InvalidArgumentException('Invalid booking action.');
        }
        $stmt = $conn->prepare('UPDATE bookings SET status = ? WHERE id = ?');
        $stmt->bind_param('si', $bookingStatus, $bookingId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php?status=booking_updated');
        exit;
    }

    if ($action === 'payment') {
        $bookingId = filter_input(INPUT_POST, 'booking_id', FILTER_VALIDATE_INT);
        $paymentStatus = (string) ($_POST['payment_status'] ?? '');
        $paymentAmount = trim((string) ($_POST['payment_amount'] ?? ''));
        $paymentMethod = trim((string) ($_POST['payment_method'] ?? ''));
        $paymentReference = trim((string) ($_POST['payment_reference'] ?? ''));
        $validStatuses = ['unpaid', 'partial', 'paid', 'refunded', 'failed', 'waived'];
        $validMethods = ['', 'gcash', 'bank_transfer', 'cash', 'card', 'other'];
        if (!$bookingId || !in_array($paymentStatus, $validStatuses, true) || !in_array($paymentMethod, $validMethods, true)
            || ($paymentAmount !== '' && (!is_numeric($paymentAmount) || (float) $paymentAmount < 0))
            || strlen($paymentReference) > 120) {
            throw new InvalidArgumentException('Invalid payment action.');
        }
        $amount = $paymentAmount;
        $paidAt = in_array($paymentStatus, ['paid', 'partial'], true) ? date('Y-m-d H:i:s') : null;
        $stmt = $conn->prepare('UPDATE bookings SET payment_status = ?, payment_amount = NULLIF(?, ""), payment_method = NULLIF(?, ""), payment_reference = NULLIF(?, ""), paid_at = ? WHERE id = ?');
        $stmt->bind_param('sssssi', $paymentStatus, $amount, $paymentMethod, $paymentReference, $paidAt, $bookingId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php?status=payment_updated');
        exit;
    }

    if ($action === 'delete_inquiry') {
        $inquiryId = filter_input(INPUT_POST, 'inquiry_id', FILTER_VALIDATE_INT);
        if (!$inquiryId) {
            throw new InvalidArgumentException('Invalid inquiry.');
        }
        $stmt = $conn->prepare('DELETE FROM inquiries WHERE id = ?');
        $stmt->bind_param('i', $inquiryId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php?status=inquiry_deleted');
        exit;
    }

    if ($action === 'delete_review') {
        $reviewId = filter_input(INPUT_POST, 'review_id', FILTER_VALIDATE_INT);
        if (!$reviewId) {
            throw new InvalidArgumentException('Invalid review.');
        }
        $stmt = $conn->prepare('DELETE FROM reviews WHERE id = ?');
        $stmt->bind_param('i', $reviewId);
        $stmt->execute();
        $stmt->close();
        header('Location: admin.php?status=review_deleted');
        exit;
    }

    throw new InvalidArgumentException('Unknown admin action.');
} catch (Throwable $exception) {
    error_log('Admin action failed: ' . $exception->getMessage());
    header('Location: admin.php?status=error');
    exit;
}