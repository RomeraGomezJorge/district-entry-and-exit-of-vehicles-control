<?php
	
	namespace App\Backoffice\ModelOfVehicle\Application\Update;
	
	use App\Backoffice\ModelOfVehicle\Application\Find\ModelOfVehicleFinder;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Domain\ValueObject\Uuid;
    use App\Shared\Infrastructure\Utils\StringUtils;
    
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
		
		public function __invoke(string $id, string $newDescription, string $vehicleMakerName_id): void
		{
			$modelOfVehicle = $this->finder->__invoke($id);
			
			$newVehicleMakerName = $this->finderVehicleMakerName->__invoke(
				new Uuid($vehicleMakerName_id)
			);
			
			if ($this->hasDescriptionChanged($newDescription, $modelOfVehicle)) {
                $modelOfVehicle->setDescription( trim( $newDescription ),
                    $this->uniqueModelOfVehicleDescriptionSpecification );
			}
			
			if ($this->hasVehicleMakerNameChanged($newVehicleMakerName, $modelOfVehicle)) {
				
				$modelOfVehicle->setVehicleMakeName($newVehicleMakerName);
			}
			
			$this->repository->save($modelOfVehicle);
		}
		
		private function hasDescriptionChanged(string $newDescription, ModelOfVehicle $modelOfVehicle): bool
		{
			return strcmp($newDescription, $modelOfVehicle->getDescription()) !== 0 ? true : false;
		}
		
		private function hasVehicleMakerNameChanged(
			VehicleMakerName $newVehicleMakerName,
			ModelOfVehicle $modelOfVehicle
		): bool {
            return !StringUtils::equals( $newVehicleMakerName->getId(),
                $modelOfVehicle->geTVehicleMakerName()->getId() );
		}
	}