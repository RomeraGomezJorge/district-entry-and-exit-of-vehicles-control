<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Update;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\VehiclePassengersChangedDomainEvent;
	use App\Backoffice\VehiclePassenger\Application\Create\AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl;
	use App\Backoffice\VehiclePassenger\Application\Delete\DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl;
	use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
	use App\Shared\Domain\UuidGenerator;
	
	
	class UpdateVehiclePassengerOnlyIfVehiclePassengersChangedInDistrictEntryAndExitOfVehiclesControl implements DomainEventSubscriber
	{
		private AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $creator;
		private DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl $deleter;
		private UuidGenerator $uuidGenerator;
		
		public static function subscribedTo(): array
		{
			return [VehiclePassengersChangedDomainEvent::class];
		}
		
		public function __construct(
			AddVehiclePassengerInDistrictEntryAndExitOfVehiclesControl $creator,
			DeleteVehiclePassengerByDistrictEntryAndExitOfVehiclesControl $deleter,
			UuidGenerator $uuidGenerator
		) {
			$this->creator = $creator;
			$this->deleter = $deleter;
			$this->uuidGenerator = $uuidGenerator;
		}
		
		public function __invoke(
			VehiclePassengersChangedDomainEvent $event
		): void {
			$districtEntryAndExitOfVehiclesControlId = $event->aggregateId();
			
			$vehiclePassengers = json_decode($event->vehiclePassengers());
			
			$this->removePreviousVehiclePassengersIn($districtEntryAndExitOfVehiclesControlId);
			
			$this->addNewVehiclePassengersIn($vehiclePassengers, $districtEntryAndExitOfVehiclesControlId);
		}
		
		private function removePreviousVehiclePassengersIn(string $districtEntryAndExitOfVehiclesControlId): void
		{
			$this->deleter->__invoke($districtEntryAndExitOfVehiclesControlId);
		}
		
		private function addNewVehiclePassengersIn(
			$vehiclePassengers,
			string $districtEntryAndExitOfVehiclesControlId
		): void {
			$this->creator->__invoke(
				$districtEntryAndExitOfVehiclesControlId,
				$vehiclePassengers);
		}
	}