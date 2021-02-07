<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Update;

use App\Backoffice\District\Application\Find\DistrictFinder;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
use App\Shared\Infrastructure\Utils\StringUtils;

final class DistrictEntryAndExitOfVehiclesControlUpdater
{
    private DistrictEntryAndExitOfVehiclesControlRepository $repository;
    
    private DistrictEntryAndExitOfVehiclesControlFinder     $finder;
    
    private VehicleBodyTypeFinder                           $finderVehicleBodyType;
    
    private ModelOfVehicleFinder                            $finderModelOfVehicle;
    
    private DistrictFinder                                  $finderDistrict;
    
    private ReasonForTripFinder                             $finderReasonForTrip;
    
    private TrafficPoliceBoothFinder                        $finderTrafficPoliceBooth;
    
    public function __construct(
        DistrictEntryAndExitOfVehiclesControlRepository $repository,
        VehicleBodyTypeRepository $vehicleBodyTypeRepository,
        ModelOfVehicleRepository $modelOfVehicleRepository,
        DistrictRepository $districtRepository,
        ReasonForTripRepository $reasonForTripRepository,
        TrafficPoliceBoothRepository $trafficPoliceBoothRepository
    )
    {
        $this->repository = $repository;
        $this->finder = new DistrictEntryAndExitOfVehiclesControlFinder( $repository );
        $this->finderVehicleBodyType = new VehicleBodyTypeFinder( $vehicleBodyTypeRepository );
        $this->finderModelOfVehicle = new ModelOfVehicleFinder( $modelOfVehicleRepository );
        $this->finderDistrict = new DistrictFinder( $districtRepository );
        $this->finderReasonForTrip = new ReasonForTripFinder( $reasonForTripRepository );
        $this->finderTrafficPoliceBooth = new TrafficPoliceBoothFinder( $trafficPoliceBoothRepository );
    }
    
    public function __invoke(
        string $id,
        string $newLicensePlate,
        string $newVehicleBodyTypeId,
        string $newModelOfVehicleId,
        string $newTripOriginId,
        string $newTripDestinationId,
        string $newReasonForTripId,
        string $newTrafficPoliceBoothId,
        array $newVehiclePassengers
    ): void
    {
        $districtEntryAndExitOfVehiclesControl = $this->finder->__invoke( $id );
        $vehicleBodyType = $this->finderVehicleBodyType->__invoke( $newVehicleBodyTypeId );
        $modelOfVehicle = $this->finderModelOfVehicle->__invoke( $newModelOfVehicleId );
        $tripOrigin = $this->finderDistrict->__invoke( $newTripOriginId );
        $tripDestination = $this->finderDistrict->__invoke( $newTripDestinationId );
        $reasonForTrip = $this->finderReasonForTrip->__invoke( $newReasonForTripId );
        $trafficPoliceBooth = $this->finderTrafficPoliceBooth->__invoke( $newTrafficPoliceBoothId );
        
        if ( $this->hasLicensePlateChanged( $newLicensePlate, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setLicensePlate( trim( $newLicensePlate ) );
        }
        
        if ( $this->hasVehicleBodyTypeChanged( $newVehicleBodyTypeId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setVehicleBodyType( $vehicleBodyType );
        }
        if ( $this->hasModelOfVehicleChanged( $newModelOfVehicleId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setModelOfVehicle( $modelOfVehicle );
        }
        if ( $this->hasTripOriginChanged( $newTripOriginId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setTripOrigin( $tripOrigin );
        }
        
        if ( $this->hasTripDestinationChanged( $newTripDestinationId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setTripDestination( $tripDestination );
        }
        if ( $this->hasReasonForTripChanged( $newReasonForTripId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setReasonForTrip( $reasonForTrip );
        }
        if ( $this->hasTrafficPoliceBoothChanged( $newTrafficPoliceBoothId, $districtEntryAndExitOfVehiclesControl ) ) {
            $districtEntryAndExitOfVehiclesControl->setTrafficPoliceBooth( $trafficPoliceBooth );
        }
        
        $districtEntryAndExitOfVehiclesControl->setUpdateAt( new \DateTime() );
        
        $this->repository->save( $districtEntryAndExitOfVehiclesControl );
    }
    
    private function hasLicensePlateChanged(
        string $newLicensePlate,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newLicensePlate, $districtEntryAndExitOfVehiclesControl->getLicensePlate() );
    }
    
    private function hasVehicleBodyTypeChanged(
        string $newVehicleBodyType,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newVehicleBodyType,
            $districtEntryAndExitOfVehiclesControl->getVehicleBodyType()->getId() );
    }
    
    private function hasModelOfVehicleChanged(
        string $newModelOfVehicle,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newModelOfVehicle,
            $districtEntryAndExitOfVehiclesControl->getModelOfVehicle()->getId() );
    }
    
    private function hasTripOriginChanged(
        string $newTripOrigin,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newTripOrigin,
            $districtEntryAndExitOfVehiclesControl->getTripOrigin()->getId() );
    }
    
    private function hasTripDestinationChanged(
        string $tripDestination,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $tripDestination,
            $districtEntryAndExitOfVehiclesControl->getTripDestination()->getId() );
    }
    
    private function hasReasonForTripChanged(
        string $newReasonForTrip,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newReasonForTrip,
            $districtEntryAndExitOfVehiclesControl->getReasonForTrip()->getId() );
    }
    
    private function hasTrafficPoliceBoothChanged(
        string $newTrafficPoliceBooth,
        DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl
    ): bool
    {
        return !StringUtils::equals( $newTrafficPoliceBooth,
            $districtEntryAndExitOfVehiclesControl->getTrafficPoliceBooth()->getId() );
    }
    
}