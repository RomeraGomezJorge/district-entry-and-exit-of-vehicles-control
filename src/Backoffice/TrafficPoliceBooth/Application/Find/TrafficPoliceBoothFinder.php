<?php
	
	
	namespace App\Backoffice\TrafficPoliceBooth\Application\Find;
	
	use App\Backoffice\TrafficPoliceBooth\Domain\Exception\TrafficPoliceBoothNotExist;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
	use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class TrafficPoliceBoothFinder
	{
		private TrafficPoliceBoothRepository $repository;
		
		public function __construct(TrafficPoliceBoothRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke (string $id):TrafficPoliceBooth
		{
			$id = new Uuid($id);
			
			$trafficPoliceBooth = $this->repository->search($id);
			
			if (null === $trafficPoliceBooth) {
				throw new TrafficPoliceBoothNotExist($id);
			}
			
			return $trafficPoliceBooth;
		}
	}