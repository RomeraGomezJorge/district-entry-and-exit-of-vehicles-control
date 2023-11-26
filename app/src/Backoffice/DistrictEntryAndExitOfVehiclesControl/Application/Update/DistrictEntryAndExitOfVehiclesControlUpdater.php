<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Update;

use App\Backoffice\District\Application\Find\DistrictFinder;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
use App\Shared\Domain\Bus\Event\EventBus;

final class DistrictEntryAndExitOfVehiclesControlUpdater
{
    private DistrictEntryAndExitOfVehiclesControlRepository $repository;
    private DistrictEntryAndExitOfVehiclesControlFinder $finder;
    private ModelOfVehicleFinder $finderModelOfVehicle;
    private DistrictFinder $finderDistrict;
    private ReasonForTripFinder $finderReasonForTrip;
    private TrafficPoliceBoothFinder $finderTrafficPoliceBooth;
    private EventBus $bus;

    public function __construct(
        DistrictEntryAndExitOfVehiclesControlRepository $repository,
        ModelOfVehicleRepository $modelOfVehicleRepository,
        DistrictRepository $districtRepository,
        ReasonForTripRepository $reasonForTripRepository,
        TrafficPoliceBoothRepository $trafficPoliceBoothRepository,
        EventBus $bus
    ) {
        $this->repository               = $repository;
        $this->finder                   = new DistrictEntryAndExitOfVehiclesControlFinder($repository);
        $this->finderModelOfVehicle     = new ModelOfVehicleFinder($modelOfVehicleRepository);
        $this->finderDistrict           = new DistrictFinder($districtRepository);
        $this->finderReasonForTrip      = new ReasonForTripFinder($reasonForTripRepository);
        $this->finderTrafficPoliceBooth = new TrafficPoliceBoothFinder($trafficPoliceBoothRepository);
        $this->bus                      = $bus;
    }

    public function __invoke(
        string $id,
        string $newLicensePlate,
        string $newModelOfVehicleId,
        string $newTripOriginId,
        string $newTripDestinationId,
        string $newReasonForTripId,
        string $newTrafficPoliceBoothId,
        array $newVehiclePassengers
    ): void {
        $districtEntryAndExitOfVehiclesControl = $this->finder->__invoke($id);
        $modelOfVehicle                        = $this->finderModelOfVehicle->__invoke($newModelOfVehicleId);
        $tripOrigin                            = $this->finderDistrict->__invoke($newTripOriginId);
        $tripDestination                       = $this->finderDistrict->__invoke($newTripDestinationId);
        $reasonForTrip                         = $this->finderReasonForTrip->__invoke($newReasonForTripId);
        $trafficPoliceBooth                    = $this->finderTrafficPoliceBooth->__invoke($newTrafficPoliceBoothId);

        $districtEntryAndExitOfVehiclesControl->changeLicensePlate(trim($newLicensePlate));

        $districtEntryAndExitOfVehiclesControl->changeModelOfVehicle($modelOfVehicle);

        $districtEntryAndExitOfVehiclesControl->changeTripOrigin($tripOrigin);

        $districtEntryAndExitOfVehiclesControl->changeTripDestination($tripDestination);

        $districtEntryAndExitOfVehiclesControl->changeReasonForTrip($reasonForTrip);

        $districtEntryAndExitOfVehiclesControl->changeTrafficPoliceBooth($trafficPoliceBooth);

        $districtEntryAndExitOfVehiclesControl->changeVehiclePassengers($newVehiclePassengers);

        $districtEntryAndExitOfVehiclesControl->changeUpdateAt(new \DateTime());

        $this->repository->save($districtEntryAndExitOfVehiclesControl);

        $this->bus->publish(...$districtEntryAndExitOfVehiclesControl->pullDomainEvents());
    }
}
