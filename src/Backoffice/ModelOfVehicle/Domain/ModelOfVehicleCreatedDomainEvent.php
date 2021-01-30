<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\ModelOfVehicle\Domain;
	
	use App\Shared\Domain\Bus\Event\DomainEvent;
	
	final class ModelOfVehicleCreatedDomainEvent extends DomainEvent
	{
		private string $description;
		private string $vehicleMakerNameId;
		
		public function __construct(
			string $id,
			string $description,
			string $vehicleMakerNameId,
			string $eventId = null,
			string $occurredOn = null
		) {
			parent::__construct($id, $eventId, $occurredOn);
			
			$this->description = $description;
			$this->vehicleMakerNameId = $vehicleMakerNameId;
		}
		
		public static function eventName(): string
		{
			return 'model_of_vehicle.created';
		}
		
		public static function fromPrimitives(
			string $aggregateId,
			array $body,
			string $eventId,
			string $occurredOn
		): DomainEvent {
			return new self($aggregateId, $body['description'], $body['vehicleMakerNameId'], $eventId, $occurredOn);
		}
		
		public function toPrimitives(): array
		{
			return [
				'description' => $this->description,
				'vehicleMakerNameId' => $this->vehicleMakerNameId,
			];
		}
		
		public function description(): string
		{
			return $this->description;
		}
		
		public function vehicleMakerNameId(): string
		{
			return $this->vehicleMakerNameId;
		}
	}
