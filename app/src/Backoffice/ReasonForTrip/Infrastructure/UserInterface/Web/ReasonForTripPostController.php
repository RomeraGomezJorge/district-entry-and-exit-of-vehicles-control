<?php

namespace App\Backoffice\ReasonForTrip\Infrastructure\UserInterface\Web;

use App\Backoffice\ReasonForTrip\Application\Create\ReasonForTripCreator;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReasonForTripPostController extends WebController
{
    public function __invoke(Request $request, ReasonForTripCreator $creator): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectWithMessage('error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE);
        }

        $validationErrors = ValidationRulesToCreateAndUpdate::verify($request);

        return $validationErrors->count()
            ? $this->redirectWithErrors(TwigTemplateConstants::CREATE_PATH, $validationErrors, $request)
            : $this->create($request, $creator);
    }

    private function create(Request $request, ReasonForTripCreator $creator)
    {
        $creator->__invoke(
            $request->get('id'),
            $request->get('description')
        );

        return $this->redirectWithMessage(
            TwigTemplateConstants::LIST_PATH,
            MessageConstant::SUCCESS_MESSAGE_TO_CREATE
        );
    }
}
