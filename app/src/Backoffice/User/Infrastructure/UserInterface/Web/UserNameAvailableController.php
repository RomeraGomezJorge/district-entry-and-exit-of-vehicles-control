<?php

namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

use App\Backoffice\User\Application\UserNameChecker\CheckUserNameAvailability;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UserNameAvailableController extends WebController
{
    public function __invoke(Request $request, CheckUserNameAvailability $checkUserNameAvailability): JsonResponse
    {
        return new JsonResponse(
            $checkUserNameAvailability->__invoke($request->get('username', ''))
        );
    }
}
