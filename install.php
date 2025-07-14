#!/usr/bin/env php
<?php

echo "🔧 Installing ARCHphp CLI...\n";

$scriptPath = realpath(__DIR__ . '/archphp');

if (!file_exists($scriptPath)) {
    echo "❌ archphp file not found. Make sure it exists in the root directory.\n";
    exit(1);
}

if (!is_executable($scriptPath)) {
    chmod($scriptPath, 0755);
    echo "🔓 Made archphp executable.\n";
}

$binPath = '/usr/local/bin/archphp';

if (file_exists($binPath)) {
    unlink($binPath);
    echo "♻️  Existing symlink removed.\n";
}

if (symlink($scriptPath, $binPath)) {
    echo "✅ Linked archphp → $binPath\n";
} else {
    echo "❌ Failed to create symlink. Try running with sudo:\n";
    echo "   sudo php install.php\n";
    exit(1);
}

echo "\n✨ CLI installed! Try running:\n";
echo "   archphp --help\n\n";

echo "💡 Want shell autocompletion? Run:\n";
echo "   archphp completion >> ~/.bashrc  # or ~/.zshrc\n";
echo "   source ~/.bashrc\n";
