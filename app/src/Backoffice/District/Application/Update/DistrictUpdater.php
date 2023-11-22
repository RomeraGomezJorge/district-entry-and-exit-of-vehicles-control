<?php

namespace App\Backoffice\District\Application\Update;

use App\Backoffice\District\Application\Find\DistrictFinder;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Backoffice\District\Domain\UniqueDistrictDescriptionSpecification;

final class DistrictUpdater
{
    private DistrictRepository $repository;
    private DistrictFinder $finder;
    private UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification;

    public function __construct(
        DistrictRepository                     $repository,
        UniqueDistrictDescriptionSpecification $uniqueDistrictDescriptionSpecification
    )
    {
        $this->repository                             = $repository;
        $this->finder                                 = new DistrictFinder($repository);
        $this->uniqueDistrictDescriptionSpecification = $uniqueDistrictDescriptionSpecification;
    }

    public function __invoke(string $id, string $newDescription): void
    {
        $district = $this->finder->__invoke($id);

        $district->changeDescription(trim($newDescription), $this->uniqueDistrictDescriptionSpecification);

        $this->repository->save($district);
    }
}
