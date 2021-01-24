<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Application\Delete;
	
	
	use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	
	final class TrafficPoliceBoothDeleter
	{
		private TrafficPoliceBoothRepository $repository;
		
		private TrafficPoliceBoothFinder $finder;
		
		public function __construct(
			TrafficPoliceBoothRepository $repository
		) {
			$this->repository = $repository;
			$this->finder = new TrafficPoliceBoothFinder($repository);
		}
		
		public function __invoke(string $id)
		{
			$trafficPoliceBooth = $this->finder->__invoke($id);
			
			$this->repository->delete($trafficPoliceBooth);
		}
	}