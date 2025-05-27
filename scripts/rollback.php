<?php
require __DIR__ . '/../database/connection.php';

$migrations = array_reverse(glob('migrations/*.php'));

foreach ($migrations as $file) {
    $class = basename($file, '.php');

    require_once $file;
    $instance = new $class();
    $instance->down($pdo);

    $stmt = $pdo->prepare("DELETE FROM migrations WHERE migration = ?");
    $stmt->execute([$class]);

    echo "🧹 Rolled back: $class\n";
}
