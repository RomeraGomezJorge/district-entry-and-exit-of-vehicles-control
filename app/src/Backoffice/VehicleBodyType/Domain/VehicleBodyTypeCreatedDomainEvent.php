<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\VehicleBodyType\Domain;
	
	use App\Shared\Domain\Bus\Event\DomainEvent;
	
	final class VehicleBodyTypeCreatedDomainEvent extends DomainEvent
	{
		private string $description;
		
		public function __construct(
			string $id,
			string $description,
			string $eventId = null,
			string $occurredOn = null
		) {
			parent::__construct($id, $eventId, $occurredOn);
			
			$this->description = $description;
		}
		
		public static function eventName(): string
		{
			return 'vehicle_body_type.created';
		}
		
		public function description(): string
		{
			return $this->description;
		}
	}
