<?php

namespace App\Backoffice\IdentityCardType\Infrastructure\UserInterface\Web;

use App\Backoffice\IdentityCardType\Application\DescriptionChecker\IsDescriptionAvailable;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class IdentityCardTypeDescriptionAvailabilityController extends WebController
{
    public function __invoke(
        Request $request,
        IsDescriptionAvailable $IsDescriptionAvailable
    ): JsonResponse {
        try {
            return new JsonResponse(
                $IsDescriptionAvailable->__invoke($request->get('description', ''))
            );
        } catch (\Exception $exception) {
            return $this->jsonResponseFail($exception->getMessage());
        }
    }
}
