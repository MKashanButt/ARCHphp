<?php
$env = parse_ini_file(__DIR__ . '/../.env');

$driver = $env['DB_DRIVER'];

try {
    if ($driver == 'sqlite') {
        $path = __DIR__ . '/../storage/database.sqlite';
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        $pdo = new PDO("sqlite:" . $path);
    } else {
        $host = $env['DB_HOST'];
        $db   = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
