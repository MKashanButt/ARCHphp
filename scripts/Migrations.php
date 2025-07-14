<?php

namespace ARCHphp\Scripts;

use App\Database\Connection;
use PDO;

class Migrations
{
    protected PDO $pdo;
    protected string $table = 'migrations';
    protected string $path;

    public function __construct()
    {
        $this->pdo = (new Connection())->getPDO();
        $this->path = base_path('database/migrations');
        $this->ensureMigrationsTable();
    }

    protected function ensureMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS {$this->table} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                batch INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
    public function migrate()
    {
        $migrations = glob("{$this->path}/*.php");
        $ran = $this->getRanMigrations();
        $batch = $this->getNextBatchNumber();

        foreach ($migrations as $file) {
            $name = basename($file, '.php');

            if (in_array($name, $ran)) {
                cli_echo("⏩ Skipping already run: $name", 'yellow');
                continue;
            }

            $migration = require $file;

            if (!is_object($migration) || !method_exists($migration, 'up')) {
                cli_echo("❌ Invalid migration structure in: $name", 'red');
                continue;
            }

            try {
                $migration->up($this->pdo);
                $this->recordMigration($name, $batch);
                cli_echo("✅ Migrated: $name", 'green');
            } catch (\Throwable $e) {
                cli_echo("❌ Migration failed: {$e->getMessage()}", 'red');
            }
        }
    }

    public function rollback()
    {
        $batch = $this->getLastBatchNumber();
        if (!$batch) {
            cli_echo("⚠️  No migrations to roll back.", 'yellow');
            return;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE batch = ? ORDER BY id DESC");
        $stmt->execute([$batch]);

        foreach ($stmt->fetchAll() as $row) {
            $name = $row['migration'];
            $file = "{$this->path}/{$name}.php";

            if (!file_exists($file)) {
                cli_echo("❌ File missing: $file", 'red');
                continue;
            }

            require_once $file;
            $class = $this->convertToClassName($name);

            if (!class_exists($class)) {
                cli_echo("❌ Migration class $class not found", 'red');
                continue;
            }

            $migration = new $class();
            $migration->down($this->pdo);

            $this->deleteMigrationRecord($name);
            cli_echo("🔁 Rolled back: $name", 'cyan');
        }
    }

    protected function recordMigration(string $name, int $batch)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (migration, batch) VALUES (?, ?)");
        $stmt->execute([$name, $batch]);
    }

    protected function deleteMigrationRecord(string $name)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE migration = ?");
        $stmt->execute([$name]);
    }

    protected function getRanMigrations(): array
    {
        $result = $this->pdo->query("SELECT migration FROM {$this->table}")->fetchAll();
        return array_column($result, 'migration');
    }

    protected function getNextBatchNumber(): int
    {
        return $this->getLastBatchNumber() + 1;
    }

    protected function getLastBatchNumber(): int
    {
        $result = $this->pdo->query("SELECT MAX(batch) as batch FROM {$this->table}")->fetch();
        return (int)($result['batch'] ?? 0);
    }

    protected function convertToClassName(string $filename): string
    {
        $parts = explode('_', $filename);
        return implode('', array_map('ucfirst', $parts));
    }
}
