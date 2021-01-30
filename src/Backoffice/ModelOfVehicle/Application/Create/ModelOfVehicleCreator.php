<?php
	
	namespace App\Backoffice\ModelOfVehicle\Application\Create;
	
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
	use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
	use App\Backoffice\ModelOfVehicle\Domain\UniqueModelOfVehicleDescriptionSpecification;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class ModelOfVehicleCreator
	{
		private ModelOfVehicleRepository $repository;
		private VehicleMakerNameFinder $finderVehicleMakerName;
		private UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification;
		private EventBus $bus;
		
		public function __construct(
			ModelOfVehicleRepository $repository,
			VehicleMakerNameRepository $vehicleMakerNameRepository,
			UniqueModelOfVehicleDescriptionSpecification $uniqueModelOfVehicleDescriptionSpecification,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->finderVehicleMakerName = new VehicleMakerNameFinder($vehicleMakerNameRepository);
			$this->uniqueModelOfVehicleDescriptionSpecification = $uniqueModelOfVehicleDescriptionSpecification;
			$this->bus = $bus;
		}
		
		public function __invoke(string $id, string $description, string $vehicleMakerName_id)
		{
			$id = new Uuid($id);
			
			$vehicleMakerName = $this->finderVehicleMakerName->__invoke(
				new Uuid($vehicleMakerName_id)
			);
			
			$createAt = new \DateTime();
			
			$modelOfVehicle = ModelOfVehicle::create(
				$id,
				$description,
				$vehicleMakerName,
				$createAt,
				$this->uniqueModelOfVehicleDescriptionSpecification);
			
			$this->repository->save($modelOfVehicle);
			
			$this->bus->publish(...$modelOfVehicle->pullDomainEvents());
		}
	}