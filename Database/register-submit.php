<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/auth.php';

// Validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCsrf()) authRedirect('register.php', 'invalid');

$name = trim((string) ($_POST['name'] ?? ''));
$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$password = (string) ($_POST['password'] ?? '');
$confirm = (string) ($_POST['password_confirm'] ?? '');

if (mb_strlen($name) < 2 || mb_strlen($name) > 120 || !filter_var($email, FILTER_VALIDATE_EMAIL)) authRedirect('register.php', 'invalid');
if (strlen($password) < 8 || strlen($password) > 255 || $password !== $confirm) authRedirect('register.php', 'password');

try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $name, $email, $hash);
    $stmt->execute();
    $userId = $conn->insert_id;
    $stmt->close();
    $conn->close();
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $userId,
        'name' => $name,
        'email' => $email,
        'role' => 'user'
    ];
    header('Location: ../index.php?status=registered');
    exit;
} catch (mysqli_sql_exception $exception) {
    if ((int) $exception->getCode() === 1062) authRedirect('register.php', 'exists');
    error_log('Registration failed: ' . $exception->getMessage());
    authRedirect('register.php', 'error');
}
