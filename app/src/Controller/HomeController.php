<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractBaseController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig'
        );
    }
}
