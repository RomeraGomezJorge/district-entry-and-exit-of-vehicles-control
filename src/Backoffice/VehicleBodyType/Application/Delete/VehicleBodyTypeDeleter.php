<?php
	
	
	namespace App\Backoffice\VehicleBodyType\Application\Delete;
	
	
	use App\Backoffice\VehicleBodyType\Application\Find\VehicleBodyTypeFinder;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	
	final class VehicleBodyTypeDeleter
	{
		private VehicleBodyTypeRepository $repository;
		
		private VehicleBodyTypeFinder $finder;
		
		public function __construct(
			VehicleBodyTypeRepository $repository
		) {
			$this->repository = $repository;
			$this->finder = new VehicleBodyTypeFinder($repository);
		}
		
		public function __invoke(string $id)
		{
			$vehicleBodyType = $this->finder->__invoke($id);
			
			$this->repository->delete($vehicleBodyType);
		}
	}