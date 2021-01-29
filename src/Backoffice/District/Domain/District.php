<?php
	
	namespace App\Backoffice\District\Domain;
	
	
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Backoffice\District\Domain\Exception\NonUniqueDistrictDescription;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	
	class District extends AggregateRoot
	{
		private $id;
		private $description;
		private $createAt;
		
		public static function create(
			Uuid $id,
			string $description,
			DateTime $createAt,
			UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification
		): self {
			
			if (!$uniqueDistrictDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueDistrictDescription($description);
			}
			
			$district = new self();
			
			$district->id = $id;
			
			$district->description = $description;
			
			$district->createAt = $createAt;
			
			$district->record(new DistrictCreatedDomainEvent($id->value(), $description));
			
			return $district;
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
			UniqueDistrictDescriptionSpecification $uniqueTagDescriptionSpecification
		): void {
			
			if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueDistrictDescription($description);
			}
			
			$this->description = $description;
		}
		
		public function getCreateAt()
		{
			return $this->createAt;
		}
		
	}
