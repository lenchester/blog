<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new Response('saved');
    }

    public function getAll(): JsonResponse
    {
        $postsRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postsRepository->findAll();

        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
            ];
        }

        return new JsonResponse($data);
    }

    public function postsByCategory(): Response
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findBy(['title' => 'symfony']);

        return new Response(
            '<html><body>' . implode('<br>', array_map(fn($post) => $post->getTitle(), $posts)) . '</body></html>'
        );
    }
}