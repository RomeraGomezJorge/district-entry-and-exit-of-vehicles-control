<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\District\Application\FindByCriteriaSearcher\DistrictsByCriteriaSearcher;
use App\Backoffice\ModelOfVehicle\Application\FindByCriteriaSearcher\ModelsOfVehicleByCriteriaSearcher;
use App\Backoffice\ReasonForTrip\Application\FindByCriteriaSearcher\ReasonsForTripByCriteriaSearcher;
use App\Backoffice\TrafficPoliceBooth\Application\FindByCriteriaSearcher\TrafficPoliceBoothsByCriteriaSearcher;
use App\Backoffice\VehicleBodyType\Application\FindByCriteriaSearcher\VehicleBodyTypesByCriteriaSearcher;
use App\Backoffice\VehicleMakerName\Application\FindByCriteriaSearcher\VehicleMakersNameByCriteriaSearcher;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Infrastructure\Constant\FormConstant;
use App\Shared\Infrastructure\RamseyUuidGenerator;
use App\Shared\Infrastructure\RelatedEntities;
use App\Shared\Infrastructure\Symfony\FlashSession;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Response;

class DistrictEntryAndExitOfVehiclesControlAddController extends WebController
{
    const DISPLAY_ALL_VEHICLE_MAKER_NAME = [];
    
    const SORT_A_LIST_BY_DESCRIPTION     = 'description';
    
    const SORT_A_LIST_ALPHABETICALLY     = 'asc';
    
    const LIST_BEGIN_ON_0                = 0;
    
    const LIST_END_ON_1000               = 1000;
    
    public function __invoke(
        FlashSession $flashSession,
        RamseyUuidGenerator $ramseyUuidGenerator,
        RelatedEntities $relatedEntities,
        VehicleMakerNameRepository $vehicleMakerNameRepository
    ): Response
    {
        $vehicleBodyTypes = $relatedEntities->getAllVehicleBodyTypesSortAlphabetically();
        
        $defaultVehicleBodyTypeIdValue = $flashSession->get( 'inputs.vehicleBodyTypeId' );
        
        if ( empty( $flashSession->get( 'inputs.vehicleBodyTypeId' ) ) ) {
            $defaultVehicleBodyTypeIdValue = $vehicleBodyTypes[0]->getId();
        }
        
        return $this->render( TwigTemplateConstants::FORM_FILE_PATH,
            [ 'list_path'             => TwigTemplateConstants::LIST_PATH,
              'page_title'            => TwigTemplateConstants::SECTION_TITLE,
              'id'                    => $ramseyUuidGenerator->generate(),
              'description'           => $flashSession->get( 'inputs.description' ),
              'licensePlate'          => $flashSession->get( 'inputs.licensePlate' ),
              'vehicleBodyTypeId'     => $defaultVehicleBodyTypeIdValue,
              'vehicleMakerNameId'    => $flashSession->get( 'inputs.vehicleMakerNameId' ),
              'modelOfVehicleId'      => $flashSession->get( 'inputs.modelOfVehicleId' ),
              'tripOriginId'          => $flashSession->get( 'inputs.tripOriginId' ),
              'tripDestinationId'     => $flashSession->get( 'inputs.tripDestinationId' ),
              'reasonForTripId'       => $flashSession->get( 'inputs.reasonForTripId' ),
              'trafficPoliceBoothId'  => $flashSession->get( 'inputs.trafficPoliceBoothId' ),
              'vehicleBodyTypes'      => $vehicleBodyTypes,
              'vehicleMakersName'     => $relatedEntities->getAllVehicleMakersNameWithHisVehicleBodyTypeSortAlphabetically(),
              'modelsOfVehicle'       => $relatedEntities->getAllModelsOfVehicleSortAlphabetically(),
              'districts'             => $relatedEntities->getAllDistrictsSortAlphabetically(),
              'reasonsForTrip'        => $relatedEntities->getAllReasonsForTriSortAlphabetically(),
              'trafficPoliceBooths'   => $relatedEntities->getAllTrafficPoliceBoothsSortAlphabetically(),
              'form_action_attribute' => TwigTemplateConstants::CREATE_PATH,
              'submit_button_label'   => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
              'action_to_do'          => FormConstant::CREATE_LABEL_TEXT, ] );
    }
    
}
