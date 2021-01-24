<?php
	
	
	namespace App\Backoffice\IdentityCardType\Application\DescriptionChecker;
	
	use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;
	
	final class CheckIdentityCardTypeDescriptionAvailability
	{
		private UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification;
		
		public function __construct(
			UniqueIdentityCardTypeDescriptionSpecification $uniqueIdentityCardTypeDescriptionSpecification
		) {
			$this->uniqueIdentityCardTypeDescriptionSpecification = $uniqueIdentityCardTypeDescriptionSpecification;
		}
		
		public function __invoke(string $description): bool
		{
			return $this->uniqueIdentityCardTypeDescriptionSpecification->isSatisfiedBy($description);
		}
	}