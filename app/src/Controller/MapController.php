<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\PostManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MapController extends AbstractBaseController
{
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
     *     "hr": "/karta",
     *     "en": "/map"
     * }, name="map_index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $mapPosts = $this->postManager->getActiveMapPosts();

        return $this->render(
            'map/index.html.twig',
            [
                'mapPosts' => $mapPosts,
                'mapPoints' => $this->postManager->transformToMapPoints($mapPosts)
            ]
        );
    }
}
