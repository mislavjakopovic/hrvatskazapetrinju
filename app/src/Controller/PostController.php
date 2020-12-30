<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Enum\PostIntentEnum;
use App\Form\PostType;
use App\Manager\PostManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostController extends AbstractBaseController
{
    protected const POSTS_PER_PAGE = 6;

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
     * @Route({
     *     "hr": "/objave/{intent}",
     *     "en": "/posts/{intent}"
     * }, name="post_list_by_intent")
     *
     * @param string $intent
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function listByIntent(string $intent, Request $request): Response
    {
        $intent = $this->transformIntent($intent);

        $page = $this->getQueryParam($request, 'page', 'intval');

        return $this->render(
            'post/list.html.twig',
            [
                'intent' => $this->translator->trans($intent),
                'posts' => $this->postManager->getActivePostsPaginated(
                    $intent,
                    $page ? $page : 1,
                    self::POSTS_PER_PAGE
                )
            ]
        );
    }

    /**
     * @Route({
     *     "hr": "/objavi/{intent}",
     *     "en": "/create/{intent}"
     * }, name="post_create_by_intent")
     *
     * @param string $intent
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function createByIntent(string $intent, Request $request): Response
    {
        $intent = $this->transformIntent($intent);

        $post = new Post();
        $form = $this->createForm(PostType::class, $post, ['intent' => $intent]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->postManager->createPost($intent, $post);
            $this->addFlash('success', 'Post created successfully!');

            return $this->redirectToRoute('post_list_by_intent', ['intent' => $intent]);
        }

        return $this->render(
            'post/create.html.twig',
            [
                'intent' => $this->translator->trans($intent),
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route({
     *     "hr": "/objava/{id}",
     *     "en": "/view/{id}"
     * }, methods={"GET"}, name="post_view_by_id")
     *
     * @param Post $post
     *
     * @return Response
     *
     */
    public function viewById(Post $post): Response
    {
        $this->postManager->incrementView($post);

        return $this->render(
            'post/view.html.twig',
            [
                'post' => $post
            ]
        );
    }

    /**
     * @param string $intent
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function transformIntent(string $intent): string
    {
        $intent = $this->translator->trans($intent, [], null, 'en');

        $this->validateIntent($intent);

        return $intent;
    }

    /**
     * @param string $intent
     *
     * @throws \Exception
     */
    protected function validateIntent(string $intent)
    {
        if (!in_array($intent, PostIntentEnum::getAvailableIntents())) {
            throw new NotFoundHttpException($this->translator->trans('error_404'));
        }
    }
}
