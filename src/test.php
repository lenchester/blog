<?php

namespace App;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class test implements HttpKernelInterface
{
    public function handle(Request $request, $type = self::MAIN_REQUEST, $catch = true): Response
    {
        $controller = $request->attributes->get('_controller');

        if (is_callable($controller)) {
            return call_user_func($controller, $request);
        }

        return new Response('Page not found', 404);
    }
}
