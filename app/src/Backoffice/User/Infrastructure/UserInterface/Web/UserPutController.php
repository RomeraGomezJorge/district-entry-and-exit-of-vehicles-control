<?php

namespace App\Backoffice\User\Infrastructure\UserInterface\Web;

use App\Backoffice\User\Application\Update\UserUpdater as Updater;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class UserPutController extends WebController
{
    public function __invoke(Request $request, Updater $updater): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectOnInvalidCsrfToken();
        }

        $validationErrors = $this->validateRequest($request);

        return ($validationErrors->count())
            ? $this->redirectWithErrors(TwigTemplateConstants::EDIT_PATH, $validationErrors, $request)
            : $this->update($request, $updater);
    }

    private function validateRequest(Request $request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'                      => new Assert\Uuid(),
                'username'                => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'name'                    => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'surname'                 => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
                'email'                   => [new Assert\NotBlank(), new Assert\Email()],
                'role_id'                 => [new Assert\Choice(TwigTemplateConstants::USER_ROLES)],
                'traffic_police_booth_id' => new Assert\Uuid(),
                'is_active'               => [new Assert\Optional()],
                'csrf_token'              => [new Assert\NotBlank()]
            ]
        );

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }

    private function update(Request $request, Updater $updater): RedirectResponse
    {
        $isActive = $request->get('is_active') == 'on';

        $updater->__invoke(
            $request->get('id'),
            $request->get('username'),
            $request->get('name'),
            $request->get('surname'),
            $request->get('email'),
            $request->get('role_id'),
            $isActive,
            $request->get('traffic_police_booth_id')
        );

        return $this->redirectWithSuccessUpdateMessage(TwigTemplateConstants::LIST_PATH);
    }
}
