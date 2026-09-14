<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = getenv('DB_HOST') ?: 'localhost';
$database = getenv('DB_NAME') ?: 'jims_photography';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

function hasColumn(mysqli $connection, string $table, string $column): bool
{
    $result = $connection->query("SHOW COLUMNS FROM `{$table}` LIKE '" . $connection->real_escape_string($column) . "'");
    $exists = $result->num_rows > 0;
    $result->free();
    return $exists;
}

function addColumnIfMissing(mysqli $connection, string $table, string $column, string $definition): void
{
    if (!hasColumn($connection, $table, $column)) {
        $connection->query("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
    }
}

function migrateLegacySchema(mysqli $connection): void
{
    if (hasColumn($connection, 'reviews', 'client_name') && !hasColumn($connection, 'reviews', 'name')) {
        $connection->query('ALTER TABLE reviews CHANGE COLUMN client_name name VARCHAR(120) NOT NULL');
    }
    if (hasColumn($connection, 'reviews', 'review_type') && !hasColumn($connection, 'reviews', 'session_type')) {
        $connection->query('ALTER TABLE reviews CHANGE COLUMN review_type session_type VARCHAR(80) NOT NULL');
    }
    if (hasColumn($connection, 'reviews', 'review_text') && !hasColumn($connection, 'reviews', 'message')) {
        $connection->query('ALTER TABLE reviews CHANGE COLUMN review_text message TEXT NOT NULL');
    }
    $needsApprovalColumn = !hasColumn($connection, 'reviews', 'is_approved');
    addColumnIfMissing($connection, 'reviews', 'is_approved', 'TINYINT(1) NOT NULL DEFAULT 1');
    if ($needsApprovalColumn && hasColumn($connection, 'reviews', 'is_active'))
        $connection->query('UPDATE reviews SET is_approved = is_active');

    addColumnIfMissing($connection, 'inquiries', 'session_type', 'VARCHAR(80) NULL');
    if (hasColumn($connection, 'inquiries', 'service_id')) {
        $connection->query("UPDATE inquiries SET session_type = COALESCE(session_type, 'General enquiry')");
    }

    addColumnIfMissing($connection, 'bookings', 'client_id', 'INT UNSIGNED NULL');
    addColumnIfMissing($connection, 'bookings', 'session_type', 'VARCHAR(80) NULL');
    addColumnIfMissing($connection, 'bookings', 'status_token', 'CHAR(64) NULL');
    addColumnIfMissing($connection, 'bookings', 'requested_payment_plan', "ENUM('full', 'partial') NOT NULL DEFAULT 'full'");
    addColumnIfMissing($connection, 'bookings', 'requested_payment_method', 'VARCHAR(40) NULL');
    addColumnIfMissing($connection, 'bookings', 'payment_status', "ENUM('unpaid', 'partial', 'paid', 'refunded', 'failed', 'waived') NOT NULL DEFAULT 'unpaid'");
    addColumnIfMissing($connection, 'bookings', 'payment_amount', 'DECIMAL(10, 2) NULL');
    addColumnIfMissing($connection, 'bookings', 'payment_method', 'VARCHAR(40) NULL');
    addColumnIfMissing($connection, 'bookings', 'payment_reference', 'VARCHAR(120) NULL');
    addColumnIfMissing($connection, 'bookings', 'paid_at', 'DATETIME NULL');
    addColumnIfMissing($connection, 'bookings', 'notes', 'TEXT NULL');
    addColumnIfMissing($connection, 'users', 'role', "ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
}

try {
    $conn = new mysqli($host, $user, $password);
    $conn->set_charset('utf8mb4');
    $conn->query("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db($database);
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    if ($schema === false) {
        throw new RuntimeException('Unable to read database schema.');
    }
    $conn->multi_query($schema);
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    migrateLegacySchema($conn);
} catch (Throwable $exception) {
    http_response_code(500);
    error_log('Database setup failed: ' . $exception->getMessage());
    exit('The service is temporarily unavailable. Please try again later.');
}