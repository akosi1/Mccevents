<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Laravel root — up one level from /public
$root = dirname(__DIR__);

// Maintenance mode check
if (file_exists($root . '/storage/framework/maintenance.php')) {
    require $root . '/storage/framework/maintenance.php';
}

// Composer autoloader
require $root . '/vendor/autoload.php';

// Bootstrap the framework
$app = require_once $root . '/bootstrap/app.php';

// Create kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Handle the request
$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

// Terminate the request
$kernel->terminate($request, $response);
