<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\VehicleMakerName\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	
	final class VehicleMakersNameByCriteriaSearcher
	{
		private VehicleMakerNameRepository $repository;
		
		public function __construct(VehicleMakerNameRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
		{
			$filters = Filters::fromValues($filters);
			
			$order = Order::fromValues($order, $orderBy);
			
			$criteria = new Criteria($filters, $order, $offset, $limit);
			
			return $this->repository->matching($criteria);
		}
		
	}
