<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index(Request $request): Response
    {
        return new Response('<h1>Welcome to the Custom test!</h1>');
    }
}
