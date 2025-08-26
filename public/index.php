<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Laravel root — up one level
$root = __DIR__ . '/..';

// Maintenance check
if (file_exists($root . '/storage/framework/maintenance.php')) {
    require $root . '/storage/framework/maintenance.php';
}

// Composer autoload
require $root . '/vendor/autoload.php';

// Bootstrap the framework
$app = require_once $root . '/bootstrap/app.php';

// Handle the incoming request
$app->handleRequest(Request::capture());
