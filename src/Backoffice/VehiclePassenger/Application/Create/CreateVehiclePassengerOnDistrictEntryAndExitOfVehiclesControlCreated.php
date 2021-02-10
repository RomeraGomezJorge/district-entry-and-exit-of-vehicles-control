<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Create;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent;
	use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
	use App\Shared\Domain\UuidGenerator;
	
	class CreateVehiclePassengerOnDistrictEntryAndExitOfVehiclesControlCreated implements DomainEventSubscriber
	{
		private VehiclePassengerCreator $creator;
		/**
		 * @var UuidGenerator
		 */
		private $uuidGenerator;
		
		public static function subscribedTo(): array
		{
			return [DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent::class];
		}
		
		public function __construct(VehiclePassengerCreator $creator, UuidGenerator $uuidGenerator)
		{
			$this->creator = $creator;
			$this->uuidGenerator = $uuidGenerator;
		}
		
		public function __invoke(
			DistrictEntryAndExitOfVehiclesControlCreatedDomainEvent $event
		): void {
			
			$vehiclePassengers = json_decode($event->vehiclePassengers());
			
			$this->creator->__invoke(
				$this->uuidGenerator->generate(),
				$vehiclePassengers[0]->name,
				$vehiclePassengers[0]->surname,
				$vehiclePassengers[0]->identityCard,
				$vehiclePassengers[0]->phone,
				$vehiclePassengers[0]->address,
				$event->id(),
				$vehiclePassengers[0]->temperatureControl);
		}
	}