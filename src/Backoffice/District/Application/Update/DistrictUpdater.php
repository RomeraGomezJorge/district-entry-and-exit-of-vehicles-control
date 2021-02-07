<?php
	
	namespace App\Backoffice\District\Application\Update;
	
	use App\Backoffice\District\Application\Find\DistrictFinder;
	use App\Backoffice\District\Domain\District;
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
    use App\Shared\Infrastructure\Utils\StringUtils;
    
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
		
		public function __invoke(string $id, string $newDescription): void
		{
			$district = $this->finder->__invoke($id);
			
			if ($this->hasDescriptionChanged($newDescription, $district)) {
                $district->setDescription( trim( $newDescription ), $this->uniqueDistrictDescriptionSpecification );
			}
			
			$this->repository->save($district);
		}
		
		
		private function hasDescriptionChanged(string $newDescription, District $district): bool
		{
            return !StringUtils::equals( $newDescription, $district->getDescription() );
		}
	}