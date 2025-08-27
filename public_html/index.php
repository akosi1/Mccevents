<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Correct path constant
$root = __DIR__;

// Maintenance mode check
if (file_exists($maintenance = $root . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require $root . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request
/** @var Application $app */
$app = require_once $root . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
