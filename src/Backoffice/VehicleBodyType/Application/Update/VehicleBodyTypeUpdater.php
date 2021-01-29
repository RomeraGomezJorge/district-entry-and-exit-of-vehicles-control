<?php
	
	
	namespace App\Backoffice\VehicleBodyType\Application\Update;
	
	use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
	use App\Backoffice\VehicleBodyType\Domain\District;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
	
	final class VehicleBodyTypeUpdater
	{
		private VehicleBodyTypeRepository $repository;
		
		private VehicleBodyTypeFinder  $finder;
		
		private UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification;
		
		public function __construct(
			VehicleBodyTypeRepository $repository,
			UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification
		) {
			$this->repository = $repository;
			$this->finder = new VehicleBodyTypeFinder($repository);
			$this->uniqueVehicleBodyTypeDescriptionSpecification = $uniqueVehicleBodyTypeDescriptionSpecification;
		}
		
		public function __invoke(string $id, string $newDescription)
		{
			$vehicleBodyType = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $vehicleBodyType)) {
				$vehicleBodyType->setDescription($newDescription, $this->uniqueVehicleBodyTypeDescriptionSpecification);
			}
			
			$this->repository->save($vehicleBodyType);
		}
		
		
		private function hasDescriptionChanged(string $newDescription, VehicleBodyType $district)
		{
			if (strcmp($newDescription, $district->getDescription()) !== 0) {
				return true;
			}
			
			return false;
		}
	}