<?php
// config/config.php
// Load environment variables from .env (simple loader)
$env = [];
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2)) + [null, null];
        if ($k) $env[$k] = $v;
    }
}

$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbName = $env['DB_NAME'] ?? 'db_gamekonsol';
$dbUser = $env['DB_USER'] ?? 'root';
$dbPass = $env['DB_PASS'] ?? '';
$dbCharset = $env['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    // Friendly error without exposing stack trace
    http_response_code(500);
    echo "<h2>Database connection error</h2><p>Silakan cek konfigurasi database.</p>";
    exit;
}
?>
