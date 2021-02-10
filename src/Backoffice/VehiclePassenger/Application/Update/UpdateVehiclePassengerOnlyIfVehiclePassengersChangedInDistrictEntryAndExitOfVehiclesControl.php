<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Update;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\VehiclePassengersChangedDomainEvent;
	use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
	
	
	class UpdateVehiclePassengerOnlyIfVehiclePassengersChangedInDistrictEntryAndExitOfVehiclesControl implements DomainEventSubscriber
	{
		private VehiclePassengerUpdater $updater;
		
		public static function subscribedTo(): array
		{
			return [VehiclePassengersChangedDomainEvent::class];
		}
		
		public function __construct(VehiclePassengerUpdater $updater)
		{
			$this->updater = $updater;
		}
		
		public function __invoke(
			VehiclePassengersChangedDomainEvent $event
		): void
		{
			$vehiclePassengers = json_decode($event->vehiclePassengers());
			
			$this->updater->__invoke(
				$vehiclePassengers[0]->id,
				$vehiclePassengers[0]->name,
				$vehiclePassengers[0]->surname,
				$vehiclePassengers[0]->identityCard,
				$vehiclePassengers[0]->phone,
				$vehiclePassengers[0]->address,
				$event->id(),
				$vehiclePassengers[0]->temperatureControl);
		}
	}