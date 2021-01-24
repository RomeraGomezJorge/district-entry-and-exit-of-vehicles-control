<?php
	
	declare(strict_types=1);
	
	namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\FindByCriteriaSearcher;
	
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Shared\FilterUtilsForDistrictEntryAndExitOfVehiclesControl;
	use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
	use App\Shared\Domain\Criteria\Criteria;
	use App\Shared\Domain\Criteria\Filters;
	use App\Shared\Domain\Criteria\Order;
	
	final class DistrictEntryAndExitOfVehiclesControlsByCriteriaSearcher
	{
		private DistrictEntryAndExitOfVehiclesControlRepository $repository;
		private FilterUtilsForDistrictEntryAndExitOfVehiclesControl $filterUtils;
		
		public function __construct(
			DistrictEntryAndExitOfVehiclesControlRepository $repository,
			FilterUtilsForDistrictEntryAndExitOfVehiclesControl $filterUtils
		) {
			$this->repository = $repository;
			$this->filterUtils = $filterUtils;
		}
		
		public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
		{
			$searchResultForVehiclePassengers = $this->filterUtils->findPassengersByFilters($filters, $order, $orderBy,
				$limit, $offset);
			
			$filters = Filters::fromValues(
				$this->filterUtils->removeFiltersThatNotBelongToEntityIn($filters)
			);
			
			$order = Order::fromValues($order, $orderBy);
			
			$criteria = new Criteria($filters, $order, $offset, $limit);
			
			return $districtEntryAndExitOfVehiclesControls = $this->repository->matching($criteria,
				$searchResultForVehiclePassengers);
		}
	}
