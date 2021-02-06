<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use App\Shared\Infrastructure\Constant\MessageConstant;
use App\Shared\Infrastructure\Symfony\WebController;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Create\DistrictEntryAndExitOfVehiclesControlCreator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictEntryAndExitOfVehiclesControlPostController extends WebController
{
    public function __invoke(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlCreator $creator
    ): Response
    {
        $isCsrfTokenValid = $this->isCsrfTokenValid( $request->get( 'id' ), $request->get( 'csrf_token' ) );
        
        if ( !$isCsrfTokenValid ) {
            return $this->redirectWithMessage( 'error_page', MessageConstant::INVALID_TOKEN_CSFR_MESSAGE );
        }
        
        $validationErrors = ValidationRulesToCreateAndUpdate::verify( $request );
        
        return $validationErrors->count() ? $this->redirectWithErrors( TwigTemplateConstants::CREATE_PATH,
            $validationErrors,
            $request ) : $this->create( $request, $creator );
    }
    
    private function create(
        Request $request,
        DistrictEntryAndExitOfVehiclesControlCreator $creator
    )
    {
        $creator->__invoke( $request->get( 'id' ),
            $request->get( 'licensePlate' ),
            $request->get( 'modelOfVehicleId' ),
            $request->get( 'tripOriginId' ),
            $request->get( 'tripDestinationId' ),
            $request->get( 'reasonForTripId' ),
            $request->get( 'trafficPoliceBoothId' ),
            $request->get( 'vehiclePassenger' ) );
        
        return $this->redirectWithMessage( TwigTemplateConstants::LIST_PATH,
            MessageConstant::SUCCESS_MESSAGE_TO_CREATE );
    }
    
}
