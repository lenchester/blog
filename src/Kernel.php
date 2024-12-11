<?php

namespace App;

use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class Kernel extends HttpKernel
{
    public function __construct(RouteCollection $routes)
    {
        $dispatcher = new EventDispatcher();

        $context = new RequestContext();

        $requestStack = new RequestStack();

        $matcher = new UrlMatcher($routes, $context);

        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));

        $controllerResolver = new ControllerResolver();

        parent::__construct($dispatcher, $controllerResolver, $requestStack);
    }
}
