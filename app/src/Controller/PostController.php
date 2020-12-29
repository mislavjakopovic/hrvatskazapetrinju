<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\PostTypeEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractBaseController
{
    /**
     * @Route("/posts", name="post_index")
     */
    public function index(): Response
    {
        return $this->render(
            'post/index.html.twig'
        );
    }

    /**
     * @Route("/{type}", name="post_list_by_type")
     *
     * @param string $type
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function listByType(string $type): Response
    {
        if (!in_array($type, PostTypeEnum::getAvailableTypes())) {
            throw new \Exception('Type not valid, maybe redirect me to homepage gracefully?');
        }

        return $this->render(
            'post/list.html.twig'
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
