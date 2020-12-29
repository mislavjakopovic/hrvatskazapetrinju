<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post_")
 */
class PostController extends AbstractBaseController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render(
            'post/index.html.twig'
        );
    }

    /**
     * @Route("s", name="create")
     */
    public function create(): Response
    {
        return $this->redirect(
            $this->generateUrl('post_index')
        );
    }
}
