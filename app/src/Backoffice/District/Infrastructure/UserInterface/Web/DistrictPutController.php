<?php

namespace App\Backoffice\District\Infrastructure\UserInterface\Web;

use App\Backoffice\District\Application\Update\DistrictUpdater as Updater;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictPutController extends WebController
{
    public function __invoke(Request $request, Updater $updater): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectOnInvalidCsrfToken();
        }

        $validationErrors = ValidationRulesToCreateAndUpdate::verify($request);

        return ($validationErrors->count())
            ? $this->redirectWithErrors(TwigTemplateConstants::EDIT_PATH, $validationErrors, $request)
            : $this->update($request, $updater);
    }

    private function update(Request $request, Updater $updater): RedirectResponse
    {
        $updater->__invoke(
            $request->get('id'),
            $request->get('description')
        );

        return $this->redirectWithSuccessUpdateMessage(TwigTemplateConstants::LIST_PATH);

    }
}
