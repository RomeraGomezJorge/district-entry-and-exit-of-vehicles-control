<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Application\Update;
	
	use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
	use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class ModelOfVehicleUpdater
	{
		private ModelOfVehicleRepository $repository;
		
		private ModelOfVehicleFinder  $finder;
		
		private UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification;
		
		private VehicleMakerNameFinder $finderVehicleMakerName;
		
		public function __construct(
			ModelOfVehicleRepository $repository,
			UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification,
			VehicleMakerNameRepository $vehicleMakerNameRepository
		) {
			$this->repository = $repository;
			$this->finder = new ModelOfVehicleFinder($repository);
			$this->finderVehicleMakerName = new VehicleMakerNameFinder($vehicleMakerNameRepository);
			$this->uniqueModelOfVehicleDescriptionSpecification = $uniqueModelOfVehicleDescriptionSpecification;
		}
		
		public function __invoke(string $id, string $newDescription, string $vehicleMakerName_id)
		{
			$modelOfVehicle = $this->finder->__invoke($id);
			
			$newVehicleMakerName = $this->finderVehicleMakerName->__invoke(
				new Uuid($vehicleMakerName_id)
			);
			
			if ($this->hasDescriptionChanged($newDescription, $modelOfVehicle)) {
				$modelOfVehicle->setDescription($newDescription,
					$this->uniqueModelOfVehicleDescriptionSpecification);
			}
			
			if ($this->hasVehicleMakerNameChanged($newVehicleMakerName, $modelOfVehicle)) {
				
				$modelOfVehicle->setVehicleMakeName($newVehicleMakerName);
			}
			
			$this->repository->save($modelOfVehicle);
		}
		
		private function hasDescriptionChanged(string $newDescription, ModelOfVehicle $district)
		{
			if (strcmp($newDescription, $district->getDescription()) !== 0) {
				return true;
			}
			
			return false;
		}
		
		private function hasVehicleMakerNameChanged(
			VehicleMakerName $newVehicleMakerName,
			ModelOfVehicle $modelOfVehicle
		): bool {
			return strcmp($newVehicleMakerName->getId(),
				$modelOfVehicle->geTVehicleMakerName()->getId()) !== 0 ? true : false;
		}
	}