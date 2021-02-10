<?php
	
	
	namespace App\Backoffice\VehiclePassenger\Application\Find;
	
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassenger;
	use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
	use App\Backoffice\VehiclePassenger\Domain\Exception\VehiclePassengerNotExist;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class VehiclePassengerFinder
	{
		private VehiclePassengerRepository $repository;
		
		public function __construct(VehiclePassengerRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke (string $id):?VehiclePassenger
		{
			$id = new Uuid($id);
			
			$VehiclePassenger = $this->repository->search($id);
			
			if (null === $VehiclePassenger) {
				throw new VehiclePassengerNotExist($id);
			}
			
			return $VehiclePassenger;
		}
	}