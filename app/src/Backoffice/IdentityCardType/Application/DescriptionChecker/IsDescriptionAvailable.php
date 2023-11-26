<?php

namespace App\Backoffice\IdentityCardType\Application\DescriptionChecker;

use App\Backoffice\IdentityCardType\Domain\UniqueIdentityCardTypeDescriptionSpecification;

final class IsDescriptionAvailable
{
    private UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification;

    public function __construct(
        UniqueIdentityCardTypeDescriptionSpecification $uniqueDescriptionSpecification
    )
    {
        $this->uniqueDescriptionSpecification = $uniqueDescriptionSpecification;
    }

    public function __invoke(string $description): bool
    {
        return $this->uniqueDescriptionSpecification->isSatisfiedBy($description);
    }
}
