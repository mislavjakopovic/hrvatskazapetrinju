<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class AbstractBaseController extends AbstractController
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @param string $param
     * @param string $cast
     *
     * @return mixed|null
     */
    protected function getQueryParam(Request $request, string $param, string $cast = '')
    {
        $value = $cast($request->get($this->translator->trans($param)));

        if (empty($value)) {
            $value = $cast($request->get($param));
        }

        return $value;
    }
}
