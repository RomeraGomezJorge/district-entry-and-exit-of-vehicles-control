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
		const EMPTY_VEHICLE_PASSENGER = array(
			0 => array(
				'name' => '',
				'surname' => '',
				'identityCard' => '',
				'phone' => '',
				'address' => '',
				'temperatureControl' => ''
			)
		);
		
		public function __invoke(
			FlashSession $flashSession,
			RamseyUuidGenerator $ramseyUuidGenerator,
			RelatedEntities $relatedEntities,
			VehicleMakerNameRepository $vehicleMakerNameRepository
		): Response {
			return $this->render(TwigTemplateConstants::FORM_FILE_PATH,
				[
					'list_path' => TwigTemplateConstants::LIST_PATH,
					'page_title' => TwigTemplateConstants::SECTION_TITLE,
					'id' => $ramseyUuidGenerator->generate(),
					'vehiclePassengers' => self::EMPTY_VEHICLE_PASSENGER,
					'licensePlate' => $flashSession->get('inputs.licensePlate'),
					'vehicleBodyTypeId' => $this->settingDefaultIfVehicleBodyTypeIdIsEmpty($relatedEntities,$flashSession),
					'vehicleMakerNameId' => $flashSession->get('inputs.vehicleMakerNameId'),
					'modelOfVehicleId' => $flashSession->get('inputs.modelOfVehicleId'),
					'tripOriginId' => $flashSession->get('inputs.tripOriginId'),
					'tripDestinationId' => $flashSession->get('inputs.tripDestinationId'),
					'reasonForTripId' => $flashSession->get('inputs.reasonForTripId'),
					'trafficPoliceBoothId' => $flashSession->get('inputs.trafficPoliceBoothId'),
					'vehicleBodyTypes' => $relatedEntities->getAllVehicleBodyTypesSortAlphabetically(),
					'vehicleMakersName' => $relatedEntities->getAllVehicleMakersNameWithHisVehicleBodyTypeSortAlphabetically(),
					'modelsOfVehicle' => $relatedEntities->getAllModelsOfVehicleSortAlphabetically(),
					'districts' => $relatedEntities->getAllDistrictsSortAlphabetically(),
					'reasonsForTrip' => $relatedEntities->getAllReasonsForTriSortAlphabetically(),
					'trafficPoliceBooths' => $relatedEntities->getAllTrafficPoliceBoothsSortAlphabetically(),
					'form_action_attribute' => TwigTemplateConstants::CREATE_PATH,
					'submit_button_label' => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
					'action_to_do' => FormConstant::CREATE_LABEL_TEXT,
				]);
		}
		
		private function settingDefaultIfVehicleBodyTypeIdIsEmpty(
			RelatedEntities $relatedEntities,
			FlashSession $flashSession
		) {
			if (!empty($flashSession->get('inputs.vehicleBodyTypeId'))) {
				return $flashSession->get('inputs.vehicleBodyTypeId');
			}
			
			$vehicleBodyTypes = $relatedEntities->getAllVehicleBodyTypesSortAlphabetically();
			
			return $defaultVehicleBodyTypeIdValue = $vehicleBodyTypes[0]->getId();
		}
	}
