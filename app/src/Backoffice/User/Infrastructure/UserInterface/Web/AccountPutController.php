<?php

namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

use App\Backoffice\User\Application\Update\AccountUpdater;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class AccountPutController extends WebController
{
    public function __invoke(
        Request $request,
        AccountUpdater $updater
    ): Response {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectOnInvalidCsrfToken();
        }

        $validationErrors = $this->validateRequest($request);

        return $validationErrors->count()
            ? $this->redirectWithErrors(TwigTemplateConstants::EDIT_PATH, $validationErrors, $request)
            : $this->update($request, $updater);
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'         => new Assert\Uuid(),
                'username'   => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'name'       => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'surname'    => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'email'      => [new Assert\NotBlank(), new Assert\Email()],
                'csrf_token' => [new Assert\NotBlank()]
            ]
        );

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    private function update(Request $request, AccountUpdater $updater)
    {
        $updater->__invoke(
            $request->get('id'),
            $request->get('username'),
            $request->get('name'),
            $request->get('surname'),
            $request->get('email')
        );

        return $this->redirectWithMessage(
            'user_account_management',
            MessageConstant::SUCCESS_MESSAGE_TO_UPDATE
        );
    }
}
