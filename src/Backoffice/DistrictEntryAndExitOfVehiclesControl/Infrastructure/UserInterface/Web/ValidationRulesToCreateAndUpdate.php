<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

final class ValidationRulesToCreateAndUpdate
{
    
    public static function verify( $request ): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection( [ 'id'                   => new Assert\Uuid(),
                                               'csrf_token'           => new Assert\NotBlank(),
                                               'licensePlate'         => new Assert\NotBlank(),
                                               'vehicleBodyTypeId'    => new Assert\Uuid(),
                                               'vehicleMakerNameId'   => new Assert\Uuid(),
                                               'modelOfVehicleId'     => new Assert\Uuid(),
                                               'tripOriginId'         => new Assert\Uuid(),
                                               'tripDestinationId'    => new Assert\Uuid(),
                                               'reasonForTripId'      => new Assert\Uuid(),
                                               'trafficPoliceBoothId' => new Assert\Uuid(),
                                               'vehiclePassenger'     => new Assert\Optional() ] );
        
        $input = $request->request->all();
        
        return Validation::createValidator()->validate( $input, $constraint );
    }
    
}