<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Delete;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;

final class DistrictEntryAndExitOfVehiclesControlDeleter
{
    private DistrictEntryAndExitOfVehiclesControlRepository $repository;
    
    private DistrictEntryAndExitOfVehiclesControlFinder     $finder;
    
    public function __construct(
        DistrictEntryAndExitOfVehiclesControlRepository $repository
    )
    {
        $this->repository = $repository;
        $this->finder = new DistrictEntryAndExitOfVehiclesControlFinder( $repository );
    }
    
    public function __invoke( string $id )
    {
        $districtEntryAndExitOfVehiclesControl = $this->finder->__invoke( $id );
        
        $this->repository->delete( $districtEntryAndExitOfVehiclesControl );
    }
    
}