<?php

namespace App\Backoffice\District\Application\Update;

use App\Backoffice\District\Application\Find\DistrictFinder;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;

final class DistrictUpdater
{
    private DistrictRepository $repository;
    private DistrictFinder $finder;
    private UniqueDistrictDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        DistrictRepository                     $repository,
        UniqueDistrictDescriptionSpecification $uniqueDescriptionSpecification
    )
    {
        $this->repository                     = $repository;
        $this->finder                         = new DistrictFinder($repository);
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $id, string $newDescription): void
    {
        $district = $this->finder->__invoke($id);

        $district->changeDescription(trim($newDescription), $this->uniqueDescriptionSpecification);

        $this->repository->save($district);
    }
}
