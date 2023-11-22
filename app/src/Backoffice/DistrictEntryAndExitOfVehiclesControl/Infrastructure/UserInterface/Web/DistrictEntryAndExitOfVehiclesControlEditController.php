<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\VehiclePassenger\Application\FindByDistrictEntryAndExitOfVehiclesControl\FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl;
use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\RelatedEntities;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictEntryAndExitOfVehiclesControlEditController extends WebController
{
    public function __invoke(
        Request                                                      $request,
        DistrictEntryAndExitOfVehiclesControlFinder                  $finder,
        RelatedEntities                                              $relatedEntities,
        FindVehiclePassengersByDistrictEntryAndExitOfVehiclesControl $findVehiclePassengersByDistrictEntryAndExitOfVehiclesControl
    ): Response
    {
        $districtEntryAndExitOfVehiclesControl = $finder->__invoke($request->get('id'));


        return $this->render(
            TwigTemplateConstants::FORM_FILE_PATH,
            [
                'page_title'              => TwigTemplateConstants::SECTION_TITLE,
                'list_path'               => TwigTemplateConstants::LIST_PATH,
                'id'                      => $districtEntryAndExitOfVehiclesControl->getId(),
                'vehicle_passengers'      => $findVehiclePassengersByDistrictEntryAndExitOfVehiclesControl->__invoke($districtEntryAndExitOfVehiclesControl->getId()),
                'license_plate'           => $districtEntryAndExitOfVehiclesControl->getLicensePlate(),
                'vehicle_body_type_id'    => $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getvehicleBodyType()->getId(),
                'vehicle_maker_name_id'   => $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getVehicleMakerName()->getId(),
                'model_of_vehicle_id'     => $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getId(),
                'trip_origin_id'          => $districtEntryAndExitOfVehiclesControl->gettripOrigin()->getId(),
                'trip_destination_id'     => $districtEntryAndExitOfVehiclesControl->getTripDestination()->getId(),
                'reason_for_trip_id'      => $districtEntryAndExitOfVehiclesControl->getReasonForTrip()->getId(),
                'traffic_police_booth_id' => $districtEntryAndExitOfVehiclesControl->getTrafficPoliceBooth()->getId(),
                'vehicle_body_types'      => $relatedEntities->getAllvehicleBodyTypesSortAlphabetically(),
                'vehicle_makers_name'     => $relatedEntities->getAllVehicleMakersNameWithHisVehicleBodyTypeSortAlphabetically(),
                'models_of_vehicle'       => $relatedEntities->getAllModelsOfVehicleSortAlphabetically(),
                'districts'               => $relatedEntities->getAllDistrictsSortAlphabetically(),
                'reasons_for_trip'        => $relatedEntities->getAllReasonsForTriSortAlphabetically(),
                'traffic_police_booths'   => $relatedEntities->getAllTrafficPoliceBoothsSortAlphabetically(),
                'identity_card_types'     => $relatedEntities->getAllIdentityCardTypesSortAlphabetically(),
                'form_action_attribute'   => TwigTemplateConstants::UPDATE_PATH,
                'submit_button_label'     => FormConstant::SUBMIT_BUTTON_VALUE_TO_UPDATE,
                'action_to_do'            => FormConstant::UPDATE_LABEL_TEXT,
                'is_admin'                => $this->isAdmin()
            ]
        );
    }

    private function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->getUser()->getRoles());
    }
}
