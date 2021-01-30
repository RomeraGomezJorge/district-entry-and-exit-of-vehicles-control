<?php
	
	
	namespace App\Backoffice\VehicleMakerName\Application\Update;
	
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Backoffice\VehicleMakerName\Domain\UniqueVehicleMakerNameDescriptionSpecification;
	
	final class VehicleMakerNameUpdater
	{
		private VehicleMakerNameRepository $repository;
		
		private VehicleMakerNameFinder  $finder;
		
		private UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification;
		
		public function __construct(
			VehicleMakerNameRepository $repository,
			UniqueVehicleMakerNameDescriptionSpecification $uniqueVehicleMakerNameDescriptionSpecification
		) {
			$this->repository = $repository;
			$this->finder = new VehicleMakerNameFinder($repository);
			$this->uniqueVehicleMakerNameDescriptionSpecification = $uniqueVehicleMakerNameDescriptionSpecification;
		}
		
		public function __invoke(string $id, string $newDescription)
		{
			$vehicleMakerName = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $vehicleMakerName)) {
				$vehicleMakerName->setDescription($newDescription,
					$this->uniqueVehicleMakerNameDescriptionSpecification);
			}
			
			$this->repository->save($vehicleMakerName);
		}
		
		private function hasDescriptionChanged(string $newDescription, VehicleMakerName $district)
		{
			if (strcmp($newDescription, $district->getDescription()) !== 0) {
				return true;
			}
			
			return false;
		}
	}