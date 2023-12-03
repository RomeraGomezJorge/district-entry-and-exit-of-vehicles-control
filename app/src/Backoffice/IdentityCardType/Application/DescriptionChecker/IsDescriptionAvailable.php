<?php

namespace App\Backoffice\IdentityCardType\Application\DescriptionChecker;

use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification as UniqueDescriptionSpecification;

final class IsDescriptionAvailable
{
    private UniqueDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        UniqueDescriptionSpecification $uniqueDescriptionSpecification
    ) {
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueDescriptionSpecification->isSatisfiedBy($description);
    }
}
