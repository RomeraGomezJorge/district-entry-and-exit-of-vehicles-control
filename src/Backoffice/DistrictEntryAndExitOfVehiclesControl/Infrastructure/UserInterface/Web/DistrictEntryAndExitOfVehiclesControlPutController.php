<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Update\DistrictEntryAndExitOfVehiclesControlUpdater;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class DistrictEntryAndExitOfVehiclesControlPutController extends WebController
{
    public function __invoke(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlUpdater $updater
    ): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid( $request->get( 'id' ), $request->get( 'csrf_token' ) );
        
        if ( !$isCsrfTokenValid ) {
            return $this->redirectWithMessage( 'error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE );
        }
        
        $validationErrors = ValidationRulesToCreateAndUpdate::verify( $request );
        
        return $validationErrors->count() ? $this->redirectWithErrors( TwigTemplateConstants::EDIT_PATH,
            $validationErrors,
            $request ) : $this->update( $request, $updater );
    }
    
    private function update(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlUpdater $updater
    )
    {
        $updater->__invoke( $request->get( 'id' ),
            $request->get( 'licensePlate' ),
            $request->get( 'modelOfVehicleId' ),
            $request->get( 'tripOriginId' ),
            $request->get( 'tripDestinationId' ),
            $request->get( 'reasonForTripId' ),
            $request->get( 'trafficPoliceBoothId' ),
            $request->get( 'vehiclePassenger' ) );
        
        return $this->redirectWithMessage( TwigTemplateConstants::LIST_PATH,
            MessageConstant::SUCCESS_MESSAGE_TO_UPDATE );
    }
    
}