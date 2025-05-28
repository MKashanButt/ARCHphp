<?php
// scripts/helpers.php

/**
 * Get an environment variable or return default.
 */
function env(string $key, $default = null)
{
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    return $value;
}

/**
 * Simple slugify function to create URL-friendly strings.
 */
function slugify(string $text): string
{
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

/**
 * Basic debug helper.
 */
function dd(...$args)
{
    foreach ($args as $arg) {
        echo "<pre>" . print_r($arg, true) . "</pre>";
    }
    exit;
}

/**
 * Path helper to build paths relative to project root.
 */
function base_path(string $path = ''): string
{
    return realpath(__DIR__ . '/../') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * Simple helper to output CLI colored text.
 */
function cli_echo(string $text, string $color = 'default'): void
{
    $colors = [
        'default' => "\033[0m",
        'red'     => "\033[31m",
        'green'   => "\033[32m",
        'yellow'  => "\033[33m",
        'blue'    => "\033[34m",
        'magenta' => "\033[35m",
        'cyan'    => "\033[36m",
        'white'   => "\033[37m",
    ];

    $colorCode = $colors[$color] ?? $colors['default'];
    echo $colorCode . $text . $colors['default'] . PHP_EOL;
}
