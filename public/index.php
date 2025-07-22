<?php

// Trimming url and file names for dynamic routing
$url = ltrim($_SERVER['REQUEST_URI'], '/');
$view = base_path('views/' . ($url ?: 'index') . '.html');
$cssfilename = base_path('views/' . ($url ?: 'home') . '.css');

if (!file_exists($view)) {
    $view = base_path('views/404.php');
}

// Adding view to slot variable to render it into template
ob_start();
include_once $view;
$slot = ob_get_clean();

// Final Template Load to complete layout
include_once  base_path('template.php');
