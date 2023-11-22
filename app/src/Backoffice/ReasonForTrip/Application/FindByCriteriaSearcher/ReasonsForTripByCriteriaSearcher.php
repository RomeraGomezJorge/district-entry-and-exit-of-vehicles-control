<?php

declare(strict_types=1);

namespace App\Backoffice\ReasonForTrip\Application\FindByCriteriaSearcher;

use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class ReasonsForTripByCriteriaSearcher
{
    private ReasonForTripRepository $repository;

    public function __construct(ReasonForTripRepository $repository)
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
