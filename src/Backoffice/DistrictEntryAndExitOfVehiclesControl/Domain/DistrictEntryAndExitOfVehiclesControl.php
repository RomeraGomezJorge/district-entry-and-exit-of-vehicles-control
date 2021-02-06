<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain;

use App\Backoffice\District\Domain\District;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTrip;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use DateTime;

class DistrictEntryAndExitOfVehiclesControl extends AggregateRoot
{
    private $id;
    
    private $licensePlate;
    
    private $modelOfVehicle;
    
    private $tripOrigin;
    
    private $tripDestination;
    
    private $reasonForTrip;
    
    private $trafficPoliceBooth;
    
    private $createAt;
    
    private $updateAt;
    
    public static function create(
        Uuid $id,
        string $licensePlate,
        ModelOfVehicle $modelOfVehicle,
        District $tripOrigin,
        District $tripDestination,
        ReasonForTrip $reasonForTrip,
        TrafficPoliceBooth $trafficPoliceBooth,
        DateTime $createAt
    ): self
    {
        $districtEntryAndExitOfVehiclesControl = new self();
        $districtEntryAndExitOfVehiclesControl->id = $id;
        $districtEntryAndExitOfVehiclesControl->licensePlate = $licensePlate;
        $districtEntryAndExitOfVehiclesControl->modelOfVehicle = $modelOfVehicle;
        $districtEntryAndExitOfVehiclesControl->tripOrigin = $tripOrigin;
        $districtEntryAndExitOfVehiclesControl->tripDestination = $tripDestination;
        $districtEntryAndExitOfVehiclesControl->reasonForTrip = $reasonForTrip;
        $districtEntryAndExitOfVehiclesControl->trafficPoliceBooth = $trafficPoliceBooth;
        $districtEntryAndExitOfVehiclesControl->createAt = $createAt;
        $districtEntryAndExitOfVehiclesControl->updateAt = new \DateTime();
        $districtEntryAndExitOfVehiclesControl->record( new DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent( $id->value(),
                $licensePlate,
                $modelOfVehicle->getId(),
                $tripOrigin->getId(),
                $tripDestination->getId(),
                $reasonForTrip->getId(),
                $trafficPoliceBooth->getId() ) );
        return $districtEntryAndExitOfVehiclesControl;
    }
    
    public function getId(): ?String
    {
        return $this->id;
    }
    
    public function setId( Uuid $id ): void
    {
        $this->id = $id;
    }
    
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }
    
    public function setLicensePlate( string $licensePlate ): void
    {
        $this->licensePlate = $licensePlate;
    }
    
    public function getModelOfVehicle(): ModelOfVehicle
    {
        return $this->modelOfVehicle;
    }
    
    public function setModelOfVehicle( ModelOfVehicle $modelOfVehicle ): void
    {
        $this->modelOfVehicle = $modelOfVehicle;
    }
    
    public function getTripOrigin(): District
    {
        return $this->tripOrigin;
    }
    
    public function setTripOrigin( District $tripOrigin ): void
    {
        $this->tripOrigin = $tripOrigin;
    }
    
    public function getTripDestination(): District
    {
        return $this->tripDestination;
    }
    
    public function setTripDestination( District $tripDestination ): void
    {
        $this->tripDestination = $tripDestination;
    }
    
    public function getReasonForTrip(): ReasonForTrip
    {
        return $this->reasonForTrip;
    }
    
    public function setReasonForTrip( ReasonForTrip $reasonForTrip ): void
    {
        $this->reasonForTrip = $reasonForTrip;
    }
    
    public function getTrafficPoliceBooth(): TrafficPoliceBooth
    {
        return $this->trafficPoliceBooth;
    }
    
    public function setTrafficPoliceBooth( TrafficPoliceBooth $trafficPoliceBooth ): void
    {
        $this->trafficPoliceBooth = $trafficPoliceBooth;
    }
    
    public function getCreateAt()
    {
        return $this->createAt;
    }
    
    public function setCreateAt( $createAt ): void
    {
        $this->createAt = $createAt;
    }
    
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
    
    public function setUpdateAt( $updateAt ): void
    {
        $this->updateAt = $updateAt;
    }
    
}
