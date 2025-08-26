<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$root = __DIR__ . '/..';  // Laravel root (parent of public_html)

// Check for maintenance
if (file_exists($root.'/storage/framework/maintenance.php')) {
    require $root.'/storage/framework/maintenance.php';
}

// Composer autoload
require $root.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $root.'/bootstrap/app.php';

// Handle request
$app->handleRequest(Request::capture());
