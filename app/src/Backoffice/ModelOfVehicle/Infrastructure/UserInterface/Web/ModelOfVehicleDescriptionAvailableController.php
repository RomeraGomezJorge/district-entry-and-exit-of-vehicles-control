<?php
	
	namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Backoffice\ModelOfVehicle\Application\DescriptionChecker\CheckModelOfVehicleDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	
	final class ModelOfVehicleDescriptionAvailableController extends WebController
	{
		public function __invoke(
			Request $request,
			CheckModelOfVehicleDescriptionAvailability $checkModelOfVehicleDescriptionAvailability
		): JsonResponse {
			return new JsonResponse( $checkModelOfVehicleDescriptionAvailability->__invoke( $request->get( 'description',
                '' ),
                $request->get( 'vehicleMakerNameId', '' ) )
			);
		}
	}