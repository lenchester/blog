<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * Find all posts ordered by creation date (most recent first).
     *
     * @return Post[]
     */
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find posts by a specific title (case-insensitive).
     *
     * @param string $title
     * @return Post[]
     */
    public function findByTitle(string $title): array
    {
        return $this->createQueryBuilder('p')
            ->where('LOWER(p.title) LIKE :title')
            ->setParameter('title', '%' . strtolower($title) . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find the top N most recent posts.
     *
     * @param int $limit
     * @return Post[]
     */
    public function findRecent(int $limit = 10): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
