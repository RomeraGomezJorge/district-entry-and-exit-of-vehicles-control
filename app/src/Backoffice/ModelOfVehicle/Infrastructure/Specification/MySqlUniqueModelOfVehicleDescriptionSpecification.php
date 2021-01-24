<?php

declare( strict_types = 1 );

namespace App\Backoffice\ModelOfVehicle\Infrastructure\Specification;

use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
use App\Backoffice\ModelOfVehicle\Infrastructure\Persistence\MySqlModelOfVehicleRepository;

final class MySqlUniqueModelOfVehicleDescriptionSpecification implements UniqueModelOfVehicleDescriptionSpecification
{
    private MySqlModelOfVehicleRepository $repository;
    
    public function __construct( MySqlModelOfVehicleRepository $repository )
    {
        $this->repository = $repository;
    }
    
    public function isSatisfiedBy(
        string $description,
        ?string $vehicleMakerNameId
    ): bool
    {
        return !$this->repository->isDescriptionExits( [ 'description' => $description ],
            $vehicleMakerNameId );
    }
    
}