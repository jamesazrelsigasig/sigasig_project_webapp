<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit('This utility can only be run from the command line.');
}

$email = strtolower(trim((string) ($argv[1] ?? '')));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Usage: php admin/promote-admin.php user@example.com\n");
    exit(1);
}

require __DIR__ . '/../database/config.php';
$stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
if ($stmt->affected_rows === 0) {
    fwrite(STDERR, "No user was promoted. Register that email first, or it is already an admin.\n");
    exit(1);
}
fwrite(STDOUT, "Admin access granted to {$email}.\n");
$stmt->close();
$conn->close();