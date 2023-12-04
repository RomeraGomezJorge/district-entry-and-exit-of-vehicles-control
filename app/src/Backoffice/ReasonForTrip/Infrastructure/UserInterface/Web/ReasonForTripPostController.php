<?php

namespace App\Backoffice\ReasonForTrip\Infrastructure\UserInterface\Web;

use App\Backoffice\ReasonForTrip\Application\Create\ReasonForTripCreator as Creator;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReasonForTripPostController extends WebController
{
    public function __invoke(Request $request, Creator $creator): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectOnInvalidCsrfToken();
        }

        $validationErrors = ValidationRulesToCreateAndUpdate::verify($request);

        return ($validationErrors->count())
            ? $this->redirectWithErrors(TwigTemplateConstants::CREATE_PATH, $validationErrors, $request)
            : $this->create($request, $creator);
    }

    private function create(Request $request, Creator $creator): RedirectResponse
    {
        $creator->__invoke(
            $request->get('id'),
            $request->get('description')
        );

        return $this->redirectWithSuccessCreateMessage(TwigTemplateConstants::LIST_PATH);
    }
}
