<?php
	
	namespace App\Backoffice\VehiclePassenger\Application\Delete;
	
	
	use App\Backoffice\VehiclePassenger\Application\Find\VehiclePassengerFinder;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;

	
	final class VehiclePassengerDeleter
	{
		private VehiclePassengerRepository $repository;
		
		private VehiclePassengerFinder $finder;
		
		public function __construct(
			VehiclePassengerRepository $repository
		) {
			$this->repository = $repository;
			$this->finder = new VehiclePassengerFinder($repository);
		}
		
		public function __invoke(string $id)
		{
			$VehiclePassenger = $this->finder->__invoke($id);
			
			$this->repository->delete($VehiclePassenger);
		}
	}