<?php
	
	namespace App\Backoffice\TrafficPoliceBooth\Domain;
	
	
	use App\Shared\Domain\Aggregate\AggregateRoot;
    use App\Backoffice\TrafficPoliceBooth\Domain\Exception\NonUniqueTrafficPoliceBoothDescription;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
    
    class TrafficPoliceBooth extends AggregateRoot
	{
		private $id;
		private $description;
		private $createAt;
 
		public static function create(
			Uuid $id,
			string $description,
            DateTime $createAt,
			UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification
		): self {
			
			if (!$uniqueTrafficPoliceBoothDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueTrafficPoliceBoothDescription($description);
			}
			
			$trafficPoliceBooth = new self();
			
			$trafficPoliceBooth->id = $id;
			
			$trafficPoliceBooth->description = $description;

			$trafficPoliceBooth->createAt = $createAt;
            
            $trafficPoliceBooth->record(new TrafficPoliceBoothCreatedDomainEvent($id->value(), $description));

			return $trafficPoliceBooth;
		}
		
		public function getId(): ?String
		{
			return $this->id;
		}
		
		public function getDescription(): ?string
		{
			return $this->description;
		}
		
		public function setId(Uuid $id): void
		{
			$this->id = $id;
		}
		
		public function setDescription(
			string $description,
			UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTagDescriptionSpecification
		): void {
			
			if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueTrafficPoliceBoothDescription($description);
			}
			
			$this->description = $description;
		}

		public function getCreateAt()
        {
            return $this->createAt;
        }

	}
