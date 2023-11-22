<?php

namespace App\Backoffice\District\Application\Create;

use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;
use App\Shared\Domain\Bus\Event\EventBus;
use App\Shared\Domain\ValueObject\Uuid;

final class DistrictCreator
{
    private DistrictRepository $repository;

    private UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification;

    private EventBus $bus;

    public function __construct(
        DistrictRepository                     $repository,
        UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification,
        EventBus                               $bus
    )
    {
        $this->repository                             = $repository;
        $this->uniqueDistrictDescriptionSpecification = $uniqueDistrictDescriptionSpecification;
        $this->bus                                    = $bus;
    }

    public function __invoke(
        string $id,
        string $description
    )
    {
        $id = new Uuid($id);

        $createAt = new \DateTime();

        $district = District::create(
            $id,
            trim($description),
            $createAt,
            $this->uniqueDistrictDescriptionSpecification
        );

        $this->repository->save($district);

        $this->bus->publish(...$district->pullDomainEvents());
    }
}
