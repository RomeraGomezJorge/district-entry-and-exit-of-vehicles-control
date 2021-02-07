<?php
	
	namespace App\Backoffice\VehicleBodyType\Application\Update;
	
	use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
    use App\Shared\Infrastructure\Utils\StringUtils;
    
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
        
        public function __invoke(
            string $id,
            string $newDescription,
            ?string $newImage
        ): void
		{
			$vehicleBodyType = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $vehicleBodyType)) {
                $vehicleBodyType->setDescription( trim( $newDescription ),
                    $this->uniqueVehicleBodyTypeDescriptionSpecification );
			}
            
            if ( $this->hasImageChanged( $newImage, $vehicleBodyType ) ) {
                $vehicleBodyType->setImage( trim( $newImage ) );
            }
			
			$this->repository->save($vehicleBodyType);
		}
		
		private function hasDescriptionChanged(string $newDescription, VehicleBodyType $vehicleBodyType): bool
		{
            return !StringUtils::equals( $newDescription, $vehicleBodyType->getDescription() );
		}
        
        private function hasImageChanged(
            string $newImage,
            VehicleBodyType $vehicleBodyType
        ): bool
        {
            return !StringUtils::equals( $newImage, $vehicleBodyType->getDescription() );
        }
	}