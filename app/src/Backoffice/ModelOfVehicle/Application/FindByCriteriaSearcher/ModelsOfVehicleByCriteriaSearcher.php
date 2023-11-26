<?php

declare(strict_types=1);

namespace App\Backoffice\ModelOfVehicle\Application\FindByCriteriaSearcher;

use App\Backoffice\ModelOfVehicle\Application\Shared\FilterUtilsForModelOfVehicle;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class ModelsOfVehicleByCriteriaSearcher
{
    private ModelOfVehicleRepository $repository;
    private FilterUtilsForModelOfVehicle $filterUtils;

    public function __construct(
        ModelOfVehicleRepository $repository,
        FilterUtilsForModelOfVehicle $filterUtils
    ) {
        $this->repository  = $repository;
        $this->filterUtils = $filterUtils;
    }

    public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
    {
        $vehicleMakerName = $this->filterUtils->getVehicleMakerNameFromFilterOrNull($filters);

        $filters = Filters::fromValues(
            $this->filterUtils->removeFiltersThatNotBelongToEntity($filters)
        );

        $order = Order::fromValues($order, $orderBy);

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->repository->matching($criteria, $vehicleMakerName);
    }
}
