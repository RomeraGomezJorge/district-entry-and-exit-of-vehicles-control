<?php

namespace App\ResetPasswordRequest\Infrastructure\UserInterface\Web;

use App\Form\ChangePasswordFormType;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class NewPasswordGetController extends WebController
{
    use ResetPasswordControllerTrait;

    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    /**
     * Valida y procesa la URL de reinicio que el usuario hizo clic en su correo electrónico.
     */
    public function __invoke(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $token = $request->get('token');

        if ($token) {
            /*Almacenamos el token en sesión y lo quitamos de la URL, para evitar que la URL
            se cargue en el navegador y sea potencialmente filtrano a terceros JavaScript.*/
            $this->storeTokenInSession($token);

            return $this->redirectToRoute(TwigTemplateConstants::RESET_PASSWORD_PATH);
        }

        $token = $this->getTokenFromSessionOrFail();

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                '<h4 class="alert-heading"><i class="fas fa-times-circle text-danger"></i>  Hubo un problema </h4><p> %s</p>',
                $e->getReason()
            ));

            return $this->redirectToRoute(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH);
        }

        return $this->render(
            TwigTemplateConstants::FORM_TO_HANDLE_NEW_PASSWORD_FILE_PATH,
            [
                'id' => $user->getId(),
            ]
        );
    }

    private function getTokenFromSessionOrFail(): string
    {
        $token = $this->getTokenFromSession();

        if (null === $token) {
            throw $this->createNotFoundException('No se encuentra ninguna contraseña de restablecimiento en la URL o en la sesión.');
        }

        return $token;
    }
}
