<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/auth.php';

function redirectBooking(string $status): never
{
    header('Location: ../booking.php?status=' . rawurlencode($status));
    exit;
}

function bookingPostValue(string $key): string
{
    return trim((string) ($_POST[$key] ?? ''));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) {
    redirectBooking('invalid');
}

$name = bookingPostValue('name');
$email = bookingPostValue('email');
$phone = bookingPostValue('phone');
$eventDate = bookingPostValue('date');
$sessionType = bookingPostValue('session');
$notes = bookingPostValue('message');
$services = ['Portraits', 'Weddings & Events', 'Brand & Commercial'];

if (mb_strlen($name) < 2 || mb_strlen($name) > 120 || mb_strlen($email) > 160 || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($notes) < 10 || mb_strlen($notes) > 5000) {
    redirectBooking('invalid');
}
if ($phone !== '' && preg_match('/^[0-9]{1,11}$/', $phone) !== 1) {
    redirectBooking('invalid_phone');
}
if (!in_array($sessionType, $services, true)) {
    redirectBooking('invalid_service');
}

$date = DateTimeImmutable::createFromFormat('!Y-m-d', $eventDate);
if (!$date || $date->format('Y-m-d') !== $eventDate || $date < new DateTimeImmutable('today')) {
    redirectBooking('invalid_date');
}

try {
    $conn->begin_transaction();

    $availability = $conn->prepare("SELECT id FROM bookings WHERE event_date = ? AND status IN ('pending', 'confirmed') LIMIT 1 FOR UPDATE");
    $availability->bind_param('s', $eventDate);
    $availability->execute();
    $dateTaken = $availability->get_result()->num_rows > 0;
    $availability->close();
    if ($dateTaken) {
        $conn->rollback();
        redirectBooking('invalid_date_taken');
    }

    $client = $conn->prepare('INSERT INTO clients (name, email, phone) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), phone = VALUES(phone)');
    $client->bind_param('sss', $name, $email, $phone);
    $client->execute();
    $clientId = $conn->insert_id;
    if ($clientId === 0) {
        $existingClient = $conn->prepare('SELECT id FROM clients WHERE email = ? LIMIT 1');
        $existingClient->bind_param('s', $email);
        $existingClient->execute();
        $clientId = (int) ($existingClient->get_result()->fetch_assoc()['id'] ?? 0);
        $existingClient->close();
    }
    $client->close();

    if ($clientId < 1) {
        throw new RuntimeException('Unable to identify booking client.');
    }

    $booking = $conn->prepare('INSERT INTO bookings (client_id, session_type, event_date, notes) VALUES (?, ?, ?, ?)');
    $booking->bind_param('isss', $clientId, $sessionType, $eventDate, $notes);
    $booking->execute();
    $booking->close();

    $conn->commit();
    $conn->close();
    redirectBooking('success');
} catch (Throwable $exception) {
    $conn->rollback();
    error_log('Booking submission failed: ' . $exception->getMessage());
    redirectBooking('error');
}
