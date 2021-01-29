<?php
	
	
	namespace App\Backoffice\ReasonForTrip\Application\Find;
	
	use App\Backoffice\ReasonForTrip\Domain\Exception\ReasonForTripNotExist;
	use App\Backoffice\ReasonForTrip\Domain\ReasonForTrip;
	use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
	use App\Shared\Domain\ValueObject\Uuid;
	
	final class ReasonForTripFinder
	{
		private ReasonForTripRepository $repository;
		
		public function __construct(ReasonForTripRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke(string $id): ReasonForTrip
		{
			$id = new Uuid($id);
			
			$reasonForTrip = $this->repository->search($id);
			
			if (null === $reasonForTrip) {
				throw new ReasonForTripNotExist($id);
			}
			
			return $reasonForTrip;
		}
	}