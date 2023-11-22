<?php

namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

class UserGetLoginController extends WebController
{
    public function __invoke(): Response
    {
        return $this->render('user/login.html.twig', [
            'username' => '',
            'password' => '',
        ]);
    }
}
