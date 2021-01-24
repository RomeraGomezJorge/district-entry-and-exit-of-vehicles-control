<?php
	
	
	namespace App\Backoffice\User\Infrastructure\UserInterface\Web;
	
	
	use App\Backoffice\User\Application\EmailChecker\CheckUserEmailAvailability;
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Request;
	
	
	final class UserEmailAvailableController extends WebController
	{
		public function __invoke( Request  $request, CheckUserEmailAvailability $CheckUserEmailAvailability):JsonResponse
		{
			return new JsonResponse(
				$CheckUserEmailAvailability->__invoke($request->get('email',''))
			);
		}
	}