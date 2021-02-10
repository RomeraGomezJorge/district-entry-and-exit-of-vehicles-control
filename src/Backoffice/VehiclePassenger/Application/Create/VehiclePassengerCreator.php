<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Create;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Find\DistrictEntryAndExitOfVehiclesControlFinder;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class VehiclePassengerCreator
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
			string $id,
			string $name,
			string $surname,
			string $identityCard,
			string $phone,
			string $address,
			string $districtEntryAndExitOfVehiclesControlId,
			string $temperatureControl
		) {
			$id = new Uuid($id);
			
			$districtEntryAndExitOfVehiclesControl = $this->finderDistrictEntryAndExitOfVehiclesControl
				->__invoke($districtEntryAndExitOfVehiclesControlId);
			
			$createAt = new \DateTime();
			
			$vehiclePassenger = VehiclePassenger::create(
				$id,
				trim($name),
				trim($surname),
				trim($identityCard),
				trim($phone),
				trim($address),
				$districtEntryAndExitOfVehiclesControl,
				trim($temperatureControl),
				$createAt
			);
			
			$this->repository->save($vehiclePassenger);
			
			$this->bus->publish(...$vehiclePassenger->pullDomainEvents());
		}
	}