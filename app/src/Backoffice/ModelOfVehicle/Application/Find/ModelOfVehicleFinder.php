<?php
	
	
	namespace App\Backoffice\ModelOfVehicle\Application\Find;
	
	use App\Backoffice\ModelOfVehicle\Domain\Exception\ModelOfVehicleNameNotExist;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class ModelOfVehicleFinder
	{
		private ModelOfVehicleRepository $repository;
		
		public function __construct(ModelOfVehicleRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke(string $id): ModelOfVehicle
		{
			$id = new Uuid($id);
			
			$modelOfVehicle = $this->repository->search($id);
			
			if (null === $modelOfVehicle) {
				throw new ModelOfVehicleNameNotExist($id);
			}
			
			return $modelOfVehicle;
		}
	}