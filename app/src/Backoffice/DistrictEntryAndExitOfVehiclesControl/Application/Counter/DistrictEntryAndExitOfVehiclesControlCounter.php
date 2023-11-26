<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Counter;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Shared\FilterUtils;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class DistrictEntryAndExitOfVehiclesControlCounter
{
    private DistrictEntryAndExitOfVehiclesControlRepository $repository;
    private FilterUtils $filterUtils;

    public function __construct(
        DistrictEntryAndExitOfVehiclesControlRepository $repository,
        FilterUtils $filterUtils
    ) {
        $this->repository  = $repository;
        $this->filterUtils = $filterUtils;
    }

    public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): int
    {
        $passengers = $this->filterUtils->findPassengersByFiltersOrNull(
            $filters,
            $order,
            $orderBy,
            $limit,
            $offset
        );

        $filters = Filters::fromValues(
            $this->filterUtils->removeFiltersThatNotBelongToEntityIn($filters)
        );

        $order = Order::fromValues($order, $orderBy);

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->repository->totalMatchingRows($criteria, $passengers);
    }
}
