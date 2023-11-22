<?php

namespace App\Backoffice\TrafficPoliceBooth\Domain;

use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;

interface TrafficPoliceBoothRepository
{
    public function save(TrafficPoliceBooth $trafficPoliceBooth): void;

    public function search(Uuid $id): ?TrafficPoliceBooth;

    public function searchAll(): array;

    public function matching(Criteria $criteria): array;

    public function totalMatchingRows(Criteria $criteria): int;

    public function delete(TrafficPoliceBooth $trafficPoliceBooth): void;
}
