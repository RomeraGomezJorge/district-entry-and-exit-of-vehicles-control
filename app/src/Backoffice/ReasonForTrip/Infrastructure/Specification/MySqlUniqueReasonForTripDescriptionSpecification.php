<?php

declare(strict_types=1);

namespace App\Backoffice\ReasonForTrip\Infrastructure\Specification;

use App\Backoffice\ReasonForTrip\Domain\UniqueReasonForTripDescriptionSpecification;
use App\Backoffice\ReasonForTrip\Infrastructure\Persistence\MySqlReasonForTripRepository;

final class MySqlUniqueReasonForTripDescriptionSpecification implements UniqueReasonForTripDescriptionSpecification
{
    private MySqlReasonForTripRepository $repository;

    public function __construct(MySqlReasonForTripRepository $repository)
    {
        $this->repository = $repository;
    }

    public function isSatisfiedBy(string $description): bool
    {
        return !$this->repository->isDescriptionExits(array('description' => $description));
    }
}
