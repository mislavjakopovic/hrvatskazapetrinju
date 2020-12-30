<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Enum\PostIntentEnum;
use App\Form\PostType;
use App\Manager\PostManager;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/{intent}", name="post_list_by_intent")
     *
     * @param string $intent
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function listByIntent(string $intent,  PostManager $postManager): Response
    {
        $this->checkIntent($intent);

        return $this->render(
            'post/list.html.twig',
            [
                'intent' => $intent,
                'posts' => $postManager->getActivePosts($intent)
            ]
        );
    }

    /**
     * @Route("/create/{intent}", name="post_create_by_intent")
     *
     * @param string $intent
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function createByIntent(string $intent, Request $request, PostManager $postManager): Response
    {
        $this->checkIntent($intent);

        $post = new Post();
        $form = $this->createForm(PostType::class, $post, ['intent' => $intent]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postManager->createPost($intent, $post);
            $this->addFlash('success', 'Post created successfully!');

            return $this->redirectToRoute('post_list_by_intent', ['intent' => $intent]);
        }


        return $this->render(
            'post/create.html.twig',
            [
                'intent' => $intent,
                'form' => $form->createView()
            ]
        );
    }

    protected function checkIntent(string $intent): void
    {
        if (!in_array($intent, PostIntentEnum::getAvailableIntents())) {
            throw new \Exception('Intent is not valid, maybe redirect me to homepage gracefully?');
        }
    }
}
