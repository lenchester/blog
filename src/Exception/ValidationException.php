<?php
namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ValidationException extends \Exception implements HttpExceptionInterface
{
    private int $statusCode;

    public function __construct(string $message = "", int $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
