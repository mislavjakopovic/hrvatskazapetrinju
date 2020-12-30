<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Post;
use App\Enum\PostStatusEnum;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PostManager
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @param PostRepository $postRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
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
        return $this->postRepository->findBy(
            ['intent' => $intent, 'status' => PostStatusEnum::PENDING],
            ['createdAt' => 'DESC']
        );
    }

    public function getActivePostsPaginated(string $intent, int $page, int $perPage): ?PaginationInterface
    {
        return $this->paginator->paginate(
            $this->getActivePosts($intent),
            $page,
            $perPage
        );
    }

    public function getLatestPosts(int $limit): ?array
    {
        return $this->postRepository->findBy(
            ['status' => PostStatusEnum::PENDING],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function incrementView(Post $post)
    {
        $this->postRepository->incrementView($post);
    }
}
