<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use App\Kernel;

$routes = require __DIR__ . '/../config/routes.php';

$kernel = new Kernel($routes);
$request = Request::createFromGlobals();
try {
    $response = $kernel->handle($request);
    $response->send();
} catch (Throwable $e) {
    dd($e);
}

