<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/auth.php';

function redirectWithStatus(string $status): never
{
    header('Location: ../contact.php?status=' . rawurlencode($status));
    exit;
}

function postValue(string $key): string
{
    return trim((string) ($_POST[$key] ?? ''));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) {
    redirectWithStatus('invalid');
}

$name = postValue('name');
$email = postValue('email');
$phone = postValue('phone');
$sessionType = postValue('session');
$message = postValue('message');
$services = ['Portraits', 'Weddings & Events', 'Brand & Commercial'];

if (mb_strlen($name) < 2 || mb_strlen($name) > 120 || mb_strlen($email) > 160 || $sessionType === '' || mb_strlen($message) < 10 || mb_strlen($message) > 5000 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectWithStatus('invalid');
}
if ($phone !== '' && preg_match('/^[0-9]{1,11}$/', $phone) !== 1) {
    redirectWithStatus('invalid_phone');
}
if (!in_array($sessionType, $services, true)) {
    redirectWithStatus('invalid_service');
}

try {
    $inquiry = $conn->prepare('INSERT INTO inquiries (name, email, phone, event_date, session_type, message) VALUES (?, ?, ?, NULL, ?, ?)');
    $inquiry->bind_param('sssss', $name, $email, $phone, $sessionType, $message);
    $inquiry->execute();
    $inquiry->close();
    $conn->close();
    redirectWithStatus('success');
} catch (Throwable $exception) {
    error_log('Inquiry submission failed: ' . $exception->getMessage());
    redirectWithStatus('error');
}
