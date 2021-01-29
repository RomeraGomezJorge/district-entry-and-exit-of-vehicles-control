<?php
	
	
	namespace App\Backoffice\VehicleBodyType\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	
	
	use App\Backoffice\VehicleBodyType\Application\DescriptionChecker\CheckVehicleBodyTypeDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	
	final class VehicleBodyTypeDescriptionAvailableController extends WebController
	{
		public function __invoke(
			Request $request,
			CheckVehicleBodyTypeDescriptionAvailability $tagFinderByDescription
		): JsonResponse {
			return new JsonResponse(
				$tagFinderByDescription->__invoke($request->get('description', ''))
			);
		}
	}