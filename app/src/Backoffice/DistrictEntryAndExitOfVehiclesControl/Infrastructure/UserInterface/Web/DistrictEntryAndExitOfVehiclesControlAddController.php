<?php
	
	namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Constant\FormConstant;
	use App\Shared\Infrastructure\RamseyUuidGenerator;
	use App\Shared\Infrastructure\RelatedEntities;
	use App\Shared\Infrastructure\Symfony\FlashSession;
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\Response;
	
	class DistrictEntryAndExitOfVehiclesControlAddController extends WebController
	{
		public function __invoke(
			FlashSession $flashSession,
			RamseyUuidGenerator $ramseyUuidGenerator,
			RelatedEntities $relatedEntities,
			PassengersInFlashSession $passengersInFlashSession
		): Response {
			return $this->render(TwigTemplateConstants::FORM_FILE_PATH,
				[
					'list_path' => TwigTemplateConstants::LIST_PATH,
					'page_title' => TwigTemplateConstants::SECTION_TITLE,
					'id' => $ramseyUuidGenerator->generate(),
					'vehicle_passengers' => $passengersInFlashSession->__invoke(),
					'license_plate' => $flashSession->get('inputs.license_plate'),
					'vehicle_body_type_id' => $this->settingDefaultIfVehicleBodyTypeIdIsEmpty($relatedEntities,
						$flashSession),
					'vehicle_maker_name_id' => $flashSession->get('inputs.vehicle_maker_name_id'),
					'model_of_vehicle_id' => $flashSession->get('inputs.model_of_vehicle_id'),
					'trip_origin_id' => $flashSession->get('inputs.tripOriginId'),
					'trip_destination_id' => $flashSession->get('inputs.tripDestinationId'),
					'reason_for_trip_id' => $flashSession->get('inputs.reasonForTripId'),
					'traffic_police_booth_id' => $this->trafficPoliceBoothId($flashSession),
					'vehicle_body_types' => $relatedEntities->getAllVehicleBodyTypesSortAlphabetically(),
					'vehicle_makers_name' => $relatedEntities->getAllVehicleMakersNameWithHisVehicleBodyTypeSortAlphabetically(),
					'models_of_vehicle' => $relatedEntities->getAllModelsOfVehicleSortAlphabetically(),
					'districts' => $relatedEntities->getAllDistrictsSortAlphabetically(),
					'reasons_for_trip' => $relatedEntities->getAllReasonsForTriSortAlphabetically(),
					'traffic_police_booths' => $relatedEntities->getAllTrafficPoliceBoothsSortAlphabetically(),
					'identity_card_types' => $relatedEntities->getAllIdentityCardTypesSortAlphabetically(),
					'form_action_attribute' => TwigTemplateConstants::CREATE_PATH,
					'submit_button_label' => FormConstant::SUBMIT_BUTTON_VALUE_TO_CREATE,
					'action_to_do' => FormConstant::CREATE_LABEL_TEXT,
					'is_admin' => $this->isAdmin()
				]);
		}
		
		private function settingDefaultIfVehicleBodyTypeIdIsEmpty(
			RelatedEntities $relatedEntities,
			FlashSession $flashSession
		) {
			if (!empty($flashSession->get('inputs.vehicle_body_type_id'))) {
				return $flashSession->get('inputs.vehicle_body_type_id');
			}
			
			$vehicleBodyTypes = $relatedEntities->getAllVehicleBodyTypesSortAlphabetically();
			
			return $defaultVehicleBodyTypeIdValue = isset($vehicleBodyTypes[0]) ? $vehicleBodyTypes[0]->getId() : '';
		}
		
		private function isAdmin(): bool
		{
			return in_array( 'ROLE_ADMIN',$this->getUser()->getRoles());
		}
		
		private function trafficPoliceBoothId($flashSession): ?string
		{
			return $this->isAdmin()
				? $flashSession->get('inputs.traffic_police_booth_id')
				: $this->getUser()->getTrafficPoliceBooth()->getId();
		}
	}
