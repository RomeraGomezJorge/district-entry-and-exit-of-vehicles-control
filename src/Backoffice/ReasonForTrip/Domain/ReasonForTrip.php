<?php
	
	namespace App\Backoffice\ReasonForTrip\Domain;
	
	
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Backoffice\ReasonForTrip\Domain\Exception\NonUniqueReasonForTripDescription;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	
	class ReasonForTrip extends AggregateRoot
	{
		private $id;
		private $description;
		private $createAt;
		
		public static function create(
			Uuid $id,
			string $description,
			DateTime $createAt,
			UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification
		): self {
			
			if (!$uniqueReasonForTripDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueReasonForTripDescription($description);
			}
			
			$reasonForTrip = new self();
			
			$reasonForTrip->id = $id;
			
			$reasonForTrip->description = $description;
			
			$reasonForTrip->createAt = $createAt;
			
			$reasonForTrip->record(new ReasonForTripCreatedDomainEvent($id->value(), $description));
			
			return $reasonForTrip;
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
			UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification
		): void {
			
			if (!$uniqueReasonForTripDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueReasonForTripDescription($description);
			}
			
			$this->description = $description;
		}
		
		public function getCreateAt()
		{
			return $this->createAt;
		}
		
	}
