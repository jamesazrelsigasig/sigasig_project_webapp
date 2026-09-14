<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function authUser(): ?array {
    return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
}

function isAdmin(?array $user = null): bool
{
    $user ??= authUser();
    return is_array($user) && ($user['role'] ?? 'user') === 'admin';
}

function requireAdmin(): array
{
    $user = authUser();
    if (!$user) {
        header('Location: ../login.php?status=admin_login');
        exit;
    }
    if (!isAdmin($user)) {
        header('Location: ../index.php?status=forbidden');
        exit;
    }
    return $user;
}

function authNavigation(bool $includeBookingStatus = true): string
{
    $bookingStatusLink = '';
    $bookingToken = (string) ($_SESSION['booking_status_token'] ?? '');
    if ($includeBookingStatus && preg_match('/^[a-f0-9]{64}$/', $bookingToken)) {
        global $conn;
        require_once __DIR__ . '/config.php';
        $statusQuery = $conn->prepare('SELECT status FROM bookings WHERE status_token = ? LIMIT 1');
        $statusQuery->bind_param('s', $bookingToken);
        $statusQuery->execute();
        $bookingStatus = $statusQuery->get_result()->fetch_assoc()['status'] ?? null;
        $statusQuery->close();
        if (in_array($bookingStatus, ['pending', 'confirmed'], true)) {
            $bookingStatusLink = '<a href="booking-status.php?token=' . rawurlencode($bookingToken) . '">Booking status</a>';
        } else {
            unset($_SESSION['booking_status_token']);
        }
    }

    if (authUser()) {
        $adminLink = isAdmin() ? '<a href="admin/admin.php">Admin</a>' : '';
        return $bookingStatusLink . $adminLink . '<a class="auth-button outline" href="logout.php">Log out</a>';
    }

    return $bookingStatusLink . '<a class="auth-button outline" href="login.php">Log in</a><a class="auth-button" href="register.php">Register</a>';
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): bool {
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token']);
}

function authRedirect(string $page, string $status): never {
    header('Location: ../' . $page . '?status=' . rawurlencode($status));
    exit;
}

function renderStatusModal(): string
{
    $messages = [
        'login_success' => ['Welcome back.', 'You are now logged in to JIMS Photography.'],
        'registered' => ['Account created.', 'Your JIMS Photography account is ready to use.'],
        'logout_success' => ['You are logged out.', 'Thanks for visiting JIMS Photography.'],
        'success' => ['Request received.', 'Thanks. Your details have been saved successfully.'],
        'review_success' => ['Review submitted.', 'Thanks for sharing your experience. Your review is awaiting approval.'],
        'booking_success' => ['Booking request received.', 'Your selected date is reserved while Jims confirms the details with you.'],
        'invalid' => ['Please check the form.', 'Some details look incorrect. Please try again.'],
        'invalid_rating' => ['Please choose a valid rating.', 'Select a star rating between 1 and 5.'],
        'invalid_message' => ['Review too short.', 'Please write a little more detail about your experience.']
    ];
    $status = (string) ($_GET['status'] ?? '');
    if (!isset($messages[$status])) {
        return '';
    }

    [$title, $message] = $messages[$status];
    return '<div class="success-modal" id="status-modal" role="dialog" aria-modal="true" aria-labelledby="status-modal-title">'
        . '<div class="success-modal-card">'
        . '<button class="success-modal-close" type="button" aria-label="Close confirmation">&times;</button>'
        . '<div class="success-icon" aria-hidden="true">&#10003;</div>'
        . '<h2 id="status-modal-title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h2>'
        . '<p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>'
        . '<button class="btn" type="button" data-close-status>Continue</button>'
        . '</div></div>';
}
