<?php

namespace App\Security;

// src/Security/SecurityFactory.php

use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class SecurityFactory
{
    public static function createSecurity(UserProviderInterface $userProvider): array
    {
        $userChecker = new UserChecker(); // Checks user status (e.g., enabled/disabled)
        $passwordEncoder = new UserPasswordEncoder(); // Encodes passwords

        // Authentication Provider
        $authenticationProvider = new DaoAuthenticationProvider(
            $userProvider,
            $userChecker,
            'main', // Firewall name
            $passwordEncoder
        );

        // Authentication Manager
        $authenticationManager = new class($authenticationProvider) implements AuthenticationManagerInterface {
            private $provider;

            public function __construct(DaoAuthenticationProvider $provider)
            {
                $this->provider = $provider;
            }

            public function authenticate($token)
            {
                return $this->provider->authenticate($token);
            }
        };

        // Token Storage
        $tokenStorage = new TokenStorage();

        // Authorization Checker
        $authorizationChecker = new AuthorizationChecker(
            $tokenStorage,
            $authenticationManager
        );

        return [
            'tokenStorage' => $tokenStorage,
            'authorizationChecker' => $authorizationChecker,
            'passwordEncoder' => $passwordEncoder,
        ];
    }
}
