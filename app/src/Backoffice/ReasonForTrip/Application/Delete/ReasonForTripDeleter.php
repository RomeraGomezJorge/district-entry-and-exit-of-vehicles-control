<?php

namespace App\Backoffice\ReasonForTrip\Application\Delete;

use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;

final class ReasonForTripDeleter
{
    private ReasonForTripRepository $repository;

    private ReasonForTripFinder $finder;

    public function __construct(
        ReasonForTripRepository $repository
    ) {
        $this->repository = $repository;
        $this->finder     = new ReasonForTripFinder($repository);
    }

    public function __invoke(string $id)
    {
        $reasonForTrip = $this->finder->__invoke($id);

        $this->repository->delete($reasonForTrip);
    }
}
