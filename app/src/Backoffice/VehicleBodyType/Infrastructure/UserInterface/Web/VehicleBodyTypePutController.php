<?php

namespace App\Backoffice\VehicleBodyType\Infrastructure\UserInterface\Web;

use App\Backoffice\VehicleBodyType\Application\Update\VehicleBodyTypeUpdater;
use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleBodyTypePutController extends WebController
{
    public function __invoke(Request $request, VehicleBodyTypeUpdater $updater): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->redirectWithMessage('error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE);
        }

        $validationErrors = ValidationRulesToCreateAndUpdate::verify($request);

        return $validationErrors->count()
            ? $this->redirectWithErrors(TwigTemplateConstants::EDIT_PATH, $validationErrors, $request)
            : $this->update($request, $updater);
    }

    private function update(Request $request, VehicleBodyTypeUpdater $updater)
    {
        $updater->__invoke(
            $request->get('id'),
            $request->get('description'),
            $request->get('image')
        );

        return $this->redirectWithMessage(
            TwigTemplateConstants::LIST_PATH,
            MessageConstant::SUCCESS_MESSAGE_TO_UPDATE
        );
    }
}
