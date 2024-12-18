<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Load the user by their username (or email)
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        // Query the database for the user using the email (or username)
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException("User with email $username not found.");
        }

        return $user;
    }

    /**
     * Refresh the user (if necessary)
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new \InvalidArgumentException("User must be an instance of App\Entity\User.");
        }

        // Optionally reload the user from the database
        return $this->entityManager->merge($user);
    }

    /**
     * Check if the class is supported
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}
