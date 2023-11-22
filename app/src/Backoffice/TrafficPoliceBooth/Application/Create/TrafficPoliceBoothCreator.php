<?php

namespace App\Backoffice\TrafficPoliceBooth\Application\Create;

use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBooth;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class TrafficPoliceBoothCreator
{
    private TrafficPoliceBoothRepository $repository;

    private UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification;

    private EventBus $bus;

    public function __construct(
        TrafficPoliceBoothRepository                     $repository,
        UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification,
        EventBus                                         $bus
    )
    {

        $this->repository                                       = $repository;
        $this->uniqueTrafficPoliceBoothDescriptionSpecification = $uniqueTrafficPoliceBoothDescriptionSpecification;
        $this->bus                                              = $bus;
    }

    public function __invoke(
        string $id,
        string $description
    )
    {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $trafficPoliceBooth = TrafficPoliceBooth::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueTrafficPoliceBoothDescriptionSpecification
        );

        $this->repository->save($trafficPoliceBooth);

        $this->bus->publish(...$trafficPoliceBooth->pullDomainEvents());
    }
}
