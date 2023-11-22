<?php

namespace App\Backoffice\District\Infrastructure\UserInterface\Web;

use App\Backoffice\District\Application\DescriptionChecker\CheckDistrictDescriptionAvailability;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class DistrictDescriptionAvailableController extends WebController
{
    public function __invoke(
        Request                              $request,
        CheckDistrictDescriptionAvailability $checkDistrictDescriptionAvailability
    ): JsonResponse
    {
        return new JsonResponse(
            $checkDistrictDescriptionAvailability->__invoke($request->get('description', ''))
        );
    }
}
