<?php

require __DIR__ . '/../database/connection.php';

// Ensure migrations table exists (SQLite-safe)
$pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    migration TEXT NOT NULL,
    applied_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$executed = $pdo
    ->query("SELECT migration FROM migrations")
    ->fetchAll(PDO::FETCH_COLUMN);

// Find all migration files
$migrations = glob(__DIR__ . '/../migrations/*.php');

if (!$migrations) {
    echo "⚠️  No migrations found in /migrations\n";
    exit;
}

foreach ($migrations as $file) {
    $class = basename($file, '.php');

    if (in_array($class, $executed)) {
        echo "⏭️  Already migrated: $class\n";
        continue;
    }

    require_once $file;

    if (!class_exists($class)) {
        echo "❌ Migration class '$class' not found in file $file\n";
        continue;
    }

    $instance = new $class();

    if (!method_exists($instance, 'up')) {
        echo "❌ Migration class '$class' missing 'up' method\n";
        continue;
    }

    try {
        $instance->up($pdo);
        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$class]);
        echo "✅ Migrated: $class\n";
    } catch (PDOException $e) {
        echo "❌ Error running migration '$class': " . $e->getMessage() . "\n";
    }
}
