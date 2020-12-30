<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\PostManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractBaseController
{
    protected const LATEST_POSTS = 8;

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @param PostManager $postManager
     * @param TranslatorInterface $translator
     */
    public function __construct(PostManager $postManager, TranslatorInterface $translator)
    {
        $this->postManager = $postManager;

        parent::__construct($translator);
    }

    /**
     * @Route("/", name="home_index")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'posts' => $this->postManager->getLatestPosts(self::LATEST_POSTS)
            ]
        );
    }
}
