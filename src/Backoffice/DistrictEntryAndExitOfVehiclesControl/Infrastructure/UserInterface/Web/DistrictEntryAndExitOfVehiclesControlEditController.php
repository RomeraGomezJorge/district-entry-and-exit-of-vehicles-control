<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;

class DistrictEntryAndExitOfVehiclesControlEditController extends WebController
{
    public function __invoke(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlFinder $finder,
        RelatedEntities $relatedEntities
    ): Response
    {
        $districtEntryAndExitOfVehiclesControl = $finder->__invoke( $request->get( 'id' ) );
        
        return $this->render( TwigTemplateConstants::FORM_FILE_PATH,
            [ 'page_title'            => TwigTemplateConstants::SECTION_TITLE,
              'list_path'             => TwigTemplateConstants::LIST_PATH,
              'id'                    => $districtEntryAndExitOfVehiclesControl->getId(),
              'licensePlate'          => $districtEntryAndExitOfVehiclesControl->getLicensePlate(),
              'vehicleBodyTypeId'     => $districtEntryAndExitOfVehiclesControl->getvehicleBodyType()->getId(),
              'vehicleMakerNameId'    => $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getVehicleMakerName()->getId(),
              'modelOfVehicleId'      => $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getId(),
              'tripOriginId'          => $districtEntryAndExitOfVehiclesControl->gettripOrigin()->getId(),
              'tripDestinationId'     => $districtEntryAndExitOfVehiclesControl->getTripDestination()->getId(),
              'reasonForTripId'       => $districtEntryAndExitOfVehiclesControl->getReasonForTrip()->getId(),
              'trafficPoliceBoothId'  => $districtEntryAndExitOfVehiclesControl->getTrafficPoliceBooth()->getId(),
              'vehicleBodyTypes'      => $relatedEntities->getAllvehicleBodyTypesSortAlphabetically(),
              'vehicleMakersName'     => $relatedEntities->getAllVehicleMarkersNameSortAlphabetically(),
              'modelsOfVehicle'       => $relatedEntities->getAllModelsOfVehicleSortAlphabetically(),
              'districts'             => $relatedEntities->getAllDistrictsSortAlphabetically(),
              'reasonsForTrip'        => $relatedEntities->getAllReasonsForTriSortAlphabetically(),
              'trafficPoliceBooths'   => $relatedEntities->getAllTrafficPoliceBoothsSortAlphabetically(),
              'form_action_attribute' => TwigTemplateConstants::UPDATE_PATH,
              'submit_button_label'   => FormConstant::SUBMIT_BUTTON_VALUE_TO_UPDATE,
              'action_to_do'          => FormConstant::UPDATE_LABEL_TEXT ] );
    }
    
}
