<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(Request $request): Response
    {
        return new Response('<h1>Welcome to the Custom Framework using Symfony libraries!</h1>');
    }

    public function testConnection(): Response
    {
        try {
            // Perform a basic query to check if the database is accessible
            $connection = $this->entityManager->getConnection();

            // Execute a lightweight query
            $sql = 'SELECT 1';
            $result = $connection->executeQuery($sql)->fetchOne();

            if ($result) {
                $status = 'Database connection is successful!';
            } else {
                $status = 'Database connection failed: No result from query.';
            }
        } catch (\Exception $e) {
            $status = 'Database connection failed: ' . $e->getMessage();
        }

        return new Response($status);
    }
}
