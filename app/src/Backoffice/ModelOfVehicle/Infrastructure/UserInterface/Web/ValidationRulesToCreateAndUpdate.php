<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\UserInterface\Web;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

final class ValidationRulesToCreateAndUpdate
{
    public static function verify($request): ConstraintViolationListInterface
    {
        $constraint = new Assert\Collection(
            [
                'id'                 => new Assert\Uuid(),
                'description'        => [new Assert\NotBlank(), new Assert\Length(null, null, 100)],
                'csrf_token'         => new Assert\NotBlank(),
                'vehicleMakerNameId' => new Assert\Uuid(),
                'vehicleBodyTypeId'  => new Assert\Uuid(),]
        );

        $input = $request->request->all();

        return Validation::createValidator()->validate($input, $constraint);
    }
}
