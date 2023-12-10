<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Update\DistrictEntryAndExitOfVehiclesControlUpdater;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictEntryAndExitOfVehiclesControlPutController extends WebController
{
    public function __invoke(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlUpdater $updater
    ): Response {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectOnInvalidCsrfToken();
        }

        $validationErrors = ValidationRulesToCreateAndUpdate::verify($request);

        return $validationErrors->count() ? $this->redirectWithErrors(
            TwigTemplateConstants::EDIT_PATH,
            $validationErrors,
            $request
        ) : $this->update($request, $updater);
    }

    private function update(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlUpdater $updater
    ) {
        $updater->__invoke(
            $request->get('id'),
            $request->get('license_plate'),
            $request->get('model_of_vehicle_id'),
            $request->get('trip_origin_id'),
            $request->get('trip_destination_id'),
            $request->get('reason_for_trip_id'),
            $request->get('traffic_police_booth_id'),
            $request->get('vehicle_passenger')
        );

return $this->redirectWithSuccessUpdateMessage(TwigTemplateConstants::LIST_PATH);
    }
}
