<?php

namespace App\Backoffice\ModelOfVehicle\Application\Shared;

use App\Backoffice\VehicleMakerName\Application\Find\VehicleMakerNameFinder;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerName;
use App\Backoffice\VehicleMakerName\Domain\VehicleMakerNameRepository;
use App\Shared\Infrastructure\Utils\FilterUtilsForFieldThatNotBelongToAnEntity;

final class FilterUtilsForModelOfVehicle
{
    private const FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM = ['vehicleMakerName'];
    private VehicleMakerNameFinder $finderVehicleMakerName;

    public function __construct(VehicleMakerNameRepository $vehicleMakerNameRepository)
    {
        $this->finderVehicleMakerName = new VehicleMakerNameFinder($vehicleMakerNameRepository);
    }

    /* Obtiene una entidad del tipo marca de vehiculo en caso que se aplique este filtro */
    public function getVehicleMakerNameFromFilterOrNull(array $filters): ?VehicleMakerName
    {
        foreach (self::FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM as $fieldName) {
            /* Verifica si en el arreglo de "$filtres" esta definido el campo  "$fieldName" */
            if (!FilterUtilsForFieldThatNotBelongToAnEntity::isDefineAsFilter($filters, $fieldName)) {
                return null;
            };

            /* Obtiene el valor asignado para el campo "$fieldName" en el arreglo "$filters" */
            $vehicleMakerNameId = FilterUtilsForFieldThatNotBelongToAnEntity::getValueFromFilters(
                $filters,
                $fieldName
            );
        }

        /*En caso que el valor asignado en el campo "self::FIELD_NAME_IN_FILTERS_TO_VEHICLE_MAKER_NAME" sea un
        id valido  retorna la entidad asignada para ese id */
        return $this->finderVehicleMakerName->__invoke($vehicleMakerNameId);
    }

    /* Remueve del arreglo $filtres todos los campos que no le correspondan a la entidad ModelOfVehicle */
    public function removeFiltersThatNotBelongToEntity($filters): array
    {
        return FilterUtilsForFieldThatNotBelongToAnEntity::removeFilterEqualsTo(
            self::FIELDS_NAME_THAT_DOES_NOT_BELONG_TO_THE_ENTITY_IN_THE_FILTER_FORM,
            $filters
        );
    }
}
