<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function login(Request $request): JsonResponse
    {
        $user = $this->security->getUser();

        if ($user) {
            return new JsonResponse([
                'message' => 'Already logged in',
                'user' => $user->getUserIdentifier(),
            ], 200);
        }

        $exception = $request->getSession()->get('security.authentication.error', null);

        if ($exception) {
            return new JsonResponse([
                'error' => $exception->getMessage(),
            ], 401);
        }

        return new JsonResponse(['message' => 'Authentication required'], 401);
    }
}