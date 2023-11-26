<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Delete\DistrictEntryAndExitOfVehiclesControlDeleter as Deleter;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Shared\Infrastructure\UserInterface\Web\ValidationRulesToDelete;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DistrictEntryAndExitOfVehiclesControlDeleteController extends WebController
{
    public function __invoke(Request $request, Deleter $deleter): JsonResponse
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid($request->get('id'), $request->get('csrf_token'));

        if (!$isCsrfTokenValid) {
            return $this->jsonResponseOnInvalidCsrfToken();
        }

        $validationErrors = ValidationRulesToDelete::verify($request);

        return ($validationErrors->count())
            ? $this->jsonResponseUnexpectedErrorOnDelete()
            : $this->delete($deleter, $request->get('id'));
    }

    private function delete(Deleter $deleter, string $id): JsonResponse
    {
        try {
            $deleter->__invoke($id);
            return $this->jsonResponseSuccess();
        } catch (\Exception $exception) {
            return $this->jsonResponseFail($exception->getMessage());
        }
    }
}
