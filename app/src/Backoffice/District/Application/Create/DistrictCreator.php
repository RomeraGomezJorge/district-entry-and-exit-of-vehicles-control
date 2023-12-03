<?php

namespace App\Backoffice\District\Application\Create;

use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification as UniqueDescriptionSpecification;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class DistrictCreator
{
    private DistrictRepository $repository;
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;
    private EventBus $bus;

    public function __construct(
        DistrictRepository $repository,
        UniqueDescriptionSpecification $uniqueDescriptionSpecification,
        EventBus $bus
    ) {
        $this->repository                     = $repository;
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
        $this->bus                            = $bus;
    }

    public function __invoke(
        string $id,
        string $description
    ) {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $district = District::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueDescriptionSpecification
        );

        $this->repository->save($district);

        $this->bus->publish(...$district->pullDomainEvents());
    }
}
