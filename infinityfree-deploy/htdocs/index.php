<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/valuemap-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/valuemap-app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/valuemap-app/bootstrap/app.php';

// InfinityFree serves this htdocs directory as the public web root.
// Tell Laravel/Vite to read the manifest and public files from here too.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
