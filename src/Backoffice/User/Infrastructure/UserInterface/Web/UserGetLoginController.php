<?php
	
	
	namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

	use App\Shared\Infrastructure\Constant\FormConstant;
	use App\Shared\Infrastructure\RamseyUuidGenerator;
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	class UserGetLoginController  extends  WebController
	{
		public function __invoke(): Response
		{
			return $this->render('user/login.html.twig', [
				'username' => '',
				'password' => '',
			]);
		}
	}
