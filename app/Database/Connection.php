<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    protected PDO $pdo;

    public function __construct()
    {
        $config = require base_path('config/db.php');
        $driver = env('DB_DRIVER', $config['default']);
        $db = $config['connections'][$driver] ?? [];

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            switch ($driver) {
                case 'mysql':
                    $dsn = "{$db['driver']}:host={$db['host']};dbname={$db['database']};charset={$db['charset']}";
                    $this->pdo = new PDO(
                        $dsn,
                        $db['username'] ?? 'root',
                        $db['password'] ?? '',
                        $options
                    );
                    break;

                case 'sqlite':
                    $dsn = "sqlite:" . base_path($db['database']);
                    $this->pdo = new PDO($dsn, null, null, $options);
                    break;

                default:
                    cli_echo("❌ Unsupported DB driver: $driver", 'red');
                    exit(1);
            }
        } catch (PDOException $e) {
            cli_echo("❌ Database connection failed: " . $e->getMessage(), 'red');
            exit(1);
        }
    }


    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
