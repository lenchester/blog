<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('home', new Route('/', [
    '_controller' => [\App\Controller\DefaultController::class, 'index']
]));

$routes->add('db', new Route('/db', [
    '_controller' => [\App\Controller\DefaultController::class, 'testConnection']
]));

$routes->add('posts get', new Route('/posts', [
    '_controller' => [\App\Controller\PostController::class, 'getAll']
], methods: ['GET']));

$routes->add('posts create', new Route('/posts', [
    '_controller' => [\App\Controller\PostController::class, 'create']
], methods: ['POST']));

return $routes;
