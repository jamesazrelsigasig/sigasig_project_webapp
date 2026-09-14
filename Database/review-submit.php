<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/auth.php';

function redirectWithStatus(string $status): never
{
    header('Location: ../reviews.php?status=' . rawurlencode($status));
    exit;
}

function normalizeSessionType(string $sessionType): string
{
    $normalized = trim($sessionType);
    $aliases = [
        'Portraits' => 'Portrait',
        'Portrait' => 'Portrait',
        'Wedding' => 'Wedding',
        'Weddings & Events' => 'Wedding',
        'Commercial' => 'Commercial',
        'Brand & Commercial' => 'Commercial',
        'Other' => 'Other',
    ];

    return $aliases[$normalized] ?? $normalized;
}

// Validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) {
    redirectWithStatus('invalid');
}

$name = trim((string) ($_POST['name'] ?? ''));
$sessionType = normalizeSessionType((string) ($_POST['session_type'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);

if (mb_strlen($name) < 2 || mb_strlen($name) > 120 || mb_strlen($sessionType) < 2 || mb_strlen($sessionType) > 80 || mb_strlen($message) < 10 || mb_strlen($message) > 3000) {
    redirectWithStatus('invalid_message');
}
if ($rating === false || $rating === null || $rating < 1 || $rating > 5) {
    redirectWithStatus('invalid_rating');
}
if (!in_array($sessionType, ['Wedding', 'Portrait', 'Commercial', 'Other'], true)) {
    redirectWithStatus('invalid');
}

try {
    $stmt = $conn->prepare('INSERT INTO reviews (name, rating, session_type, message) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('siss', $name, $rating, $sessionType, $message);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    redirectWithStatus('review_success');
} catch (Throwable $exception) {
    error_log('Review submission failed: ' . $exception->getMessage());
    redirectWithStatus('error');
}
