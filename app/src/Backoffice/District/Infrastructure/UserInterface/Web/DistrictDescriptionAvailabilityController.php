<?php

namespace App\Backoffice\District\Infrastructure\UserInterface\Web;

use App\Backoffice\District\Application\DescriptionChecker\IsDescriptionAvailable;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class DistrictDescriptionAvailabilityController extends WebController
{
    public function __invoke(
        Request $request,
        IsDescriptionAvailable $isDescriptionAvailable
    ): JsonResponse {
        try {
            return new JsonResponse(
                $isDescriptionAvailable->__invoke($request->get('description', ''))
            );
        } catch (\Exception $exception) {
            return $this->jsonResponseFail($exception->getMessage());
        }
    }
}
