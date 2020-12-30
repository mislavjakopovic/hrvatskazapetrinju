<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\PostManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractBaseController
{
    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'posts' => $this->postManager->getLatestPosts()
            ]
        );
    }
}
