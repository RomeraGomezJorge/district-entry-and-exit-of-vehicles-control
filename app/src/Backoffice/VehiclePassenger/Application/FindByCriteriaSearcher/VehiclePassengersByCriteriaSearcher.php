<?php

declare(strict_types=1);

namespace App\Backoffice\VehiclePassenger\Application\FindByCriteriaSearcher;

use App\Backoffice\VehiclePassenger\Domain\VehiclePassengerRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;
use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;

final class VehiclePassengersByCriteriaSearcher
{
    const FIELD_NAME_THAT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM = ['name', 'surname', 'identityCard'];
    private VehiclePassengerRepository $repository;

    public function __construct(VehiclePassengerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
    {
        $filters = $this->removeFiltersThatNotBelongToEntity($filters);

        $filters = Filters::fromValues($filters);

        $order = Order::fromValues($order, $orderBy);

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->repository->matching($criteria);
    }

    private function removeFiltersThatNotBelongToEntity($filters): array
    {
        return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilterNotEqualsTo(
            self::FIELD_NAME_THAT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM,
            $filters
        );
    }
}
