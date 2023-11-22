<?php

namespace App\Backoffice\TrafficPoliceBooth\Application\DescriptionChecker;

use App\Backoffice\TrafficPoliceBooth\Domain\UniqueTrafficPoliceBoothDescriptionSpecification;

final class CheckTrafficPoliceBoothDescriptionAvailability
{
    private UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTrafficPoliceBoothDescriptionSpecification;

    public function __construct(UniqueTrafficPoliceBoothDescriptionSpecification $uniqueTagDescriptionSpecification)
    {
        $this->uniqueTrafficPoliceBoothDescriptionSpecification = $uniqueTagDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueTrafficPoliceBoothDescriptionSpecification->isSatisfiedBy(trim($description));
    }
}
