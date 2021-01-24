<?php
	
	
	namespace App\Backoffice\District\Application\Counter;
	
	
	use App\Backoffice\District\Domain\DistrictRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	
	final class DistrictCounter
	{
		private DistrictRepository $repository;
		
		public function __construct(DistrictRepository $repository)
		{
			$this->repository = $repository;
		}
		
		public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): int
		{
			$filters = Filters::fromValues($filters);
			
			$order = Order::fromValues($order, $orderBy);
			
			$criteria = new Criteria($filters, $order, $offset, $limit);
			
			return $this->repository->totalMatchingRows($criteria);
		}
		
	}