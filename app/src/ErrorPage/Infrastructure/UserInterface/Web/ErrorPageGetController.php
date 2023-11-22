<?php

namespace App\ErrorPage\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

class ErrorPageGetController extends WebController
{
    public function __invoke(): Response
    {
        return $this->render('ErrorPage/errorPage.html.twig');
    }
}
