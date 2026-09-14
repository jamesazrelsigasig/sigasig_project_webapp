<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/auth.php';

// Validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) authRedirect('login.php', 'invalid');

$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$password = (string) ($_POST['password'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') authRedirect('login.php', 'invalid');

$stmt = $conn->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password_hash'])) authRedirect('login.php', 'credentials');

session_regenerate_id(true);
$_SESSION['user'] = [
    'id' => (int) $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'] ?? 'user'
];
$bookingQuery = $conn->prepare("SELECT b.status_token FROM bookings b INNER JOIN clients c ON c.id = b.client_id WHERE c.email = ? AND b.status IN ('pending', 'confirmed') ORDER BY b.created_at DESC LIMIT 1");
$bookingQuery->bind_param('s', $user['email']);
$bookingQuery->execute();
$bookingToken = (string) ($bookingQuery->get_result()->fetch_assoc()['status_token'] ?? '');
$bookingQuery->close();
if ($bookingToken !== '') {
    $_SESSION['booking_status_token'] = $bookingToken;
}
$conn->close();
header('Location: ' . (($user['role'] ?? 'user') === 'admin' ? '../admin/admin.php' : '../index.php') . '?status=login_success');
exit;
