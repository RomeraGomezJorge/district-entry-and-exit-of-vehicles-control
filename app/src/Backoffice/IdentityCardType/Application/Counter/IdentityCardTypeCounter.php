<?php

namespace App\Backoffice\IdentityCardType\Application\Counter;

use App\Backoffice\IdentityCardType\Domain\IdentityCardTypeRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class IdentityCardTypeCounter
{
    private IdentityCardTypeRepository $repository;

    public function __construct(IdentityCardTypeRepository $repository)
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
