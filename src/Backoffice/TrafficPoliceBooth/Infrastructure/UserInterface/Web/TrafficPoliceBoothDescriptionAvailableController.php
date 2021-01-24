<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	
	
	use App\Backoffice\TrafficPoliceBooth\Application\DescriptionChecker\CheckTrafficPoliceBoothDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	
	final class TrafficPoliceBoothDescriptionAvailableController extends WebController
	{
		public function __invoke( Request  $request, CheckTrafficPoliceBoothDescriptionAvailability $tagFinderByDescription):JsonResponse
		{
			return new JsonResponse(
				$tagFinderByDescription->__invoke($request->get('description',''))
			);
		}
	}