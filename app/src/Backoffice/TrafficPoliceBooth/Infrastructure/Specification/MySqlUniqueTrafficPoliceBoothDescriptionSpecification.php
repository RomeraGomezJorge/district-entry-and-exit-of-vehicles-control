<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\TrafficPoliceBooth\Infrastructure\Specification;
	use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;
	use App\Backoffice\TrafficPoliceBooth\Infrastructure\Persistence\MySqlTrafficPoliceBoothRepository;
	
	final class MySqlUniqueTrafficPoliceBoothDescriptionSpecification implements UniqueTrafficPoliceBoothDescriptionSpecification
	{
		private MySqlTrafficPoliceBoothRepository $repository;
		
		public function __construct( MySqlTrafficPoliceBoothRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function isSatisfiedBy( string $description ): bool
		{
			return !$this->repository->isDescriptionExits(array('description' => $description));
		}
	}