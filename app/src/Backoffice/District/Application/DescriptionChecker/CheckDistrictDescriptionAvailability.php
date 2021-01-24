<?php
	
	
	namespace App\Backoffice\District\Application\DescriptionChecker;
	
	use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
	
	final class CheckDistrictDescriptionAvailability
	{
		private UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification;
		
		public function __construct(UniqueDistrictDescriptionSpecification $uniqueTagDescriptionSpecification)
		{
			$this->uniqueDistrictDescriptionSpecification = $uniqueTagDescriptionSpecification;
		}
		
		public function __invoke(string $description): bool
		{
			return $this->uniqueDistrictDescriptionSpecification->isSatisfiedBy(trim($description));
		}
	}