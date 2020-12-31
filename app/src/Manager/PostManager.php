<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Post;
use App\Enum\PostStatusEnum;
use App\Exception\PostNotFoundException;
use App\Helper\RandomStringGenerator;
use App\Repository\PostRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param PostRepository $postRepository
     * @param PaginatorInterface $paginator
     * @param TranslatorInterface $translator
     */
    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator, TranslatorInterface $translator)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
        $this->translator = $translator;
    }

    public function createPost(string $intent, Post $post)
    {
        $post->setIntent($intent);
        $post->setStatus(PostStatusEnum::ACTIVE);
        $post->setCreatedAt(new \DateTime());
        $post->setDeactivationToken($this->generateDeactivationToken());
        $this->postRepository->save($post);
    }

    public function deletePostByToken(string $deactivationToken)
    {
        $post = $this->postRepository->findOneBy(['deactivationToken' => $deactivationToken]);
        if (empty($post)) {
            throw new PostNotFoundException();
        }

        $this->postRepository->delete($post);
    }

    public function getActivePosts(string $intent): ?array
    {
        return $this->postRepository->findBy(
            ['intent' => $intent, 'status' => PostStatusEnum::ACTIVE],
            ['createdAt' => 'DESC']
        );
    }

    public function getActivePostsPaginated(string $intent, int $page, int $perPage): ?PaginationInterface
    {
        return $this->paginator->paginate(
            $this->getActivePosts($intent),
            $page,
            $perPage,
            ['pageParameterName' => $this->translator->trans('page')]
        );
    }

    public function getLatestPosts(int $limit): ?array
    {
        return $this->postRepository->findBy(
            ['status' => PostStatusEnum::ACTIVE],
            ['createdAt' => 'DESC'],
            $limit
        );
    }

    public function incrementView(Post $post)
    {
        $this->postRepository->incrementView($post);
    }

    protected function generateDeactivationToken()
    {
        $token = RandomStringGenerator::generate(12);

        if ($this->postRepository->findBy(['deactivationToken' => $token])) {
            return $this->generateDeactivationToken();
        }

        return $token;
    }
}
