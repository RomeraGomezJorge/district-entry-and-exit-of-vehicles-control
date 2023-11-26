<?php

namespace App\ResetPasswordRequest\Infrastructure\UserInterface\Web;

use App\Backoffice\User\Domain\User;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ProcessSendingPasswordResetEmailController extends WebController
{
    use ResetPasswordControllerTrait;

    private ResetPasswordHelperInterface $resetPasswordHelper;
    private MailerInterface $mailer;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, MailerInterface $mailer)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->mailer              = $mailer;
    }

    public function __invoke(Request $request): RedirectResponse
    {

        $isCsrfTokenValid = $this->isCsrfTokenValid('processSendingPasswordResetEmail', $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            $this->addFlash('reset_password_error', '<h4 class="text-danger">' . MessageConstant::INVALID_TOKEN_CSFR_MESSAGE . '</h4>');

            return $this->redirectToRoute(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH);
        }

        $validationErrors = $this->validationsRulesToSendEmail($request);


        if ($validationErrors->count()) {
            return $this->redirectWithErrors(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH, $validationErrors, $request);
        }

        $userFound = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => trim($request->get('email'))
        ]);

        /* No revelar si se encontró una cuenta de usuario o no.*/
        if (!$userFound) {
            return $this->redirectToRoute(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH);
        }


        try {
            $resetTokenForUserFound = $this->resetPasswordHelper->generateResetToken($userFound);
        } catch (ResetPasswordExceptionInterface $e) {
            /*Si desea decirle al usuario por qué no se envió un correo de reinicio,
             decomentar. las líneas de abajo y cambiar la redirección a 'forgot_password_request'.
             Precaución: Esto puede revelar si un usuario está registrado o no.*/

            $this->addFlash('reset_password_error', sprintf(
                '<h4 class="alert-heading "><i class="fas fa-times-circle text-danger"></i> Hubo un problema</h4> <p>%s</p>',
                $e->getReason()
            ));


            return $this->redirectToRoute(TwigTemplateConstants::FORGOT_PASSWORD_REQUEST_PATH);
        }

        $this->sendEmailWithLinkToResetPassword($userFound, $resetTokenForUserFound);

        /* Guarda el objeto token en sesión para su recuperación en la ruta de "EMAIL_MESSAGE_SENT_PATH". */
        $this->setTokenObjectInSession($resetTokenForUserFound);

        return $this->redirectToRoute(TwigTemplateConstants::EMAIL_MESSAGE_SENT_PATH);
    }


    private function validationsRulesToSendEmail(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'email'      => [new Assert\NotBlank(), new  Assert\Email()],
                'csrf_token' => new Assert\NotBlank()
            ]
        );

        $input = $request->request->all();

        $validationErrors = Validation::createValidator()->validate($input, $constraint);

        return $validationErrors;
    }


    private function sendEmailWithLinkToResetPassword($userFound, ResetPasswordToken $resetToken): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('cherza@hotmail.com', 'Secretaria de Seguridad'))
            ->to($userFound->getEmail())
            ->subject('Su solicitud de restablecimiento de contraseña')
            ->htmlTemplate(TwigTemplateConstants::PASSWORD_RESET_EMAIL_TEMPLATE)
            ->context([
                'fullName'   => $userFound->getSurname() . ' ' . $userFound->getName(),
                'resetToken' => $resetToken,
            ]);

        // configurar gmail https://medium.com/graymatrix/using-gmail-smtp-server-to-send-email-in-laravel-91c0800f9662
        $this->mailer->send($email);
    }
}
