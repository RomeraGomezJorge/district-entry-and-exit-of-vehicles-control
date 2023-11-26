<?php

namespace App\Backoffice\ReasonForTrip\Application\Create;

use App\Backoffice\ReasonForTrip\Domain\ReasonForTrip;
use App\Backoffice\ReasonForTrip\Domain\ReasonForTripRepository;
use App\Backoffice\ReasonForTrip\Domain\UniqueReasonForTripDescriptionSpecification;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class ReasonForTripCreator
{
    private ReasonForTripRepository $repository;

    private UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification;

    private EventBus $bus;

    public function __construct(
        ReasonForTripRepository $repository,
        UniqueReasonForTripDescriptionSpecification $uniqueReasonForTripDescriptionSpecification,
        EventBus $bus
    ) {
        $this->repository                                  = $repository;
        $this->uniqueReasonForTripDescriptionSpecification = $uniqueReasonForTripDescriptionSpecification;
        $this->bus                                         = $bus;
    }

    public function __invoke(
        string $id,
        string $description
    ) {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $reasonForTrip = ReasonForTrip::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueReasonForTripDescriptionSpecification
        );

        $this->repository->save($reasonForTrip);

        $this->bus->publish(...$reasonForTrip->pullDomainEvents());
    }
}
