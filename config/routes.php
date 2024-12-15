<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('home', new Route('/', [
    '_controller' => [\App\Controller\DefaultController::class, 'index']
]));

$routes->add('home', new Route('/db', [
    '_controller' => [\App\Controller\DefaultController::class, 'testConnection']
]));
/*$routes->add('');*/

return $routes;
