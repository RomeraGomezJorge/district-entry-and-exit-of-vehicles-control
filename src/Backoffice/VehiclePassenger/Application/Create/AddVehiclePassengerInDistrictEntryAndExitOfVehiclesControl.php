<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Create;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl
	{
		private VehiclePassengerRepository $repository;
		private EventBus $bus;
		private DistrictEntryAndExitOfVehiclesControlFinder $finderDistrictEntryAndExitOfVehiclesControl;
		
		public function __construct(
			VehiclePassengerRepository $repository,
			DistrictEntryAndExitOfVehiclesControlRepository $districtEntryAndExitOfVehiclesControlRepository,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->finderDistrictEntryAndExitOfVehiclesControl = new DistrictEntryAndExitOfVehiclesControlFinder($districtEntryAndExitOfVehiclesControlRepository);
			$this->bus = $bus;
		}
		
		public function __invoke(
			string $districtEntryAndExitOfVehiclesControlId,
			array $passengers
		) {
			$districtEntryAndExitOfVehiclesControl = $this->finderDistrictEntryAndExitOfVehiclesControl
				->__invoke($districtEntryAndExitOfVehiclesControlId);
			
			$vehiclePassengers = [];
			
			foreach ($passengers as $passenger) {
				$id = Uuid::random();
				
				$createAt = new \DateTime();
				
				$vehiclePassengers[] = VehiclePassenger::create(
					$id,
					trim($passenger->name),
					trim($passenger->surname),
					trim($passenger->identityCard),
					trim($passenger->phone),
					trim($passenger->address),
					$districtEntryAndExitOfVehiclesControl,
					trim($passenger->temperatureControl),
					$createAt
				);
			}
			
			$this->repository->saveMultiple($vehiclePassengers);
			
			foreach ($vehiclePassengers as $vehiclePassenger) {
				$this->bus->publish(...$vehiclePassenger->pullDomainEvents());
			}
			
		}
	}