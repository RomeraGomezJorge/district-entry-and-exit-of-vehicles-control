<?php
	
	
	namespace App\Backoffice\District\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	
	
	use App\Backoffice\District\Application\DescriptionChecker\CheckDistrictDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	
	final class DistrictDescriptionAvailableController extends WebController
	{
		public function __invoke(
			Request $request,
			CheckDistrictDescriptionAvailability $tagFinderByDescription
		): JsonResponse {
			return new JsonResponse(
				$tagFinderByDescription->__invoke($request->get('description', ''))
			);
		}
	}