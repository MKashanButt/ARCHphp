#!/usr/bin/env php
<?php

$command = $argv[1] ?? null;
$migrationsDir = __DIR__ . '/../migrations';

switch ($command) {
    case 'new':
        $projectName = $argv[2] ?? null;
        if (!$projectName) {
            echo "❌ Project name is required.\n";
            exit(1);
        }

        $projectPath = getcwd() . DIRECTORY_SEPARATOR . $projectName;

        if (file_exists($projectPath)) {
            echo "❌ Directory '$projectName' already exists.\n";
            exit(1);
        }

        mkdir($projectPath, 0777, true);

        $skeletonPath = __DIR__ . '/../skeleton';

        function copyDir($src, $dst)
        {
            $dir = opendir($src);
            @mkdir($dst, 0777, true);
            while (false !== ($file = readdir($dir))) {
                if ($file !== '.' && $file !== '..') {
                    $srcPath = $src . DIRECTORY_SEPARATOR . $file;
                    $dstPath = $dst . DIRECTORY_SEPARATOR . $file;

                    if (is_dir($srcPath)) {
                        copyDir($srcPath, $dstPath);
                    } else {
                        copy($srcPath, $dstPath);
                    }
                }
            }
            closedir($dir);
        }

        // Copy skeleton into new project
        copyDir($skeletonPath, $projectPath);

        echo "✅ Project '$projectName' created at $projectPath\n";
        echo "👉 Next steps:\n";
        echo "   cd $projectName\n";
        echo "   composer install\n";
        break;

    case 'migrate':
        require $migrationsDir;
        break;

    case 'make:migration':

        if (!is_dir($migrationsDir)) {
            mkdir($migrationsDir, 0755, true);
        }
        $name = $argv[2] ?? null;
        if (!$name) {
            echo "❌ Migration name is required.\n";
            exit(1);
        }

        $name = trim($name, ".php");

        $timestamp = date('Y_m_d');
        $className = implode('', array_map('ucfirst', explode('_', $name)));

        $filePath = __DIR__ . '/../migrations/' . "{$timestamp}_{$name}.php";

        $stub = <<<PHP
<?php

class {$className} {
    public function up(PDO \$pdo) {
        // TODO: Write migration logic
    }

    public function down(PDO \$pdo) {
        // TODO: Write rollback logic
    }
}
PHP;

        file_put_contents($filePath, $stub);
        echo "✅ Created migration: " . basename($filePath) . "\n";
        break;

    case 'make:model':
        $name = $argv[2] ?? null;
        if (!$name) {
            echo "❌ Model name is required.\n";
            exit(1);
        }

        $modelName = trim(ucfirst($name), '.php');
        $modelsDir = __DIR__ . '/../models';
        $filePath = "$modelsDir/{$modelName}.php";

        if (!is_dir($modelsDir)) {
            mkdir($modelsDir, 0755, true);
        }

        $stub = <<<PHP
<?php

class {$modelName} {
    protected PDO \$pdo;

    public function __construct(PDO \$pdo) {
        \$this->pdo = \$pdo;
    }

    // TODO: Add model logic (e.g., find, save, delete)
}
PHP;

        file_put_contents($filePath, $stub);
        echo "✅ Created model: {$modelName}\n";
        break;

    case 'help':
        echo "Available commands:\n";
        echo "🎯 migrate -----> Run database migrations\n";
        break;

    default:
        echo "⚠️  Unknown command: '$command'\n";
        echo "Available commands:\n";
        echo "🎯 migrate -----> Run database migrations\n";
        break;
}
