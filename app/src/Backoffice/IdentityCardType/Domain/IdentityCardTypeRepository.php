<?php

namespace App\Backoffice\IdentityCardType\Domain;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;

interface IdentityCardTypeRepository
{
    public function save(IdentityCardType $identityCardType): void;

    public function search(Uuid $id): ?IdentityCardType;

    public function searchAll(): array;

    public function matching(Criteria $criteria): array;

    public function totalMatchingRows(Criteria $criteria): int;

    public function delete(IdentityCardType $identityCardType): void;
}
