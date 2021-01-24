<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\District\Infrastructure\Specification;
	
	use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
	use App\Backoffice\District\Infrastructure\Persistence\MySqlDistrictRepository;
	
	final class MySqlUniqueDistrictDescriptionSpecification implements UniqueDistrictDescriptionSpecification
	{
		private MySqlDistrictRepository $repository;
		
		public function __construct(MySqlDistrictRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function isSatisfiedBy(string $description): bool
		{
			return !$this->repository->isDescriptionExits(array('description' => $description));
		}
	}