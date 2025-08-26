<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Adjust base path since Laravel core is also inside public_html
$root = __DIR__;

// Check for maintenance mode
if (file_exists($root.'/storage/framework/maintenance.php')) {
    require $root.'/storage/framework/maintenance.php';
}

// Load Composer
require $root.'/vendor/autoload.php';

// Bootstrap the app
$app = require_once $root.'/bootstrap/app.php';

// Handle request
$app->handleRequest(Request::capture());
