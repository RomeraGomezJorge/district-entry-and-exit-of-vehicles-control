<?php

namespace App\Backoffice\ReasonForTrip\Application\Update;

use App\Backoffice\ReasonForTrip\Application\Find\ReasonForTripFinder;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Backoffice\ReasonForTrip\Domain\UniqueReasonForTripDescriptionSpecification;

final class ReasonForTripUpdater
{
    private ReasonForTripRepository $repository;
    private ReasonForTripFinder $finder;
    private UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification;

    public function __construct(
        ReasonForTripRepository                     $repository,
        UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification
    )
    {
        $this->repository                                  = $repository;
        $this->finder                                      = new ReasonForTripFinder($repository);
        $this->uniqueReasonForTripDescriptionSpecification = $uniqueReasonForTripDescriptionSpecification;
    }

    public function __invoke(string $id, string $newDescription): void
    {
        $reasonForTrip = $this->finder->__invoke($id);

        $reasonForTrip->changeDescription(
            trim($newDescription),
            $this->uniqueReasonForTripDescriptionSpecification
        );

        $this->repository->save($reasonForTrip);
    }
}
