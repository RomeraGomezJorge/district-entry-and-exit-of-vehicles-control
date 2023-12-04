<?php

namespace App\Backoffice\ModelOfVehicle\Application\Counter;

use App\Backoffice\ModelOfVehicle\Application\Shared\FilterUtils;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class ModelOfVehicleCounter
{
    private ModelOfVehicleRepository $repository;
    private FilterUtils $filterUtils;

    public function __construct(ModelOfVehicleRepository $repository, FilterUtils $filterUtils)
    {
        $this->repository  = $repository;
        $this->filterUtils = $filterUtils;
    }

    public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): int
    {
        $vehicleMakerName = $this->filterUtils->getVehicleMakerNameFromFilterOrNull($filters);

        $filters = Filters::fromValues(
            $this->filterUtils->removeFiltersThatNotBelongToEntity($filters)
        );

        $order = Order::fromValues($order, $orderBy);

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->repository->totalMatchingRows($criteria, $vehicleMakerName);
    }
}
