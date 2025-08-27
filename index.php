<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Forward all traffic to Laravel's real entry point
require __DIR__ . '/public_html/index.php';
