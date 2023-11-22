<?php

namespace App\Backoffice\ReasonForTrip\Domain;

interface UniqueReasonForTripDescriptionSpecification
{
    public function isSatisfiedBy(string $description): bool;
}
