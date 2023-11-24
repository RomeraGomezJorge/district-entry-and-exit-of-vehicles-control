<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\UserInterface\Web;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class ValidationRulesToCreateAndUpdate
{
    public static function verify($request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection([
            'id'                      => new Assert\Uuid(),
            'csrf_token'              => new Assert\NotBlank(),
            'license_plate'           => [new Assert\NotBlank(), new Assert\Length(null, null, 100)],
            'vehicle_body_type_id'    => new Assert\Uuid(),
            'vehicle_maker_name_id'   => new Assert\Uuid(),
            'model_of_vehicle_id'     => new Assert\Uuid(),
            'trip_origin_id'          => new Assert\Uuid(),
            'trip_destination_id'     => new Assert\Uuid(),
            'reason_for_trip_id'      => new Assert\Uuid(),
            'traffic_police_booth_id' => new Assert\Uuid(),
            'vehicle_passenger'       => new Assert\Optional([
                new Assert\Type('array'),
                new Assert\Count(['min' => 1]),
                new Assert\All([
                    new Assert\Collection([
                        'name'               => [new Assert\NotBlank(), new Assert\Length(null, null, 100)],
                        'surname'            => [new Assert\NotBlank(), new Assert\Length(null, null, 100)],
                        'identityCardTypeId' => [new Assert\NotBlank()],
                        'identityCard'       => [new Assert\NotBlank(), new Assert\Length(null, 8), new Assert\Positive()],
                        'phone'              => [new Assert\Optional(), new Assert\Length(null, null, 100)],
                        'address'            => [new Assert\Optional(), new Assert\Length(null, null, 100)],
                        'temperatureControl' => [new Assert\Range(['min' => '35', 'max' => '42'])],
                    ]),
                ]),
            ]),
        ]);


        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }
}
