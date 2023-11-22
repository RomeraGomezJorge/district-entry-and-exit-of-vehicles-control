<?php

namespace App\Backoffice\District\Domain;

interface UniqueDistrictDescriptionSpecification
{
    public function isSatisfiedBy(string $description): bool;
}
