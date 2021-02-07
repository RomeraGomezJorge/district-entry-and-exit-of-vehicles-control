<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Constant\MessageConstant;
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Backoffice\ModelOfVehicle\Application\Update\ModelOfVehicleUpdater;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Validator\ConstraintViolationListInterface;
	use Symfony\Component\Validator\Constraints as Assert;
	use Symfony\Component\Validator\Validation;
	
	
	class ModelOfVehiclePutController extends WebController
	{
		public function __invoke(Request $request, ModelOfVehicleUpdater $updater): Response
		{
			$isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));
			
			if (!$isCsrfTokenValid) {
				return $this->redirectWithMessage('error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE);
			}
			
			$validationErrors = ValidationRulesToCreateAndUpdate::verify($request);
			
			return $validationErrors->count()
				? $this->redirectWithErrors(TwigTemplateConstants::EDIT_PATH, $validationErrors, $request)
				: $this->update($request, $updater);
		}
		
		private function update(Request $request, ModelOfVehicleUpdater $updater)
		{
			$updater->__invoke(
				$request->get('id'),
				$request->get('description'),
                $request->get( 'vehicleMakerName_id' ),
                $request->get( 'vehicleBodyTypeId' )
			);
			
			return $this->redirectWithMessage(
				TwigTemplateConstants::LIST_PATH,
				MessageConstant::SUCCESS_MESSAGE_TO_UPDATE
			);
		}
	}
