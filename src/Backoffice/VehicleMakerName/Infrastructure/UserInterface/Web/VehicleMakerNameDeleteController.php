<?php
	
	
	namespace App\Backoffice\VehicleMakerName\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Constant\MessageConstant;
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Backoffice\VehicleMakerName\Application\Delete\VehicleMakerNameDeleter;
	use App\Shared\Infrastructure\UserInterface\Web\ValidationRulesToDelete;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	class VehicleMakerNameDeleteController extends WebController
	{
		public function __invoke(Request $request, VehicleMakerNameDeleter $deleter): JsonResponse
		{
			$isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));
			
			if (!$isCsrfTokenValid) {
				return new JsonResponse(array(
					'status' => 'fail_invalid_csfr_token',
					'message' => MessageConstant::INVALID_TOKEN_CSFR_MESSAGE
				));
			}
			
			$validationErrors = ValidationRulesToDelete::verify($request);
			
			$response = $validationErrors->count() ?
				array('status' => 'fail', 'message' => MessageConstant::UNEXPECTED_ERROR_HAS_OCCURRED) :
				$this->delete($deleter, $request->get('id'));
			
			return new JsonResponse($response);
		}
		
		private function delete(VehicleMakerNameDeleter $deleter, string $id): array
		{
			$deleter->__invoke($id);
			
			return array('status' => 'success');
		}
	}
	