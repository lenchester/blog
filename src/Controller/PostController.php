<?php

namespace App\Controller;

use App\Entity\Post;
use App\Exception\ValidationException;
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
        $this->validateRequestBody($request);
        $data = json_decode($request->getContent(), true);

        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new JsonResponse('Post created', Response::HTTP_CREATED);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validateRequestBody($request);

        $data = json_decode($request->getContent(), true);
        $post = $this->entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            return new JsonResponse(
                ['error' => 'Post not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new JsonResponse('Post updated successfully', Response::HTTP_OK);
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

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @throws ValidationException
     */
    private function validateRequestBody(Request $request): void
    {
        if (empty($request->getContent())) {
            throw new ValidationException('Empty request body', Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['title']) || empty($data['content'])) {
            throw new ValidationException('Title and content are required.', Response::HTTP_BAD_REQUEST);
        }
    }
}