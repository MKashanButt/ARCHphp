<?php


$autoload = __DIR__ . '../../vendor/autoload.php';

if (!$autoload) {
    echo "❌ Autoload file not found. Please run 'composer install'.\n";
    exit(1);
}

require $autoload;
