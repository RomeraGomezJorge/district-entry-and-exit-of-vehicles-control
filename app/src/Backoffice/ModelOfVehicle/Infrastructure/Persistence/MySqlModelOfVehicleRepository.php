<?php

namespace App\Backoffice\ModelOfVehicle\Infrastructure\Persistence;

use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicle;
use App\Backoffice\ModelOfVehicle\Domain\ModelOfVehicleRepository;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Shared\Infrastructure\Utils\StringUtils;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;

final class MySqlModelOfVehicleRepository extends DoctrineRepository implements ModelOfVehicleRepository
{
    private const NOT_SETTING_VALUE = null;
    private const ENTITY_CLASS = ModelOfVehicle::class;
    private const DESCRIPTION_IS_NOT_IN_USE = false;
    private const DESCRIPTION_HAS_ALREADY_BEEN_CREATED_FOR_THIS_VEHICLE_MAKER_NAME = true;
    private const NOT_FOUND = null;
    private ?int $totalMatchingRows = null;

    public function save(ModelOfVehicle $district): void
    {
        $this->persist($district);
    }

    public function search(Uuid $id): ?ModelOfVehicle
    {
        return $this->repository(self::ENTITY_CLASS)->find($id);
    }

    public function searchAll(): array
    {
        return $this->repository(self::ENTITY_CLASS)->findAll();
    }

    public function isDescriptionExits(
        string $description,
        ?string $makerNameId
    ): bool {
        $modelsOfVehicle = $this->repository(self::ENTITY_CLASS)->findBy(['description' => $description]);

        if (!$this->isDescriptionWasFound($modelsOfVehicle)) {
            return self::DESCRIPTION_IS_NOT_IN_USE;
        }

        return $this->isModelDescriptionCreatedForMaker($makerNameId, $modelsOfVehicle);
    }

    private function isDescriptionWasFound(array $modelsOfVehicleFound): bool
    {
        return !empty($modelsOfVehicleFound);
    }

    private function isModelDescriptionCreatedForMaker(?string $makerNameId,array $modelsOfVehicle): bool
    {
        foreach ($modelsOfVehicle as $modelOfVehicle) {
            if (
                !StringUtils::equals(
                    $makerNameId,
                    $modelOfVehicle->getVehicleMakerName()->getId()
                )
            ) {
                continue;
            }

            return self::DESCRIPTION_HAS_ALREADY_BEEN_CREATED_FOR_THIS_VEHICLE_MAKER_NAME;
        }

        return self::DESCRIPTION_IS_NOT_IN_USE;
    }

    public function matching(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): array
    {
        $matching = $this->getMatchingFrom($criteria, $vehicleMakerName);

        $this->totalMatchingRows = $matching->count();

        return $matching->toArray();
    }

    private function getMatchingFrom(Criteria $criteria, $vehicleMakerNameFound): Collection
    {
        $doctrineCriteria = $this->isFoundAddAsCriteria($vehicleMakerNameFound, $criteria);

        return $this->repository(self::ENTITY_CLASS)->matching($doctrineCriteria);
    }

    private function isFoundAddAsCriteria(?VehicleMakerName $makerNameFound, Criteria $criteria): DoctrineCriteria
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        if ($makerNameFound === self::NOT_FOUND) {
            return $doctrineCriteria;
        }

        return $doctrineCriteria->andWhere(
            DoctrineCriteria::expr()->eq('vehicleMakerName', $makerNameFound)
        );
    }

    public function totalMatchingRows(Criteria $criteria, ?VehicleMakerName $vehicleMakerName): int
    {
        if ($this->totalMatchingRows === self::NOT_SETTING_VALUE) {
            return $this->getMatchingFrom($criteria, $vehicleMakerName)->count();
        }

        return $this->totalMatchingRows;
    }

    public function delete(ModelOfVehicle $district): void
    {
        $this->remove($district);
    }
}
