<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function incrementView(Post $post)
    {
        $this->getEntityManager()
            ->createQuery("UPDATE App\Entity\Post p SET p.views = p.views + 1 WHERE p.id = :id")
            ->setParameter('id', $post->getId())
            ->getResult();
    }
}
