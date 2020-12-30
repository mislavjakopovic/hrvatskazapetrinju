<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Post;
use App\Enum\PostStatusEnum;
use App\Repository\PostRepository;

class PostManager
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function createPost(string $intent, Post $post)
    {
        $post->setIntent($intent);
        $post->setStatus(PostStatusEnum::PENDING);
        $post->setCreatedAt(new \DateTime());
        $this->postRepository->save($post);
    }

    public function getActivePosts(string $intent): ?array
    {
        $posts = $this->postRepository->findBy(
            ['intent' => $intent, 'status' => PostStatusEnum::PENDING],
            ['createdAt' => 'DESC']
        );

        return $posts;
    }

    public function getLatestPosts(): ?array
    {
        $posts = $this->postRepository->findBy(
            ['status' => PostStatusEnum::PENDING],
            ['createdAt' => 'DESC'],
            8
        );

        return $posts;
    }

    public function incrementView(Post $post)
    {
        $this->postRepository->incrementView($post);
    }
}
