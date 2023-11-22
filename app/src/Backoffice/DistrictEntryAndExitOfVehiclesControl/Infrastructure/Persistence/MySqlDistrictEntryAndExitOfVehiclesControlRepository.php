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
    const PASSENGERS_NOT_FOUND_AFTER_SEARCH_USING_PASSENGER_CRITERIA = null;
    const NO_RESULTS_FOUND = [];
    const PASSENGER_CRITERIA_NOT_FOUND_IN_REQUEST = [];
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

        $this->totalMatchingRows = $matching->count();

        return $matching->toArray();
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

    protected function getMatchingFrom(Criteria $criteria, ?array $vehiclePassengersFound)
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        /* si no se encontraron pasajeros cuando se busco por los campos de esa entidad y tampoco
        se han  definido filtros en $criteria retorna un array vacio  */
        if ($vehiclePassengersFound === self::PASSENGERS_NOT_FOUND_AFTER_SEARCH_USING_PASSENGER_CRITERIA) {
            if (!$criteria->hasfilters()) {
                return self::NO_RESULTS_FOUND;
            }

            return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)->matching($doctrineCriteria);
        }

        /* se encontraron filtros del tipo pasajero y con esos filtros se encontraron resultados */
        if ($this->arePassengerIn($vehiclePassengersFound) and $this->arePassengerCriteriaInRequest($vehiclePassengersFound)) {
            $passengersCriteria = $this->getCriteriaToPassengers($vehiclePassengersFound);

            /*Primero aplica los criterios de busqueda de los pasajeros y a los resultados obtenidos aplica el criterios
            de buscaque enviado */
            return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)
                ->matching($passengersCriteria)
                ->matching($doctrineCriteria);
        }

        /* retorna todos los items sin nigun tipo de filtro de pasajeros */
        return $this->repository(DistrictEntryAndExitOfVehiclesControl::class)->matching($doctrineCriteria);
    }

    private function arePassengerIn(array $vehiclePassengersFound): bool
    {
        return !empty($vehiclePassengersFound);
    }

    private function arePassengerCriteriaInRequest(array $vehiclePassengersFound): bool
    {
        return ($vehiclePassengersFound === self::PASSENGER_CRITERIA_NOT_FOUND_IN_REQUEST) ? false : true;
    }

    private function getCriteriaToPassengers(?array $vehiclePassengers): ?DoctrineCriteria
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
