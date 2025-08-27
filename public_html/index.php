<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Root directory is one level above public_html
$root = __DIR__ . '/..';

// Maintenance mode check
if (file_exists($root . '/storage/framework/maintenance.php')) {
    require $root . '/storage/framework/maintenance.php';
}

// Composer autoloader
require $root . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $root . '/bootstrap/app.php';

// Handle HTTP request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
