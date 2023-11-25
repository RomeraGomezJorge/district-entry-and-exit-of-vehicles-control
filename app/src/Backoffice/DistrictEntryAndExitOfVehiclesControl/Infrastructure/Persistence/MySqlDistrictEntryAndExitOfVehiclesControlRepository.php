<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Infrastructure\Persistence;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControl;
use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Shared\Domain\Criteria\Criteria;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;

final class MySqlDistrictEntryAndExitOfVehiclesControlRepository extends DoctrineRepository implements DistrictEntryAndExitOfVehiclesControlRepository
{
    const NOT_PASSENGERS_FOUND_AFTER_SEARCH = [];
    const NO_RESULTS_FOUND = [];
    const NOT_SETTING_VALUE = null;
    private ?int $totalMatchingRows = null;

    public function save(DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl): void
    {
        $this->persist($districtEntryAndExitOfVehiclesControl);
    }

    public function search(Uuid $id): ?DistrictEntryAndExitOfVehiclesControl
    {
        return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)->find($id);
    }

    public function searchAll(): array
    {
        return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)->findAll();
    }

    public function isDescriptionExits(array $criteria): bool
    {
        $isUnique = (bool)$this->repository(DistrictEntryAndExitOfVehiclesControl::class)->findOneBy($criteria);

        return $isUnique;
    }

    public function matching(Criteria $criteria, ?array $vehiclePassengersFound): array
    {
        $matching = $this->getMatchingFrom($criteria, $vehiclePassengersFound);

        $this->totalMatchingRows = ($matching === self::NO_RESULTS_FOUND)
            ? 0
            : $matching->count();

        return ($matching === self::NO_RESULTS_FOUND)
            ? self::NO_RESULTS_FOUND
            : $matching->toArray();
    }

    public function totalMatchingRows(Criteria $criteria, ?array $vehiclePassengersFound): int
    {
        if ($this->totalMatchingRows === self::NOT_SETTING_VALUE) {
            return $this->getMatchingFrom($criteria, $vehiclePassengersFound)->count();
        }

        return $this->totalMatchingRows;
    }

    public function delete(DistrictEntryAndExitOfVehiclesControl $districtEntryAndExitOfVehiclesControl): void
    {
        $this->remove($districtEntryAndExitOfVehiclesControl);
    }

    protected function getMatchingFrom(Criteria $criteria, ?array $vehiclePassengers)
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        if ($vehiclePassengers === null) {
            return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)->matching($doctrineCriteria);
        }

        if ($vehiclePassengers === self::NOT_PASSENGERS_FOUND_AFTER_SEARCH) {
            return self::NO_RESULTS_FOUND;
        }

        $passengersCriteria = $this->getCriteriaToPassengers($vehiclePassengers);

        return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)
            ->matching($passengersCriteria)
            ->matching($doctrineCriteria);
    }

    private function getCriteriaToPassengers(array $vehiclePassengers): DoctrineCriteria
    {
        $doctrineCriteria = DoctrineCriteria::create();

        foreach ($vehiclePassengers as $passenger) {
            $doctrineCriteria->orWhere(
                DoctrineCriteria::expr()->eq('id', $passenger->getDistrictEntryAndExitOfVehiclesControl()->getId())
            );
        }

        return $doctrineCriteria;
    }
}
