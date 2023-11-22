<?php

namespace App\Backoffice\TrafficPoliceBooth\Application\Update;

use App\Backoffice\TrafficPoliceBooth\Application\Find\TrafficPoliceBoothFinder;
use App\Backoffice\TrafficPoliceBooth\Domain\TrafficPoliceBoothRepository;
use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;

final class TrafficPoliceBoothUpdater
{
    private TrafficPoliceBoothRepository $repository;
    private TrafficPoliceBoothFinder $finder;
    private UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification;

    public function __construct(
        TrafficPoliceBoothRepository                     $repository,
        UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification
    )
    {
        $this->repository                                       = $repository;
        $this->finder                                           = new TrafficPoliceBoothFinder($repository);
        $this->uniqueTrafficPoliceBoothDescriptionSpecification = $uniqueTrafficPoliceBoothDescriptionSpecification;
    }

    public function __invoke(string $id, string $newDescription)
    {
        $trafficPoliceBooth = $this->finder->__invoke($id);

        $trafficPoliceBooth->changeDescription(
            trim($newDescription),
            $this->uniqueTrafficPoliceBoothDescriptionSpecification
        );

        $this->repository->save($trafficPoliceBooth);
    }
}
