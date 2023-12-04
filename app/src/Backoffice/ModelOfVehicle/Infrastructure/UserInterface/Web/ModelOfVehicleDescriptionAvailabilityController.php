<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;

use App\Backoffice\ModelOfVehicle\Application\DescriptionChecker\IsDescriptionAvailable;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ModelOfVehicleDescriptionAvailabilityController extends WebController
{
    public function __invoke(
        Request $request,
        IsDescriptionAvailable $isDescriptionAvailable
    ): JsonResponse {
        try {
            return new JsonResponse(
                $isDescriptionAvailable->__invoke(
                    $request->get('description',''),
                    $request->get('vehicleMakerNameId', '')
                )
            );
        } catch (\Exception $exception) {
            $this->jsonResponseFail($exception->getMessage());
        }
    }
}
