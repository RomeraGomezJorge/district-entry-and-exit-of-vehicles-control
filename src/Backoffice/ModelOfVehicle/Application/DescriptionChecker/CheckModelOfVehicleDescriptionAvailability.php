<?php
	
	namespace App\Backoffice\ModelOfVehicle\Application\DescriptionChecker;
	
	use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
	
	final class CheckModelOfVehicleDescriptionAvailability
	{
		private UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification;
		
		public function __construct(
			UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification
		) {
			$this->uniqueModelOfVehicleDescriptionSpecification = $uniqueModelOfVehicleDescriptionSpecification;
		}
		
		public function __invoke(string $description): bool
		{
			return $this->uniqueModelOfVehicleDescriptionSpecification->isSatisfiedBy($description);
		}
	}