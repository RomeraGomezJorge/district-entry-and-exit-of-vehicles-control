<?php

namespace App\Backoffice\District\Infrastructure\Persistence;

use App\Backoffice\District\Domain\District;
use App\Backoffice\District\Domain\DistrictRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Collection;

final class MySqlDistrictRepository extends DoctrineRepository implements DistrictRepository
{
    const NOT_SETTING_VALUE = null;
    const ENTITY_CLASS = District::class;
    private ?int $totalMatchingRows = null;

    public function save(District $district): void
    {
        $this->persist($district);
    }

    public function search(Uuid $id): ?District
    {
        return $this->repository(self::ENTITY_CLASS)->find($id);
    }

    public function searchAll(): array
    {
        return $this->repository(self::ENTITY_CLASS)->findAll();
    }

    public function isDescriptionExits(string $description): bool
    {
        return (bool)$this->repository(self::ENTITY_CLASS)->findOneBy(['description' => $description]);
    }

    public function matching(Criteria $criteria): array
    {
        $matching = $this->getMatchingFrom($criteria);

        $this->totalMatchingRows = $matching->count();

        return $matching->toArray();
    }

    public function totalMatchingRows(Criteria $criteria): int
    {
        if ($this->totalMatchingRows === self::NOT_SETTING_VALUE) {
            return $this->getMatchingFrom($criteria)->count();
        }

        return $this->totalMatchingRows;
    }

    public function delete(District $district): void
    {
        $this->remove($district);
    }

    private function getMatchingFrom(Criteria $criteria): Collection
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        return $this->repository(self::ENTITY_CLASS)->matching($doctrineCriteria);
    }
}
