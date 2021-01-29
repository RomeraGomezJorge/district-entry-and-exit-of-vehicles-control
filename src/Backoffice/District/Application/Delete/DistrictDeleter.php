<?php
	
	
	namespace App\Backoffice\District\Application\Delete;
	
	
	use App\Backoffice\District\Application\Find\DistrictFinder;
	use App\Backoffice\District\Domain\DistrictRepository;
	
	final class DistrictDeleter
	{
		private DistrictRepository $repository;
		
		private DistrictFinder $finder;
		
		public function __construct(
			DistrictRepository $repository
		) {
			$this->repository = $repository;
			$this->finder = new DistrictFinder($repository);
		}
		
		public function __invoke(string $id)
		{
			$district = $this->finder->__invoke($id);
			
			$this->repository->delete($district);
		}
	}