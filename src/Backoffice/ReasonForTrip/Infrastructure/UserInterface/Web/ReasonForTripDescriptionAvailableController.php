<?php
	
	namespace App\Backoffice\ReasonForTrip\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Backoffice\ReasonForTrip\Application\DescriptionChecker\CheckReasonForTripDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	final class ReasonForTripDescriptionAvailableController extends WebController
	{
		public function __invoke(
			Request $request,
			CheckReasonForTripDescriptionAvailability $checkReasonForTripDescriptionAvailability
		): JsonResponse {
			return new JsonResponse(
				$checkReasonForTripDescriptionAvailability->__invoke($request->get('description', ''))
			);
		}
	}