<?php
	
	namespace App\Backoffice\VehicleBodyType\Application\Create;
	
	use App\Backoffice\VehicleBodyType\Domain\District;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyType;
	use App\Shared\Domain\Bus\Event\EventBus;
	use App\Backoffice\VehicleBodyType\Domain\VehicleBodyTypeRepository;
	use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class VehicleBodyTypeCreator
	{
		private VehicleBodyTypeRepository $repository;
		
		private UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification;
		
		private EventBus $bus;
		
		public function __construct(
			VehicleBodyTypeRepository $repository,
			UniqueVehicleBodyTypeDescriptionSpecification $uniqueVehicleBodyTypeDescriptionSpecification,
			EventBus $bus
		) {
			$this->repository = $repository;
			$this->uniqueVehicleBodyTypeDescriptionSpecification = $uniqueVehicleBodyTypeDescriptionSpecification;
			$this->bus = $bus;
		}
		
		public function __invoke(string $id, string $description)
		{
			$id = new Uuid($id);
			
			$createAt = new \DateTime();
			
			$district = VehicleBodyType::create(
				$id,
				$description,
				$createAt,
				$this->uniqueVehicleBodyTypeDescriptionSpecification);
			
			$this->repository->save($district);
			
			$this->bus->publish(...$district->pullDomainEvents());
		}
	}