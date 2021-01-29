<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\VehicleBodyType\Infrastructure\Specification;
	
	use App\Backoffice\VehicleBodyType\Domain\UniqueVehicleBodyTypeDescriptionSpecification;
	use App\Backoffice\VehicleBodyType\Infrastructure\Persistence\MySqlVehicleBodyTypeRepository;
	
	final class MySqlUniqueVehicleBodyTypeDescriptionSpecification implements UniqueVehicleBodyTypeDescriptionSpecification
	{
		private MySqlVehicleBodyTypeRepository $repository;
		
		public function __construct(MySqlVehicleBodyTypeRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function isSatisfiedBy(string $description): bool
		{
			return !$this->repository->isDescriptionExits(array('description' => $description));
		}
	}