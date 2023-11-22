<?php

namespace App\Backoffice\ReasonForTrip\Application\Counter;

use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class ReasonForTripCounter
{
    private ReasonForTripRepository $repository;

    public function __construct(ReasonForTripRepository $repository)
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
