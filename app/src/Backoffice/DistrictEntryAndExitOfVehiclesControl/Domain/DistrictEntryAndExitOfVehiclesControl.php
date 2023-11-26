<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain;

use App\Backoffice\District\Domain\District;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTrip;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Utils\StringUtils;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

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
    private $vehiclePassengers;

    public function __construct()
    {
        $this->vehiclePassengers = new ArrayCollection();
    }

    public static function create(
        Uuid $id,
        string $licensePlate,
        ModelOfVehicle $modelOfVehicle,
        District $tripOrigin,
        District $tripDestination,
        ReasonForTrip $reasonForTrip,
        TrafficPoliceBooth $trafficPoliceBooth,
        array $vehiclePassengers,
        DateTime $createAt
    ): self {
        $districtEntryAndExitOfVehiclesControl                     = new self();
        $districtEntryAndExitOfVehiclesControl->id                 = $id;
        $districtEntryAndExitOfVehiclesControl->licensePlate       = $licensePlate;
        $districtEntryAndExitOfVehiclesControl->modelOfVehicle     = $modelOfVehicle;
        $districtEntryAndExitOfVehiclesControl->tripOrigin         = $tripOrigin;
        $districtEntryAndExitOfVehiclesControl->tripDestination    = $tripDestination;
        $districtEntryAndExitOfVehiclesControl->reasonForTrip      = $reasonForTrip;
        $districtEntryAndExitOfVehiclesControl->trafficPoliceBooth = $trafficPoliceBooth;
        $districtEntryAndExitOfVehiclesControl->createAt           = $createAt;
        $districtEntryAndExitOfVehiclesControl->updateAt           = new \DateTime();

        /* registramos el evento de haber creado un "control de ingreso" en nuestra entidad en el array
        "$this->domainEvents" que se encuentra en AggregateRoot el cual almacena todos eventos que va sucediendo */
        $districtEntryAndExitOfVehiclesControl->record(
            new DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent(
                $id->value(),
                $licensePlate,
                $modelOfVehicle->getId(),
                $tripOrigin->getId(),
                $tripDestination->getId(),
                $reasonForTrip->getId(),
                $trafficPoliceBooth->getId(),
                json_encode($vehiclePassengers)
            )
        );
        return $districtEntryAndExitOfVehiclesControl;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function changeLicensePlate(string $newLicensePlate): void
    {
        if (!StringUtils::equals($newLicensePlate, $this->licensePlate)) {
            $this->licensePlate = $newLicensePlate;
        }
    }

    public function getModelOfVehicle(): ModelOfVehicle
    {
        return $this->modelOfVehicle;
    }

    public function changeModelOfVehicle(ModelOfVehicle $newModelOfVehicle): void
    {
        if (!StringUtils::equals($newModelOfVehicle->getId(), $this->modelOfVehicle->getId())) {
            $this->modelOfVehicle = $newModelOfVehicle;
        }
    }

    public function getTripOrigin(): District
    {
        return $this->tripOrigin;
    }

    public function changeTripOrigin(District $newTripOrigin): void
    {
        if (!StringUtils::equals($newTripOrigin->getId(), $this->tripOrigin->getId())) {
            $this->tripOrigin = $newTripOrigin;
        }
    }

    public function getTripDestination(): District
    {
        return $this->tripDestination;
    }

    public function changeTripDestination(District $newTripDestination): void
    {
        if (!StringUtils::equals($newTripDestination->getId(), $this->tripDestination->getId())) {
            $this->tripDestination = $newTripDestination;
        }
    }

    public function getReasonForTrip(): ReasonForTrip
    {
        return $this->reasonForTrip;
    }

    public function changeReasonForTrip(ReasonForTrip $newReasonForTrip): void
    {
        if (!StringUtils::equals($newReasonForTrip->getId(), $this->reasonForTrip->getId())) {
            $this->reasonForTrip = $newReasonForTrip;
        }
    }

    public function getTrafficPoliceBooth(): TrafficPoliceBooth
    {
        return $this->trafficPoliceBooth;
    }

    public function changeTrafficPoliceBooth(TrafficPoliceBooth $newTrafficPoliceBooth): void
    {
        if (!StringUtils::equals($newTrafficPoliceBooth->getId(), $this->trafficPoliceBooth->getId())) {
            $this->trafficPoliceBooth = $newTrafficPoliceBooth;
        }
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function setCreateAt($createAt): void
    {
        $this->createAt = $createAt;
    }

    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function changeUpdateAt($updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    public function changeVehiclePassengers(array $vehiclePassengers)
    {
        $this->record(
            new VehiclePassengersChangedDomainEvent(
                $this->id,
                json_encode($vehiclePassengers)
            )
        );
    }

    /**
     * @return ArrayCollection
     */
    public function getVehiclePassengers()
    {
        return $this->vehiclePassengers;
    }
}
