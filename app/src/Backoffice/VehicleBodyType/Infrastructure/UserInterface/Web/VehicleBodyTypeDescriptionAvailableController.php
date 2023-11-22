<?php

namespace App\Backoffice\VehicleBodyType\Infrastructure\UserInterface\Web;

use App\Backoffice\VehicleBodyType\Application\DescriptionChecker\CheckVehicleBodyTypeDescriptionAvailability;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class VehicleBodyTypeDescriptionAvailableController extends WebController
{
    public function __invoke(
        Request                                     $request,
        CheckVehicleBodyTypeDescriptionAvailability $checkVehicleBodyTypeDescriptionAvailability
    ): JsonResponse
    {
        return new JsonResponse(
            $checkVehicleBodyTypeDescriptionAvailability->__invoke($request->get('description', ''))
        );
    }
}
