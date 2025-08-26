<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path to storage, vendor, bootstrap should be fixed relative to root
$root = __DIR__;

// Check maintenance mode
if (file_exists($root.'/storage/framework/maintenance.php')) {
    require $root.'/storage/framework/maintenance.php';
}

// Register Composer autoloader
require $root.'/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $root.'/bootstrap/app.php';

// Handle the request
$app->handleRequest(Request::capture());
