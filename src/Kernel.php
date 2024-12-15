<?php

namespace App;

use Monolog\Logger;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
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
    private $container;

    /**
     * @throws \Exception
     */
    public function __construct(RouteCollection $routes)
    {
        $this->loadEnv();
        $this->container = $this->buildContainer();

        $dispatcher = new EventDispatcher();

        $context = new RequestContext();

        $requestStack = new RequestStack();

        $matcher = new UrlMatcher($routes, $context);

        $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));

        $controllerResolver = new ContainerControllerResolver($this->container);
        $argumentResolver = new ArgumentResolver();

        try {
            parent::__construct($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    private function buildContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.project_dir', dirname(__DIR__));

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');

        $container->compile(true);

        return $container;
    }

    private function loadEnv(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
    }
}
