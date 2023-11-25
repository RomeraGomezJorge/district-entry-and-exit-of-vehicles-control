<?php

namespace App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Application\Shared;

use App\Backoffice\DistrictEntryAndExitOfVehiclesControl\Domain\DistrictEntryAndExitOfVehiclesControlRepository;
use App\Backoffice\VehiclePassenger\Application\FindByCriteriaSearcher\VehiclePassengersByCriteriaSearcher;
use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;

final class FilterUtils
{
    const FIELDS_NAME_THAT_DO_NOT_BELONG_TO_THE_ENTITY_DISTRICT_ENTRY = ['name', 'surname', 'identityCard'];

    private DistrictEntryAndExitOfVehiclesControlRepository $repository;
    private VehiclePassengersByCriteriaSearcher $vehiclePassengersByCriteriaSearcher;

    public function __construct(
        DistrictEntryAndExitOfVehiclesControlRepository $repository,
        VehiclePassengersByCriteriaSearcher             $vehiclePassengersByCriteriaSearcher
    )
    {
        $this->repository                          = $repository;
        $this->vehiclePassengersByCriteriaSearcher = $vehiclePassengersByCriteriaSearcher;
    }

    public function removeFiltersThatNotBelongToEntityIn($filters): array
    {
        return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilterEqualsTo(
            self::FIELDS_NAME_THAT_DO_NOT_BELONG_TO_THE_ENTITY_DISTRICT_ENTRY,
            $filters
        );
    }

    /* Retorna los pasajeros que se han encontrado en base a los filtros aplicados*/
    public function findPassengersByFiltersOrNull($filters, $order, $orderBy, $limit, $offset): ?array
    {
        if (!$this->hasPassengerFilters($filters)) {
            return null;
        }

        return $this->vehiclePassengersByCriteriaSearcher->__invoke(
            $filters,
            $order,
            $orderBy,
            $limit,
            $offset
        );
    }

    private function hasPassengerFilters($filters): bool
    {
        $fieldsToFilters = array_column($filters, 'field');

        foreach ($fieldsToFilters as $filterFound) {
            if (in_array($filterFound, self::FIELDS_NAME_THAT_DO_NOT_BELONG_TO_THE_ENTITY_DISTRICT_ENTRY)) {
                return true;
            }
        }

        return false;
    }
}
