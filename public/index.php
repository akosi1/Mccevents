<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$root = __DIR__; // root = public_html

if (file_exists($root.'/storage/framework/maintenance.php')) {
    require $root.'/storage/framework/maintenance.php';
}

require $root.'/vendor/autoload.php';

$app = require_once $root.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
