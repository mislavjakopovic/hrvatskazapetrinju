<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Enum\PostIntentEnum;
use App\Exception\PostNotFoundException;
use App\Form\PostDeleteType;
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
            $this->addFlash('success', $this->translator->trans(
                'post.created',
                [
                    '%deactivationToken%' => $post->getDeactivationToken()
                ]
            ));

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
     * @Route({
     *     "hr": "/obrisi",
     *     "en": "/delete"
     * }, name="post_delete")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \App\Exception\PostNotFoundException
     */
    public function deleteByToken(Request $request): Response
    {
        $form = $this->createForm(PostDeleteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $deactivationToken = $form->getData()['deactivationToken'];
            if (empty($deactivationToken)) {
                $this->addFlash('danger', $this->translator->trans(
                    'post.deactivationTokenEmpty'
                ));

                return $this->redirectToRoute('post_delete');
            }

            try {
                $this->postManager->deletePostByToken($deactivationToken);
            } catch (PostNotFoundException $exception) {
                $this->addFlash('warning', $this->translator->trans(
                    'post.deactivationTokenInvalid',
                    [
                        '%deactivationToken%' => $deactivationToken
                    ]
                ));

                return $this->redirectToRoute('post_delete');
            }

            $this->addFlash('success', $this->translator->trans('post.deleted'));

            return $this->redirectToRoute('home_index');
        }

        return $this->render(
            'post/delete.html.twig',
            [
                'form' => $form->createView()
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
            throw new NotFoundHttpException($this->translator->trans('error.404'));
        }
    }
}
