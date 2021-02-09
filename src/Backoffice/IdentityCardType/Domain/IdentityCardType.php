<?php
	
	namespace App\Backoffice\IdentityCardType\Domain;
	
	
	use App\Backoffice\IdentityCardType\Domain\Exception\NonUniqueIdentityCardTypeDescription;
	use App\Shared\Domain\Aggregate\AggregateRoot;
	use App\Shared\Domain\ValueObject\Uuid;
	use DateTime;
	
	class IdentityCardType extends AggregateRoot
	{
		private $id;
		private $description;
		private $createAt;
		
		public static function create(
			Uuid $id,
			string $description,
			DateTime $createAt,
			UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification
		): self {
			
			if (!$uniqueIdentityCardTypeDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueIdentityCardTypeDescription($description);
			}
			
			$identityCardType = new self();
			
			$identityCardType->id = $id;
			
			$identityCardType->description = $description;
			
			$identityCardType->createAt = $createAt;
			
			$identityCardType->record(new IdentitycardTypeCreatedDomainEvent($id->value(), $description));
			
			return $identityCardType;
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
			UniqueIdentityCardTypeDescriptionSpecification $uniqueTagDescriptionSpecification
		): void {
			
			if (!$uniqueTagDescriptionSpecification->isSatisfiedBy($description)) {
				throw new NonUniqueIdentityCardTypeDescription($description);
			}
			
			$this->description = $description;
		}
		
		public function getCreateAt()
		{
			return $this->createAt;
		}
		
	}
