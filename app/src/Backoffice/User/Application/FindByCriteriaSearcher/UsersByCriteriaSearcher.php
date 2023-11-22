<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\FindByCriteriaSearcher;

use App\Backoffice\Role\Application\Find\RoleFinder;
use App\Backoffice\User\Application\Shared\FilterUtilsForUser;
use App\Backoffice\User\Domain\UserRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\Criteria\Filters;
use App\Shared\Domain\Criteria\Order;

final class UsersByCriteriaSearcher
{
    private UserRepository $repository;
    private RoleFinder $roleFinder;
    /**
     * @var FilterUtilsForUser
     */
    private $filterUtils;

    public function __construct(UserRepository $repository, FilterUtilsForUser $filterUtils)
    {
        $this->repository  = $repository;
        $this->filterUtils = $filterUtils;
    }

    public function __invoke($filters, $order, $orderBy, ?int $limit, ?int $offset): array
    {
        $role = $this->filterUtils->getRoleFromFilterOrNull($filters);

        $filters = $this->filterUtils->removeFiltersThatNotBelongToPostEntity($filters);

        $filters = Filters::fromValues($filters);

        $order = Order::fromValues($order, $orderBy);

        $criteria = new Criteria($filters, $order, $offset, $limit);

        return $this->repository->matching($criteria, $role);
    }
}
