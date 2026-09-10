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

function authNavigation(): string
{
    if (authUser()) {
        $adminLink = isAdmin() ? '<a href="admin/admin.php">Admin</a>' : '';
        return $adminLink . '<a class="auth-button outline" href="logout.php">Log out</a>';
    }

    return '<a class="auth-button outline" href="login.php">Log in</a><a class="auth-button" href="register.php">Register</a>';
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
        'success' => ['Request received.', 'Thanks. Your details have been saved successfully.']
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
