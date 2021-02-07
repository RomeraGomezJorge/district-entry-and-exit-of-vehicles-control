<?php
	
	
	namespace App\Backoffice\ReasonForTrip\Application\DescriptionChecker;
	
	use App\Backoffice\ReasonForTrip\Domain\UniqueReasonForTripDescriptionSpecification;
	
	final class CheckReasonForTripDescriptionAvailability
	{
		private UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification;
		
		public function __construct(
			UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification
		) {
			$this->uniqueReasonForTripDescriptionSpecification = $uniqueReasonForTripDescriptionSpecification;
		}
		
		public function __invoke(string $description): bool
		{
			return $this->uniqueReasonForTripDescriptionSpecification->isSatisfiedBy(trim($description));
		}
	}