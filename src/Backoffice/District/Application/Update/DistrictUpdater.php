<?php
	
	
	namespace App\Backoffice\District\Application\Update;
	
	use App\Backoffice\District\Application\Find\DistrictFinder;
	use App\Backoffice\District\Domain\District;
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
	
	final class DistrictUpdater
	{
		private DistrictRepository $repository;
		
		private DistrictFinder  $finder;
		
		private UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification;
		
		public function __construct(
			DistrictRepository $repository,
			UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification
		) {
			$this->repository = $repository;
			$this->finder = new DistrictFinder($repository);
			$this->uniqueDistrictDescriptionSpecification = $uniqueDistrictDescriptionSpecification;
		}
		
		public function __invoke(string $id, string $newDescription)
		{
			$district = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $district)) {
				$district->setDescription($newDescription, $this->uniqueDistrictDescriptionSpecification);
			}
			
			$this->repository->save($district);
		}
		
		
		private function hasDescriptionChanged(string $newDescription, District $district)
		{
			if (strcmp($newDescription, $district->getDescription()) !== 0) {
				return true;
			}
			
			return false;
		}
	}