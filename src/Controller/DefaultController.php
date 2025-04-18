<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function index(Request $request): Response
    {
        return new Response('<h1>Welcome to the Custom Framework using Symfony libraries!</h1>');
    }

    public function testConnection(): Response
    {
        return new Response();
    }
}
