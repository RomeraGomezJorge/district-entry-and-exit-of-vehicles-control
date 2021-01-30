<?php
	
	namespace App\Backoffice\VehicleMakerName\Domain;
	
	
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Backoffice\VehicleMakerName\Domain\Exception\NonUniqueVehicleMakerNameDescription;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	
	class VehicleMakerName extends AggregateRoot
	{
		private $id;
		private $description;
		private $createAt;
		
		public static function create(
			Uuid $id,
			string $description,
			DateTime $createAt,
			UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification
		): self {
			
			if (!$uniqueVehicleMakerNameDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueVehicleMakerNameDescription($description);
			}
			
			$vehicleMakerName = new self();
			
			$vehicleMakerName->id = $id;
			
			$vehicleMakerName->description = $description;
			
			$vehicleMakerName->createAt = $createAt;
			
			$vehicleMakerName->record(new VehicleMakerNameCreatedDomainEvent($id->value(), $description));
			
			return $vehicleMakerName;
		}
		
		public function getId(): ?String
		{
			return $this->id;
		}
		
		public function setId(Uuid $id): void
		{
			$this->id = $id;
		}
		
		public function getDescription(): ?string
		{
			return $this->description;
		}
		
		public function setDescription(
			string $description,
			UniqueVehicleMakerNameDescriptionSpecification $uniqueTagDescriptionSpecification
		): void {
			
			if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueVehicleMakerNameDescription($description);
			}
			
			$this->description = $description;
		}
		
		public function getCreateAt()
		{
			return $this->createAt;
		}
		
	}
