<?php
// Due to issues with .env, env.php is uaed to continue the project
require_once 'env.php';

// Trimming url and file names for dynamic routing
$url = ltrim($_SERVER['REQUEST_URI'], '/');
$view = 'views/' . ($url ?: 'home') . '.html';
$cssfilename = ($url ?: 'home') . '.css';

if (!file_exists($view)) {
    $view = 'views/404.php';
}

// Adding view to slot variable to render it into template
ob_start();
include_once $view;
$slot = ob_get_clean();

// Final Template Load to complete layout
include_once 'template.php';
