<?php
	
	namespace App\ResetPasswordRequest\Infrastructure\UserInterface\Web;
	
	use App\Shared\Infrastructure\Symfony\WebController;
	use Symfony\Component\HttpFoundation\Response;
	use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
	
	class EmailMessageSentController extends WebController
	{
		use ResetPasswordControllerTrait;
		
		/**
		 * Página de confirmación después de que un usuario haya solicitado un restablecimiento de contraseña.
		 */
		public function __invoke(): Response
		{
			/* Evitamos que los usuarios accedan directamente a esta página. */
			if (null === ($resetToken = $this->getTokenObjectFromSession())) {
				return $this->redirectToRoute(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH);
			}
			
			return $this->render(TwigTemplateConstants::EMAIL_MESSAGE_SENT_FILE_PATH, [
				'goBackLink' => TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH,
				'emailMessageSentImage' => TwigTemplateConstants::EMAIL_MESSAGE_SENT_IMAGE,
				'resetToken' => $resetToken
			]);
		}
	}
