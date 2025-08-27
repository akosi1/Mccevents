<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

// Maintenance mode check
if (file_exists($root . '/storage/framework/maintenance.php')) {
    require $root . '/storage/framework/maintenance.php';
}

// Composer autoload
require $root . '/vendor/autoload.php';

// Bootstrap the framework
$app = require_once $root . '/bootstrap/app.php';

// Handle the request through the kernel
$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
