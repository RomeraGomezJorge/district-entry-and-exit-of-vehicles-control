<?php

namespace App\Backoffice\VehicleMakerName\Infrastructure\UserInterface\Web;

use App\Backoffice\VehicleMakerName\Application\DescriptionChecker\CheckVehicleMakerNameDescriptionAvailability;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class VehicleMakerNameDescriptionAvailableController extends WebController
{
    public function __invoke(
        Request                                      $request,
        CheckVehicleMakerNameDescriptionAvailability $checkVehicleMakerNameDescriptionAvailability
    ): JsonResponse
    {
        return new JsonResponse(
            $checkVehicleMakerNameDescriptionAvailability->__invoke($request->get('description', ''))
        );
    }
}
