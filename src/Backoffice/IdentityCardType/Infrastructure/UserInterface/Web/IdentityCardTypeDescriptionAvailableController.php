<?php
	
	namespace App\Backoffice\IdentityCardType\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	use App\Backoffice\IdentityCardType\Application\DescriptionChecker\CheckIdentityCardTypeDescriptionAvailability;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	final class IdentityCardTypeDescriptionAvailableController extends WebController
	{
		public function __invoke(
			Request $request,
			CheckIdentityCardTypeDescriptionAvailability $checkIdentityCardTypeDescriptionAvailability
		): JsonResponse {
			return new JsonResponse(
				$checkIdentityCardTypeDescriptionAvailability->__invoke($request->get('description', ''))
			);
		}
	}